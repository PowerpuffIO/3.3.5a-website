<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'name')) {
            DB::statement('ALTER TABLE users MODIFY name VARCHAR(255) NULL');
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'name')) {
            DB::statement('ALTER TABLE users MODIFY name VARCHAR(255) NOT NULL');
        }
    }
};
