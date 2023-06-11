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
use App\Models\Status;
use App\Models\StatusLike;
use App\Models\StatusTag;
use auth;
use Cookie;

class StatusController extends Controller
{
    //
    public function create(Request $req)
    {
        //dd($req);
        $validator = Validator::make($req->all(), [
            'status' => 'required',
            'tags' => 'array',
        ]);

        if ($validator->fails()) {
            abort(405, $validator->errors());
        }

        $status = Status::create([
            'user_id' => auth::user()->id,
            'body' => $req->status,
        ]);

        if(isset($req->tags)){
            foreach ($req->tags as $key) {
                // $tagg = StatusTag::where([
                //     ['status_id' , $status->id],
                //     ['user_id', $key]
                // ])->get()->first();
                StatusTag::create([
                    'user_id'=>$key,
                    'status_id'=>$status->id,
                ]);
            }
        }

        if (isset($req->image) && $req->hasFile('image')) {
            $user = Auth::user();
            //return $user;
            $file = $req->image;
            //return $user;
            $imageName = time().'-'.'sta'.'-'.$user->id.'-'.$file->getClientOriginalName();
            // Upload file to public path in images directory
            $file->move(public_path('uploads/status'), $imageName);

            $image = Image::where([
                ['belongs' , 'STA'],
                ['belongs_id',$status->id],
            ])->first();

            if ($image==null) {
                Image::create([
                            'belongs' => 'STA',
                            'belongs_id' => $status->id,
                            'name' => $imageName,
                        ]);
            } else {
                $image->update([
                'name' => $imageName,
            ]);
            }
        }

        $success = 'Status Update Successful';

        return redirect()->route('user.dashbord',['success'=>$success]);
    }

    public function edit(Request $req, $id)
    {
        //dd($req);
        $validator = Validator::make($req->all(), [
            'status' => 'required',
            'tags' => 'array',
        ]);

        if ($validator->fails()) {
            abort(405, $validator->errors());
        }

        $status = Status::where([
            ['user_id' , auth::user()->id],
            ['id' , $id],
        ])->get()->first();

        $status->body = $req->status;
        $status->save();

        foreach ($status->tags as $tag) {
            $tag->delete();
        }

        if(isset($req->tags)){
            foreach ($req->tags as $key) {
                StatusTag::create([
                    'user_id'=>$key,
                    'status_id'=>$status->id,
                ]);
            }
        }

        $image = Image::where([
            ['belongs' , 'STA'],
            ['belongs_id',$status->id],
        ])->first();

        if(isset($req->rmv_img)&&!is_null($image)){
            $image->delete();
        }

        if (isset($req->image) && $req->hasFile('image')) {
            $user = Auth::user();
            //return $user;
            $file = $req->image;
            //return $user;
            $imageName = time().'-'.'sta'.'-'.$user->id.'-'.$file->getClientOriginalName();
            // Upload file to public path in images directory
            $file->move(public_path('uploads/status'), $imageName);



            if ($image==null) {
                Image::create([
                            'belongs' => 'STA',
                            'belongs_id' => $status->id,
                            'name' => $imageName,
                        ]);
            } else {
                $image->update([
                'name' => $imageName,
            ]);
            }
        }

        $success = 'Status Update Successful';

        return redirect()->back();
    }

    public function delete(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            abort(405, $validator->errors());
        }

       $status =  Status::find($req->id);

        if(Auth::check() && $status->user->id == Auth::user()->id){
            $status->delete();
        }

        $success = 'Status Delete Successful';

        return redirect()->back()->with($success);

    }


    public function like(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'status_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            abort(405, $validator->errors());
        }

       $status =  Status::find($req->status_id);

        if(!Auth::check())return redirect()->back();

        $like = StatusLike::where([
            ['status_id', $req->status_id],
            ['user_id' , auth::user()->id]
        ])->get()->first();

        if(is_null($like)){
            StatusLike::create([
                'user_id' => auth::user()->id,
                'status_id' => $req->status_id,
            ]);
        }else{
            $like->delete();
        }

        $success = 'Liked Successful';

        return redirect()->back()->with($success);

    }
}
