<?php

namespace App;

use App\Models\Department;
use App\Models\Group;
use App\Models\Role;
use App\Models\Users\Additional;
use App\Models\Users\Student;
use App\Models\Users\Teacher;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'password','username',
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
        $user = User::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ]);

        $role = Role::where('role',$request->role)->first();

        if (empty($role)) return response(['error' => true,'msg'=>'role not found'],'404');

        $user = User::find($user->id);

        $user->roles()->attach($role->id);

        switch ($request->role){
            case 'student':
                $student = Student::firstOrCreate(['user_id' => $user->id,'group_id' => $request->group_id]);
                if (!empty($request->additional_data)) self::saveAdditional($request->additional_data,$user->id);
                break;
            case 'teacher':
                $teacher = Teacher::firstOrCreate(['user_id' => $user->id,'department_id' => $request->department_id]);
                if (!empty($request->additional_data)) self::saveAdditional($request->additional_data,$user->id);
                break;
        }

        return $user;
    }

    private static function saveAdditional(Array $additional,$user_id){
        foreach ($additional as $key => $value){
            $additional = Additional::where('key', $key)->andWhere('user_id',$user_id)->first();
            if (empty($additional)) $additional = new Additional();
            $additional->key = $key;
            $additional->value = $value;
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

    public function findForPassport($username)
    {
        return $this->where('username', $username)->first();
    }

    public function roles(){
        return $this->belongsToMany('App\Models\Role');
    }

    public function hasAnyRoles($roles){
        return null !== $this->roles()->whereIn('role', $roles)->first();
    }

    public function hasRole($role){
        return null !== $this->roles()->where('role', $role)->first();
    }

}
