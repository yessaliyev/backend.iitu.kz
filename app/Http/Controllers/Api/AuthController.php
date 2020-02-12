<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use GuzzleHttp;
use Auth;

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
            'username' => 'required',
            'password' => 'required'
        ]);

        $http = new GuzzleHttp\Client;

        try {
            $response = $http->post('http://dl.iitu.local/oauth/token', [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => '2',
                'client_secret' => 'pSpumdpMLgdE88tub4Fqrjth2uK3MV6gaY2VzaNf',
                'username' => $request->username,
                'password' => $request->password,
            ],]);

            $result = json_decode((string) $response->getBody(), true);
            // Осы жерден типа Auth::user() деп тауып кетуге болмай ма???

            //или тек баска жерге токен аркылы запрос жыберып барып алуга бола ма?
            try {
                $user_data = $http->get('http://dl.iitu.local/api/get-user', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Authorization' => 'Bearer '.$result['access_token'],
                    ]
                ]);
                return $user_data;
                return response(['data' => $user_data->getBody()]);
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
}
