<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->text('content')->nullable()->after('text');
            if (Schema::hasColumn('news', 'link')) {
                $table->dropColumn('link');
            }
        });
    }

    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('content');
            $table->string('link', 255)->nullable();
        });
    }
};
