<?php
namespace App\Http\Controllers;

use App\Models\UserSpotify;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class SpotifyController extends Controller {
    protected $accessToken;

    public function __construct() {
        // Check if the access token is already cached
        $this->accessToken = cache('spotify_access_token');

        if (!$this->accessToken) {
            // If not, obtain a new access token and cache it
            $client = new Client();
            $response = $client->post('https://accounts.spotify.com/api/token', [
                'form_params' => [
                    'grant_type' => 'client_credentials',
                    'client_id' => env('SPOTIFY_CLIENT_ID'),
                    'client_secret' => env('SPOTIFY_CLIENT_SECRET'),
                ],
            ]);

            $data = json_decode($response->getBody());
            $this->accessToken = $data->access_token;

            // Cache the access token with an expiration time (e.g., 1 hour)
            cache(['spotify_access_token' => $this->accessToken], now()->addHours(1));
        }
    }
    public function redirectToSpotify() {
        $scopes = ['user-read-email', 'user-library-read', 'user-read-currently-playing', 'user-read-playback-state, user-modify-playback-state']; // Define the required scopes

        $query = http_build_query([
            'client_id' => env('SPOTIFY_CLIENT_ID'),
            'redirect_uri' => env('SPOTIFY_REDIRECT_URI'),
            'scope' => implode(' ', $scopes),
            'response_type' => 'code',
        ]);

        return Redirect::to("https://accounts.spotify.com/authorize?$query");
    }

    public static function getNewRefreshToken(): void {
        $refreshToken = Auth::user()->UserSpotify->refresh_token;

        $client = new Client();

        $response = $client->post('https://accounts.spotify.com/api/token', [
            'form_params' => [
                'grant_type' => 'refresh_token',
                'refresh_token' => $refreshToken,
                'client_id' => env('SPOTIFY_CLIENT_ID'),
                'client_secret' => env('SPOTIFY_CLIENT_SECRET'),
            ],
        ]);

        $data = json_decode($response->getBody());

        // Store the access token, refresh token, and token expiration in the user's user_spotify record
        $user = Auth::user();
        $userSpotify = UserSpotify::where('user_id', $user->id)->firstOrNew();
        $userSpotify->access_token = $data->access_token;
        $userSpotify->token_expires_at = now()->addSeconds($data->expires_in);

        $userSpotify->save();
    }
    public function handleSpotifyCallback(Request $request) {
        $code = $request->input('code');

        $client = new Client();
        $response = $client->post('https://accounts.spotify.com/api/token', [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => env('SPOTIFY_REDIRECT_URI'),
                'client_id' => env('SPOTIFY_CLIENT_ID'),
                'client_secret' => env('SPOTIFY_CLIENT_SECRET'),
            ],
        ]);

        $data = json_decode($response->getBody());

        // Store the access token, refresh token, and token expiration in the user's user_spotify record
        $user = Auth::user();
        $userSpotify = UserSpotify::where('user_id', $user->id)->firstOrNew();

        $userSpotify->user_id = $user->id;
        $userSpotify->spotify_username = $user->email; // Change this to the actual Spotify username
        $userSpotify->access_token = $data->access_token;
        $userSpotify->refresh_token = $data->refresh_token;
        $userSpotify->token_expires_at = now()->addSeconds($data->expires_in);

        $userSpotify->save();

        // Redirect the user to the desired page
        return redirect('/spotify');
    }

    public function getAccessToken() {
        return $this->accessToken;
    }

    public static function getCurrentTrack() {
        if (Auth::user()->UserSpotify->token_expires_at < now()) {
            self::getNewRefreshToken();
        }

        $client = new Client();
        $response = $client->get('https://api.spotify.com/v1/me/player/currently-playing', [
            'headers' => [
                'Authorization' => 'Bearer ' . Auth::user()->UserSpotify->access_token,
            ],
        ]);

        $data = json_decode($response->getBody());

        // Check if the user is currently listening to a track
        if ($response->getStatusCode() == 200) {
            $currentTrack = $data->item;

            $iArtistCount = count($currentTrack->artists);
            $sArtistName = "";
            foreach ($currentTrack->artists as $i => $aArtists) {
                $sArtistName .= $aArtists->name;
                if ($i != $iArtistCount-1) $sArtistName .= ", ";
            }
            // Copy Artist name string over response.
            $currentTrack->artists = $sArtistName;
            $currentTrack->imageUrl = $currentTrack->album->images[1]->url;

            // Return the current track data as JSON response
            return response()->json(['current_track' => $currentTrack]);

        } else {
            $currentTrack['name'] = "Not Current Playing";
            $currentTrack['artists'] = "Dj Darmor";
            $currentTrack['imageUrl'] = "https://www.gothiccountry.se/images/pictures2/no_album_art__no_cover.jpg";

            // Return the current track data as JSON response
            return response()->json(['current_track' => $currentTrack]);
        }
    }

    public static function previousTrack() {
        if (Auth::user()->UserSpotify->token_expires_at < now()) {
            self::getNewRefreshToken();
        }

        $client = new Client();
        $response = $client->post('https://api.spotify.com/v1/me/player/previous', [
            'headers' => [
                'Authorization' => 'Bearer ' . Auth::user()->UserSpotify->access_token,
            ],
        ]);

        $data = json_decode($response->getBody());

        // Check if the user is currently listening to a track
        if ($response->getStatusCode() == 200) {

        } else {

        }

    }
    public static function nextTrack() {
        if (Auth::user()->UserSpotify->token_expires_at < now()) {
            self::getNewRefreshToken();
        }

        $client = new Client();
        $response = $client->post('https://api.spotify.com/v1/me/player/next', [
            'headers' => [
                'Authorization' => 'Bearer ' . Auth::user()->UserSpotify->access_token,
            ],
        ]);

        $data = json_decode($response->getBody());

        // Check if the user is currently listening to a track
        if ($response->getStatusCode() == 200) {

        } else {

        }
    }

    public static function playpauseTrack() {
        if (Auth::user()->UserSpotify->token_expires_at < now()) {
            self::getNewRefreshToken();
        }

        $client = new Client();
        if (self::getIsPlaying()) {
            $response = $client->put('https://api.spotify.com/v1/me/player/pause', [
                'headers' => [
                    'Authorization' => 'Bearer ' . Auth::user()->UserSpotify->access_token,
                ],
            ]);
        } else {
            $response = $client->put('https://api.spotify.com/v1/me/player/play', [
                'headers' => [
                    'Authorization' => 'Bearer ' . Auth::user()->UserSpotify->access_token,
                ],
            ]);
        }

        $data = json_decode($response->getBody());

        // Check if the user is currently listening to a track
        if ($response->getStatusCode() == 200) {

        } else {

        }
    }

    public static function getDevices() {
        if (Auth::user()->UserSpotify->token_expires_at < now()) {
            self::getNewRefreshToken();
        }

        $client = new Client();
        $response = $client->get('https://api.spotify.com/v1/me/player/devices', [
            'headers' => [
                'Authorization' => 'Bearer ' . Auth::user()->UserSpotify->access_token,
            ],
        ]);

        $data = json_decode($response->getBody());

        // Check if the user is currently listening to a track
        if ($response->getStatusCode() == 200) {
            return $data->devices[0];
        } else {

        }
    }

    public static function getIsPlaying() {
        if (Auth::user()->UserSpotify->token_expires_at < now()) {
            self::getNewRefreshToken();
        }

        $client = new Client();
        $response = $client->get('https://api.spotify.com/v1/me/player', [
            'headers' => [
                'Authorization' => 'Bearer ' . Auth::user()->UserSpotify->access_token,
            ],
        ]);

        $data = json_decode($response->getBody());

        // Check if the user is currently listening to a track
        if ($response->getStatusCode() == 200) {
            return $data->is_playing;
        } else {

        }
    }

}
