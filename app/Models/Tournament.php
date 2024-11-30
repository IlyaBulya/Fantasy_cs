<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_date',
        'end_date'
    ];

    public function fantasyTournaments(): HasMany
    {
        return $this->hasMany(FantasyTournament::class);
    }

    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }
}