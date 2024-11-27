<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('game_matches', function (Blueprint $table) {
            $table->id(); // Уникальный идентификатор записи
            $table->string('team_a'); // Название первой команды
            $table->string('team_b'); // Название второй команды
            $table->string('score'); // Счёт матча
            $table->timestamps(); // Временные метки: created_at и updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_matches');
    }
};

