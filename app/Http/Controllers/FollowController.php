<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Models\Card;
use App\Models\Favourite;
use App\Models\Follow;
use App\Models\Image;
use App\Models\Rating;
use auth;
use Cookie;

class FollowController extends Controller
{
    //
    public function getFollowing(Request $req,$page)
    {
        return view('following',['page'=>$page,'take'=>8]);
    }

    public function getFollower(Request $req,$page)
    {
        return view('follower',['page'=>$page,'take'=>15]);
    }

    public function changeCard(Request $req)
    {
        //return $req;
        $validator = Validator::make($req->all(), [
            'card_id' => 'required|numeric',
            'old_card' => 'required|numeric',
            'follower_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            abort(405, $validator->errors());
        }

        $f = Auth::user()->follower($req->old_card)->where('follow_id',$req->follower_id)->update([
            'card_id' => $req->card_id,
        ]);
        return redirect()->back()->with('success', 'update done');
    }
}
