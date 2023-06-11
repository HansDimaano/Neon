<?php

// Enable authentication routes with email verification
Auth::routes(['verify' => true]);

// Route for the root URL
Route::get('/', function () {
    // Check if the user is authenticated
    if (Auth::check()) {
        // If authenticated, redirect to the user dashboard
        return redirect()->route('user.dashbord');
    } else {
        // If not authenticated, redirect to the login page
        return redirect()->route('login');
    }
})->name('root');

// Route for the home URL
Route::get('/home', function () {
    // Check if the user is authenticated
    if (Auth::check()) {
        // If authenticated, redirect to the user dashboard
        return redirect()->route('user.dashbord');
    } else {
        // If not authenticated, redirect to the login page
        return redirect()->route('login');
    }
})->name('home');

// Routes grouped under 'user.' namespace and using 'auth' and 'verified' middleware
Route::group(['as' => 'user.', 'middleware' => ['auth', 'verified']], function () {
    // Route for the user dashboard
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashbord');
    
    // Route for the user's favorites
    Route::get('/favourite', [App\Http\Controllers\HomeController::class, 'index'])->name('favourite');

    // Routes for managing statuses
    Route::post('/status/create', [App\Http\Controllers\StatusController::class, 'create'])->name('profile.status.create');
    Route::post('/status/delete', [App\Http\Controllers\StatusController::class, 'delete'])->name('profile.status.delete');
    Route::post('/status/edit/{id}', [App\Http\Controllers\StatusController::class, 'edit'])->name('profile.status.edit');
    Route::post('/status/comment/create', [App\Http\Controllers\CommentController::class, 'create'])->name('profile.status.comment.create');
    Route::post('/status/like', [App\Http\Controllers\StatusController::class, 'like'])->name('profile.status.like');

    // Routes for managing followers and following
    Route::get('/follow/following/{page}', [App\Http\Controllers\FollowController::class, 'getFollowing'])->name('profile.follow.following');
    Route::get('/follow/follower/{page}', [App\Http\Controllers\FollowController::class, 'getFollower'])->name('profile.follow.follower');
    Route::post('/follow/change_follow_card', [App\Http\Controllers\FollowController::class, 'changeCard'])->name('profile.follow.change_card');

    // Route for displaying and managing favorites
    Route::get('/favourite/{page}', [App\Http\Controllers\FavouriteController::class, 'getfavourites'])->name('profile.favourite');

    // Routes for managing cards
    Route::post('/card/create', [App\Http\Controllers\CardController::class, 'createNewCard'])->name('profile.card.create');
    Route::get('/card/{id}/edit', [App\Http\Controllers\CardController::class, 'getCardForEdit'])->name('profile.card.edit');
    Route::post('/card/{id}/edit/submit', [App\Http\Controllers\CardController::class, 'submitEditedCard'])->name('profile.card.edit.submit');
    Route::post('/card/{id}/delete', [App\Http\Controllers\CardController::class, 'deleteCard'])->name('profile.card.delete');

    // Routes for editing the profile
    Route::get('/search', [App\Http\Controllers\ProfileController::class, 'search'])->name('profile.search');
    Route::get('/editProfile', [App\Http\Controllers\ProfileController::class, 'editProfile'])->name('profile.edit');
    Route::post('/editProfileSocialsSubmit', [App\Http\Controllers\ProfileController::class, 'editSocials'])->name('profile.edit.social.submit');
    Route::post('/editProfileSubmit', [App\Http\Controllers\ProfileController::class, 'editProfileSubmit'])->name('profile.edit.submit');
    Route::get('/{id}', [App\Http\Controllers\ProfileController::class, 'getProfile'])->where(['id' => "^[A-Za-z0-9. -]+$"])->withoutMiddleware(['auth', 'verified'])->name('profile');
    Route::post('{id}/rateme', [App\Http\Controllers\ProfileController::class, 'rateUser'])->whereAlphaNumeric('id')->name('profile.rateme');

    // Routes for making favorite and follow requests (JS call routes)
    Route::post('{id}/{card}/makefav', [App\Http\Controllers\ProfileController::class, 'makeFavourite'])->whereAlphaNumeric('id')->name('make.favourite');
    Route::post('{id}/{card}/makefollow', [App\Http\Controllers\ProfileController::class, 'makeFollow'])->whereAlphaNumeric('id')->name('make.follow');
});
?>