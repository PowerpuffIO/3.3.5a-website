<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('main', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->nullable();
            $table->string('description', 255)->nullable();
            $table->string('main__title', 255)->nullable();
            $table->string('main__text', 255)->nullable();
            $table->string('discord', 255)->nullable();
            $table->string('forum', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('main');
    }
};
