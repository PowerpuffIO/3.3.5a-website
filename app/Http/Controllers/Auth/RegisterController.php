<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\SRP6Service;
use App\Services\RecaptchaService;
use App\Models\User;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    protected $srp6Service;
    protected $recaptchaService;

    public function __construct(SRP6Service $srp6Service, RecaptchaService $recaptchaService)
    {
        $this->srp6Service = $srp6Service;
        $this->recaptchaService = $recaptchaService;
    }

    public function showRegistrationForm()
    {
        $settings = SiteSetting::first();
        return view('auth.register', compact('settings'));
    }

    public function register(Request $request)
    {
        $rules = [
            'username' => 'required|string|max:14|regex:/^[a-zA-Z]+$/',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'string', 'min:8', 'confirmed', Password::defaults()],
        ];

        $messages = [
            'username.regex' => 'Логин должен содержать только латинские буквы',
        ];

        // Add reCAPTCHA validation only if configured
        if (config('recaptcha.secret_key')) {
            $rules['recaptcha_token'] = 'required|string';
            $messages['recaptcha_token.required'] = 'Ошибка проверки reCAPTCHA. Пожалуйста, обновите страницу и попробуйте снова.';
        }

        $request->validate($rules, $messages);

        // Verify reCAPTCHA token if configured
        if (config('recaptcha.secret_key') && !$this->recaptchaService->verify($request->recaptcha_token ?? '', $request->ip())) {
            return response()->json([
                'status' => false,
                'message' => 'Ошибка проверки reCAPTCHA. Пожалуйста, обновите страницу и попробуйте снова.',
            ], 422);
        }

        $existingUser = User::where('username', $request->username)->first();

        if ($existingUser) {
            return response()->json([
                'status' => false,
                'type' => 1,
                'message' => 'Такой логин уже существует',
                'fields' => ['username']
            ], 422);
        }

        try {
            DB::beginTransaction();

            [$salt, $verifier] = $this->srp6Service->getRegistrationData(
                strtoupper($request->username),
                $request->password
            );

            // Создаем аккаунт в игровой базе данных (auth)
            // Проверяем, существует ли уже аккаунт с таким username в игровой БД
            $existingGameAccount = DB::connection('game_auth')->table('account')
                ->where('username', strtoupper($request->username))
                ->first();
            
            if ($existingGameAccount) {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'type' => 1,
                    'message' => 'Такой логин уже существует в игровой базе данных',
                    'fields' => ['username']
                ], 422);
            }

            try {
                // Вставляем аккаунт в игровую БД с бинарными данными salt и verifier
                DB::connection('game_auth')->table('account')->insert([
                    'username' => strtoupper($request->username),
                    'email' => $request->email,
                    'salt' => $salt, // Бинарные данные, не base64
                    'verifier' => $verifier, // Бинарные данные, не base64
                    'totaltime' => 0,
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Game account creation error: ' . $e->getMessage(), [
                    'trace' => $e->getTraceAsString(),
                    'username' => $request->username
                ]);
                
                return response()->json([
                    'status' => false,
                    'message' => 'Ошибка при создании игрового аккаунта: ' . $e->getMessage(),
                ], 500);
            }

            // Создаем аккаунт на сайте
            $columns = ['username', 'email', 'salt', 'verifier', 'password', 'bonuses', 'votes', 'is_admin', 'created_at', 'updated_at'];
            $values = [
                $request->username,
                $request->email,
                base64_encode($salt),
                base64_encode($verifier),
                Hash::make($request->password, ['rounds' => 12]),
                0,
                0,
                0,
                now(),
                now(),
            ];

            if (Schema::hasColumn('users', 'name')) {
                $columns[] = 'name';
                $values[] = $request->username;
            }

            $placeholders = implode(',', array_fill(0, count($values), '?'));
            $columnsList = implode(', ', $columns);
            
            DB::statement("INSERT INTO users ({$columnsList}) VALUES ({$placeholders})", $values);

            $user = User::where('username', $request->username)->first();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Registration error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'status' => false,
                'message' => 'Ошибка при регистрации: ' . $e->getMessage(),
            ], 500);
        }

        Auth::login($user);

        return response()->json([
            'status' => true,
            'message' => 'Регистрация прошла успешно!',
            'redirect' => route('cabinet')
        ]);

    }
}
