<?php

namespace App;

use App\Models\Department;
use App\Models\Group;
use App\Models\Regalia;
use App\Models\Role;
use App\Models\Users\Additional;
use App\Models\Users\Student;
use App\Models\Users\Teacher;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use GuzzleHttp;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'password','username','role_id','first_name','last_name','middle_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function createUser($request)
    {
        $role = Role::where('role',$request->role)->first();

        if (empty($role)) return response(['error' => true,'msg'=>'role not found'],'404');

        $data = [
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role_id' => $role->id
        ];

        if (isset($request->first_name)) $data['first_name'] = $request->first_name;
        if (isset($request->last_name)) $data['last_name'] = $request->last_name;
        if (isset($request->middle_name)) $data['middle_name'] = $request->middle_name;

        $user = User::create($data);

        switch ($request->role){
            case 'student':
                $student = Student::firstOrCreate(['user_id' => $user->id,'group_id' => $request->group_id]);
                if (!empty($request->additional_data)) self::saveAdditional($request->additional_data,$user->id);
                break;
            case 'teacher':
                $regalia = Regalia::firstOrCreate([
                    'regalia_en' => $request->regalia['regalia_en'],
                    'regalia_ru' => $request->regalia['regalia_ru'],
                    'regalia_kk' => $request->regalia['regalia_kk'],
                ]);

                Teacher::firstOrCreate([
                    'user_id' => $user->id,
                    'department_id' => $request->department_id,
                    'regalia_id' => $regalia->id
                ]);

                if (!empty($request->additional_data)) self::saveAdditional($request->additional_data,$user->id);
                break;
        }

        return $user;
    }

    private static function saveAdditional(Array $additional,$user_id){
        foreach ($additional as $key => $value){
            $additional = Additional::where('key', $key)->where('user_id',$user_id)->first();
            if (empty($additional)) $additional = new Additional();
            $additional->key = $key;
            $additional->value = $value;
            $additional->user_id = $user_id;
            $additional->save();
        }
        return true;
    }

    public static function validation($request){
        $request->validate([
            'username'=>'required|unique:users',
            'password'=>'required|confirmed',
            'role' => 'required|string'
        ]);

        Role::where('role', $request->role)->firstOrFail();

        switch ($request->role){
            case 'student':
                throw_if(empty($request->group_id),new BadRequestHttpException('group_id not presented'));
                $group = Group::findOrFail($request->group_id);
                break;
            case 'teacher':
                throw_if(empty($request->department_id),new BadRequestHttpException('department_id not presented'));
                $department = Department::findOrFail($request->department_id);
                break;
        }

        return true;
    }

    public static function getToken($request)
    {
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
                $user_data = $http->get(env('LOCAL_URL').'/api/user/get', [
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
                    'user_id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role']
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

    public static function getRefreshToken($request)
    {
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

    public function findForPassport($username)
    {
        return $this->where('username', $username)->first();
    }

    public function roles(){
        return $this->belongsToMany('App\Models\Role');
    }

    public function role(){
        return $this->hasOne('App\Models\Role','id','role_id');
    }

    public function hasAnyRoles($roles){
        return null !== $this->role()->whereIn('role', $roles)->first();
    }

    public function hasRole($role){
        return null !== $this->role()->where('role', $role)->first();
    }

    public function AauthAcessToken(){
        return $this->hasMany('\App\Models\OauthAccessToken');
    }

    public function student(){
        return $this->hasOne('\App\Models\Users\Student','user_id','id');
    }

    public function teacher(){
         return $this->hasOne('\App\Models\Users\Teacher','user_id','id');
    }

}
