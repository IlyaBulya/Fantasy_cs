<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FantasyTournament extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'tournament_id',
        'start_date',
        'end_date'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }

    public function fantasyTeams(): HasMany
    {
        return $this->hasMany(FantasyTeam::class);
    }

    /**
     * Получить команду, связанную с турниром
     */
    public function team(): HasOne
    {
        return $this->hasOne(FantasyTeam::class);
    }

    protected static function booted()
    {
        static::creating(function ($fantasyTournament) {
            if (!$fantasyTournament->user_id) {
                $fantasyTournament->user_id = auth()->id();
            }
        });
    }
} 