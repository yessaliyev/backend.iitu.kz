<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function register(Request $request)
    {
       $validate_data = $request->validate([
           'name'=>'required|max:50',
           'email'=>'required|unique:users',
           'password'=>'required|confirmed'
       ]);

       $validate_data['password'] = bcrypt($request->password);
       $user = User::create($validate_data);
       $access_token = $user->createToken('AuthToken')->accessToken;

       return response([
           'user' => $user,
           "access_token"=>$access_token
       ]);
    }

    public function login(Request $request)
    {
        $validate_data = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($validate_data))
        {
            return response(['message' => "invalid credentials"]);
        }

        $access_token = auth()->user()->createToken('authToken');

        return response([
            'access_token'=>$access_token->accessToken,
            'expires_at'=>$access_token->token->expires_at
        ]);
    }
}
