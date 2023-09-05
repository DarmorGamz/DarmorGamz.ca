<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//php artisan make:model UserSpotify
class UserSpotify extends Model {
    use HasFactory;
    protected $table = 'user_spotify';
    protected $fillable = [
        'user_id',
        'spotify_username',
        'access_token',
        'refresh_token',
        'token_expires_at',
    ];
}
