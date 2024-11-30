<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tournament;
use Carbon\Carbon;

class TournamentSeeder extends Seeder
{
    public function run(): void
    {
        Tournament::create([
            'name' => 'Чемпионат России 2024',
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addMonths(3),
        ]);

        Tournament::create([
            'name' => 'Кубок России 2024',
            'start_date' => Carbon::now()->addMonth(),
            'end_date' => Carbon::now()->addMonths(4),
        ]);
    }
}