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
use App\Models\Variable;
use App\Models\Social;
use auth;
use Cookie;

class ProfileController extends Controller
{
    //
    public function search(Request $req)
    {
        //return $req;
        $validator = Validator::make($req->all(), [
            'text' => 'nullable|regex:/^[A-Za-z0-9. -]+$/|max:50',
        ]);

        if ($validator->fails()) {
            abort(405, $validator->errors());
        }

        $u = User::where('username', 'LIKE', "%{$req->text}%")
        ->get()->first();

        if ($u!=null) {
            return redirect()->route('user.profile', ['id' => $u->id]);
        }

        return redirect()->back()->with('error', 'not found');
    }
    public function getProfile(Request $req, $id)
    {
        $user = is_numeric($id)? User::find($id) : User::where('username', $id)->first();

        if ($user == null) {
            abort(response('User not found', 404));
        }

        $logged_user = Auth::check()?Auth::user()->username:'__guest_user__';
        $logged_user_id = Auth::check()?Auth::user()->id:-1;

        //Cookies
        $profil_username = str_replace('.', '-', $user->username);
        if ($req->cookie($profil_username) != $logged_user) {
            Cookie::queue($profil_username, $logged_user, 100);

            if (Auth::user() == null || $user->id != Auth::user()->id) {
                $user->views = $user->views+1;
                $user->save();
                //echo "\nIncreased";
            }
        }

        //return $req->cookie($profil_username);

        $card = $user->returnProtectedProfileCard($logged_user_id);

        return view('profile', [ "user" => $card->user, "card" => $card ]);
    }

    public function editProfile(Request $req)
    {
        if(!isset($req->success))$success = NULL;
        else $success = $req->success;
        return view('profile_edit', ['success'=>$success]);
    }
    public function editProfileSubmit(Request $req)
    {
        //return $req;
        $userFilter = array('phone','fname','lname','bio');
        $success = null;
        if (isset($req->user)) {
            $keys = array_keys($req->user);
            $result = array_intersect($keys, $userFilter);
            if (count($result)!=0) {
                $user = Auth::user();
                foreach ($result as $field) {
                    $user[$field] = $req->user[$field];
                }
                $user->save();
                $success = 'Profile Update Successful';
            }
        } elseif (isset($req->socials)) {
            return $keys = array_keys($req->socials);
        }
        
        if (isset($req->image) && $req->hasFile('image')) {
            $user = Auth::user();
            //return $user;
            $file = $req->image;
            //return $user;
            $imageName = time().'-'.'usr'.'-'.$user->id.'-'.$file->getClientOriginalName();
            // Upload file to public path in images directory
            $file->move(public_path('uploads/user'), $imageName);

            $image = Image::where([
                ['belongs' , 'USR'],
                ['belongs_id',$user->id],
            ])->first();

            if ($image==null) {
                Image::create([
                            'belongs' => 'USR',
                            'belongs_id' => $user->id,
                            'name' => $imageName,
                        ]);
            } else {
                $image->update([
                'name' => $imageName,
            ]);
            }
        }

        return redirect()->route('user.profile.edit',['success'=>$success]);
    }

    public function editSocials(Request $req)
    {
        foreach ($req->socials as $key => $value) {
            if($value == NULL) $value;
            $social = Social::where([
                ['user_id',Auth::user()->id],
                ['provider',$key],
            ])->get()->first();

            if($social == NULL){
                $social = Social::create([
                    'user_id' => Auth::user()->id,
                    'provider' => $key,
                    'social_id' => $value,
                    'verified_at' => NULL
                ]);
            }else{
                $social->social_id = $value;
                $social->save();
            }
        }

        return redirect()->route('user.profile.edit',['success'=>"Update Successful"]);
    }

    public function rateUser(Request $req, $id)
    {
        //return $req;
        $user  = User::find($id);
        if ($user == null) {
            return redirect()->back()->withErrors('Invalid User')->withInput();
        }

        $validator = Validator::make($req->all(), [
            'comment' => 'nullable',
            'rating' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            abort(405, $validator->errors());
        }

        $rating = Rating::where([
            ['to_id',$user->id],
            ['from_id',Auth::user()->id],
        ])->first();

        if ($rating == null) {
            Rating::create([
            'to_id' => $user->id,
            'from_id' => Auth::user()->id,
            'comment' => $req->comment,
            'rating' => $req->rating,
        ]);
        } else {
            $rating->update([
                'comment' => $req->comment,
                'rating' => $req->rating,
            ]);
        }
        return redirect()->back()->with('success', 'update done');
    }

    public function makeFavourite(Request $req, $id, $card)
    {
        $card = is_numeric($card)? Card::find($card) : null;

        $fav = Favourite::where([
            ['user_id',Auth::user()->id],
            ['card_id',$card->id],
        ]);

        if ($fav->first() == null) {
            Favourite::create([
                'user_id' => Auth::user()->id,
                'card_id' => $card->id,
            ]);
            return 1;
        } else {
            $fav->delete();
            return 0;
        }
    }

    public function makeFollow(Request $req, $id, $card)
    {
        $card = is_numeric($card)? Card::find($card) : null;

        $fav = Follow::where([
            ['follow_id',Auth::user()->id],
            ['card_id',$card->id],
        ]);

        if ($fav->first() == null) {
            Follow::create([
                'follow_id'=>Auth::user()->id,
                'card_id' => $card->id,
            ]);
            return 1;
        } else {
            $fav->delete();
            return 0;
        }
    }
}

//onsubmit="showToast(event, 'contact')"
