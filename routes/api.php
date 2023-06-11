<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route to retrieve the authenticated user's information
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return Auth::user();
});

// Route for user registration
Route::post('/register', [App\Http\Controllers\api\AuthController::class, 'register']);

// Route for user login
Route::post('/login', [App\Http\Controllers\api\AuthController::class, 'login']);

// Route to refresh the authentication token
Route::post('/refreshToken', [App\Http\Controllers\api\AuthController::class, 'refresh']);

// Route to log out the authenticated user
Route::middleware('auth:api')->post('/logout', [App\Http\Controllers\api\AuthController::class, 'logout']);
?>