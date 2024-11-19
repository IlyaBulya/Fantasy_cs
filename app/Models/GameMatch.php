<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameMatch extends Model
{
    use HasFactory;

    /**
     * Разрешённые для массового заполнения поля.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'team_a',
        'team_b',
        'score',
    ];
}

