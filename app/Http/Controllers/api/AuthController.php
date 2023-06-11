<?php



namespace App\Http\Controllers\api;

use Illuminate\Support\Facades\Http;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use App\Models\User;

use Illuminate\Support\Facades\Auth;



class AuthController extends Controller
{

    public function register (Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        //return $request;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(10),
        ]);
        
        $response = User::getPasswordGrantToken($request->email,$request->password);

        return response($response->json(), 200);
    }

    public function login (Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $response = User::getPasswordGrantToken($request->email,$request->password);

        return response($response->json(), 200);
    }

    public function refresh(Request $request) {
        $validator = Validator::make($request->all(), [
            'refresh_token' => 'required|string'
        ]);

        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $response = User::getTokenFromRefreshToken($request->refresh_token);

        return response($response->json(), 200);
    }

    public function logout(Request $request){

        if($request->user()==NULL){
            return response()->json([
                'error' => 'token is invallid'
            ]);
        }

        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function details(Request $request){
        return response()->json(['user' => User::all()], 200);
    }
}
