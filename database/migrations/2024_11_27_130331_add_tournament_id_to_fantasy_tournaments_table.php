<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('fantasy_tournaments', function (Blueprint $table) {
            // Проверяем существование индекса перед его созданием
            if (!Schema::hasIndex('fantasy_tournaments', 'fantasy_tournaments_user_id_tournament_id_unique')) {
                $table->unique(['user_id', 'tournament_id']);
            }
        });
    }

    public function down()
    {
        Schema::table('fantasy_tournaments', function (Blueprint $table) {
            // Проверяем существование индекса перед его удалением
            if (Schema::hasIndex('fantasy_tournaments', 'fantasy_tournaments_user_id_tournament_id_unique')) {
                $table->dropUnique(['user_id', 'tournament_id']);
            }
        });
    }
};