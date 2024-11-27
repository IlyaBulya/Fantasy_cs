<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class SteamAuthController extends Controller
{
    private $clientId;
    private $redirectUri;

    public function __construct()
    {
        $this->clientId = env('STEAM_CLIENT_ID'); // Добавьте в .env
        $this->redirectUri = env('STEAM_REDIRECT_URI');
    }

    public function redirectToSteam()
    {
        $authUrl = "https://steamcommunity.com/oauth/login"
            . "?response_type=token"
            . "&client_id={$this->clientId}"
            . "&redirect_uri={$this->redirectUri}";
        
        return redirect($authUrl);
    }

    public function handleSteamCallback()
    {
        // Получаем токен из URL
        $accessToken = request()->query('access_token');

        if (!$accessToken) {
            return redirect('/login')->with('error', 'Steam login failed or access denied.');
        }

        // Получаем данные пользователя через Steam API
        $response = Http::get("https://api.steampowered.com/ISteamUserOAuth/GetTokenDetails/v1/", [
            'access_token' => $accessToken,
        ]);

        if ($response->failed()) {
            return redirect('/login')->with('error', 'Failed to fetch Steam user data.');
        }

        $steamData = $response->json();

        if (!isset($steamData['response']['steamid'])) {
            return redirect('/login')->with('error', 'Failed to retrieve Steam ID.');
        }

        $steamId = $steamData['response']['steamid'];

        // Ищем пользователя по steam_id или создаём нового
        $user = User::firstOrCreate(
            ['steam_id' => $steamId],
            [
                'name' => "SteamUser_{$steamId}", // Имя по умолчанию
                'email' => null, // Steam не предоставляет email
                'password' => bcrypt('steam_' . $steamId), // Генерация пароля
            ]
        );

        // Авторизация пользователя
        Auth::login($user);

        return redirect('/')->with('success', 'Successfully logged in through Steam!');
    }
}
