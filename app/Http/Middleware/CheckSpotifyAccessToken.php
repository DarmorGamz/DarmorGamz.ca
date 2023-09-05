<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

//php artisan make:middleware CheckSpotifyAccessToken
class CheckSpotifyAccessToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        // Check if the user is authenticated and has a valid access token
        if (Auth::check() && !empty(Auth::user()->UserSpotify->access_token)) {
            return $next($request);
        }

        // Redirect to the /auth/spotify route for authentication
        return redirect('/auth/spotify');
    }
}
