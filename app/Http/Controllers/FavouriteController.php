<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Card;
use App\Models\Favourite;
use App\Models\Follow;
use App\Models\Image;
use App\Models\Rating;
use auth;
use Cookie;

class FavouriteController extends Controller
{
    //
    public function getfavourites(Request $req, $page)
    {
        return view('favourites',['page'=>$page,'take'=>10]);
    }
}
