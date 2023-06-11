<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Models\Card;
use App\Models\Favourite;
use App\Models\Follow;
use App\Models\Image;
use App\Models\Rating;
use App\Models\Variable;
use App\Models\Status;
use auth;
use Cookie;

class CommentController extends Controller
{
    //

    public function create(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'body' => 'required',
            'status_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            abort(405, $validator->errors());
        }

        Comment::create([
            'user_id' => auth::user()->id,
            'body' => $req->body,
            'status_id' => $req->status_id,
        ]);

        $success = 'Comment Update Successful';

        return redirect()->back();
    }

}
