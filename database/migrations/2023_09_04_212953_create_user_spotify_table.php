<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//php artisan make:migration create_user_spotify_table
//php artisan migrate

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_spotify', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('spotify_username');
            $table->string('access_token');
            $table->string('refresh_token');
            $table->timestamp('token_expires_at')->nullable();
            $table->timestamps();

            // Define a foreign key relationship with the 'users' table
            $table->foreign('user_id')->references('id')->on('users');

            // You can add more columns as needed
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_spotify');
    }
};
