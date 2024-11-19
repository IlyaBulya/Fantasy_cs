<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TranslationsController extends Controller
{
    public function index()
    {
        return view('translations'); // Возвращаем представление для страницы Translations
    }
}
