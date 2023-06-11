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

class CardController extends Controller
{
    public function getCardForEdit(Request $req, $id)
    {
        $card = Card::find($id);
        if ($card != null) {
            return view('card_manage',['card'=>$card]);
        }
        return abort(404);
    }

    public function submitEditedCard(Request $req, $id){
        //return $req;
        $card = Card::find($id);
        if ($card == null) {
            return abort(404);
        }

        $p = $req->except(['_token','logo_company']);
        

        if ($req->hasFile('logo_company')) {
            $user = Auth::user();
            //return $user;
            $file = $req->logo_company;
            //return $user;
            $imageName = time().'-'.'company'.'-'.$user->id.'-'.$file->getClientOriginalName();
            // Upload file to public path in images directory
            $file->move(public_path('uploads/company'), $imageName);
            
            $p['company']['logo'] = $imageName;
        }else if (isset($card->permissions['company']['logo'])){
            $p['company']['logo'] = $card->permissions['company']['logo'];
        }

        $card->permissions = $p;
        $card->save();

        return redirect()->back();
    }

    public function createNewCard(Request $req){
        $validator = Validator::make($req->all(), [
            'new_card_name' => 'required|alpha_num|max:40'
        ]);

        if ($validator->fails()) {
            abort(405, $validator->errors());
        }

        $c = Card::create([
            'card_name' => $req->new_card_name,
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->route('user.profile.card.edit',['id'=>$c->id]);
        
    }

    public function deleteCard(Request $req, $id){
        $card = Card::find($id);
        if ($card != null && strtolower($card->card_name) != 'public') {
            $card->delete();
            $card = Card::where([
                'user_id' => Auth::user()->id,
                'card_name' => 'public',
            ])->get()->first();

            return redirect()->route('user.profile.card.edit', ['id' => $card->id]);
        }
        return abort(404);
    }
    
}
