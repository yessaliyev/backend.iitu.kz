<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\User;
use Illuminate\Http\Request;
use GuzzleHttp;
use Auth;

class AuthController extends Controller
{

    /**
     * создает пользователя в зависимости от роля
     * регистрировать может только админ
     * @param Request $request
     * @return Object User
     */

    public function register(Request $request)
    {
        if (User::validation($request)) {
            return User::createUser($request);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt(['username' => $request->username,'password' => $request->password])) {
            auth()->user()->tokens->each(function ($token,$key){ $token->delete(); });
        }else {
            return response(["message"=>'wrong password or username',"error" => true],'401');
        }

        return User::getToken($request);

    }

    public function refreshToken(Request $request){
        $request->validate(['refresh_token' => 'required']);
        return User::getRefreshToken($request);
    }

    public function isValidToken(Request $request){
        $request->validate(['access_token' => 'required|string']);

    }
}
