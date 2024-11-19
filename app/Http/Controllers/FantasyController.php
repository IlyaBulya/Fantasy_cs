<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FantasyController extends Controller
{
    public function index()
    {
        return view('fantasy'); // Возвращаем представление для страницы Fantasy
    }
}
