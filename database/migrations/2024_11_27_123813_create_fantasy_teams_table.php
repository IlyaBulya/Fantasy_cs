<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fantasy_teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fantasy_tournament_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->json('players')->nullable(); // Добавляем поле для хранения игроков в JSON формате
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fantasy_teams');
    }
};