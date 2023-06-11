<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Http;

trait AdvancedApiTokenTrait
{

    public static function getPasswordGrantToken($username, $password){

        $token_url = config('app.url').'/oauth/token';

        $response = Http::asForm()->post( $token_url, [
            'grant_type' => 'password',
            'client_id' => config('app.client_id'),
            'client_secret' => config('app.client_secret'),
            'username' => $username,
            'password' => $password,
            'scope' => '*',
        ]);

        return $response;
    }

    public static function getTokenFromRefreshToken($token){

        $token_refresh_url = config('app.url').'/oauth/token';

        $response = Http::asForm()->post( $token_refresh_url, [
            'grant_type' => 'refresh_token',
            'refresh_token' => $token,
            'client_id' => config('app.client_id'),
            'client_secret' => config('app.client_secret'),
            'scope' => '*',
        ]);

        return $response;
    }
}