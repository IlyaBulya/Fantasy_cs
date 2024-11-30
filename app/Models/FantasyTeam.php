<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FantasyTeam extends Model
{
    use HasFactory;

    protected $fillable = [
        'fantasy_tournament_id',
        'name',
        'players'
    ];

    protected $casts = [
        'players' => 'array'
    ];

    public function fantasyTournament(): BelongsTo
    {
        return $this->belongsTo(FantasyTournament::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
} 