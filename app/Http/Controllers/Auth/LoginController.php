<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\SRP6Service;
use App\Services\RecaptchaService;
use App\Models\User;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    protected $srp6Service;
    protected $recaptchaService;

    public function __construct(SRP6Service $srp6Service, RecaptchaService $recaptchaService)
    {
        $this->srp6Service = $srp6Service;
        $this->recaptchaService = $recaptchaService;
    }

    public function showLoginForm()
    {
        $settings = SiteSetting::first();
        return view('auth.login', compact('settings'));
    }

    public function login(Request $request)
    {
        $rules = [
            'username' => 'required|string|max:14',
            'password' => 'required|string|min:8',
        ];

        $messages = [];

        // Add reCAPTCHA validation only if configured
        if (config('recaptcha.secret_key')) {
            $rules['recaptcha_token'] = 'required|string';
            $messages['recaptcha_token.required'] = 'Ошибка проверки reCAPTCHA. Пожалуйста, обновите страницу и попробуйте снова.';
        }

        $request->validate($rules, $messages);

        // Verify reCAPTCHA token if configured
        if (config('recaptcha.secret_key') && !$this->recaptchaService->verify($request->recaptcha_token ?? '', $request->ip())) {
            throw ValidationException::withMessages([
                'username' => ['Ошибка проверки reCAPTCHA. Пожалуйста, обновите страницу и попробуйте снова.'],
            ]);
        }

        $user = User::where('username', $request->username)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'username' => ['Неверный логин или пароль'],
            ]);
        }

        $saltRaw = $user->getRawOriginal('salt');
        $verifierRaw = $user->getRawOriginal('verifier');

        if (is_resource($saltRaw)) {
            $salt = stream_get_contents($saltRaw);
        } elseif (is_string($saltRaw)) {
            $decoded = base64_decode($saltRaw, true);
            $salt = $decoded !== false ? $decoded : $saltRaw;
        } else {
            $salt = $saltRaw;
        }

        if (is_resource($verifierRaw)) {
            $verifier = stream_get_contents($verifierRaw);
        } elseif (is_string($verifierRaw)) {
            $decoded = base64_decode($verifierRaw, true);
            $verifier = $decoded !== false ? $decoded : $verifierRaw;
        } else {
            $verifier = $verifierRaw;
        }

        if (!$this->srp6Service->verifyLogin(
            strtoupper($request->username),
            $request->password,
            $salt,
            $verifier
        )) {
            throw ValidationException::withMessages([
                'username' => ['Неверный логин или пароль'],
            ]);
        }

        Auth::login($user, $request->boolean('remember'));

        $request->session()->regenerate();

        return response()->json([
            'status' => true,
            'redirect' => route('cabinet')
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
