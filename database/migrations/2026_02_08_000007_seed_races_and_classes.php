<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('races')->insertOrIgnore([
            ['race_id' => 1, 'name' => 'Человек', 'faction' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['race_id' => 2, 'name' => 'Орк', 'faction' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['race_id' => 3, 'name' => 'Дворф', 'faction' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['race_id' => 4, 'name' => 'Ночной эльф', 'faction' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['race_id' => 5, 'name' => 'Нежить', 'faction' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['race_id' => 6, 'name' => 'Таурен', 'faction' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['race_id' => 7, 'name' => 'Гном', 'faction' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['race_id' => 8, 'name' => 'Тролль', 'faction' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['race_id' => 10, 'name' => 'Эльф крови', 'faction' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['race_id' => 11, 'name' => 'Дреней', 'faction' => 0, 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('character_classes')->insertOrIgnore([
            ['class_id' => 1, 'name' => 'Воин', 'created_at' => now(), 'updated_at' => now()],
            ['class_id' => 2, 'name' => 'Паладин', 'created_at' => now(), 'updated_at' => now()],
            ['class_id' => 3, 'name' => 'Охотник', 'created_at' => now(), 'updated_at' => now()],
            ['class_id' => 4, 'name' => 'Разбойник', 'created_at' => now(), 'updated_at' => now()],
            ['class_id' => 5, 'name' => 'Жрец', 'created_at' => now(), 'updated_at' => now()],
            ['class_id' => 6, 'name' => 'Рыцарь смерти', 'created_at' => now(), 'updated_at' => now()],
            ['class_id' => 7, 'name' => 'Шаман', 'created_at' => now(), 'updated_at' => now()],
            ['class_id' => 8, 'name' => 'Маг', 'created_at' => now(), 'updated_at' => now()],
            ['class_id' => 9, 'name' => 'Чернокнижник', 'created_at' => now(), 'updated_at' => now()],
            ['class_id' => 11, 'name' => 'Друид', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        DB::table('races')->whereIn('race_id', [1, 2, 3, 4, 5, 6, 7, 8, 10, 11])->delete();
        DB::table('character_classes')->whereIn('class_id', [1, 2, 3, 4, 5, 6, 7, 8, 9, 11])->delete();
    }
};
