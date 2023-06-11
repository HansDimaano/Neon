<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Broadcast channel for App\Models\User with dynamic {id}
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    // Check if the authenticated user's ID matches the provided ID
    return (int) $user->id === (int) $id;
});
?>