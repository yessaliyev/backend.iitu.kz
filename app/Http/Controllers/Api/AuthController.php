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


    public function register(Request $request)
    {
        $validate_data = $request->validate([
            'username'=>'required|unique:users',
            'password'=>'required|confirmed',
            'role' => 'required|string'
        ]);

        $user = User::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ]);

        $role = Role::where('role',$request->role)->first();

        if (empty($role)) return response(['error' => true,'msg'=>'role not found'],'404');

        $user = User::find($user->id);

        $user->roles()->attach($role->id);

        return $user;

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

        $http = new GuzzleHttp\Client;

        try {
            $response = $http->post(env('LOCAL_URL').'/oauth/token', [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => env('GRANT_CLIENT_ID'),
                    'client_secret' => env('GRANT_CLIENT_SECRET'),
                    'username' => $request->username,
                    'password' => $request->password,
                ]
            ]);

            $outh = json_decode((string) $response->getBody(), true);

            try {
                $user_data = $http->get(env('LOCAL_URL').'/api/get-user', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Authorization' => 'Bearer '.$outh['access_token'],
                    ]
                ]);

                $user = json_decode((string) $user_data->getBody(), true);

                return [
                    'token_type' => $outh['token_type'],
                    'expires_in' => $outh['expires_in'],
                    'access_token' => $outh['access_token'],
                    'refresh_token'=> $outh['refresh_token'],
                    'username' => $user['username'],
                    'roles' => $user['roles']
                ];

            }catch (GuzzleHttp\Exception\BadResponseException $e){

                return response([
                    'message' => $e->getMessage(),
                    'status' => $e->getCode()
                ]);

            }

        }catch (GuzzleHttp\Exception\BadResponseException $e){

            return response([
                'message' => $e->getMessage(),
                'status' => $e->getCode()
            ]);
        }
    }

    public function refreshToken(Request $request){
        $request->validate(['refresh_token' => 'required']);
        $http = new GuzzleHttp\Client;

        $response = $http->post(env('LOCAL_URL').'/oauth/token', [
            'form_params' => [
                'grant_type' => 'refresh_token',
                'refresh_token' => $request->refresh_token,
                'client_id' => env('GRANT_CLIENT_ID'),
                'client_secret' => env('GRANT_CLIENT_SECRET'),
                'scope' => '',
            ],
        ]);

        return json_decode((string) $response->getBody(), true);
    }
}
