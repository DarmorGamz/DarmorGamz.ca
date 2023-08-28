<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class SpotifyController extends Controller {
    public static function getStats() {
        $response = Http::get('https://api.github.com/users/DarmorGamz');
        return response()->json($response);
    }
}
