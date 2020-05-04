<?php


namespace App\Http\Middleware;

use App\Models\Users\ServiceUser;
use Closure;
use Illuminate\Support\Facades\Hash;

class AccessService
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request->validate([
            'access_token' => 'required',
            'username' => 'required',
        ]);

        $service = ServiceUser::where('username',$request->username)->first();

        if (!empty($service) and password_verify($request->access_token,$service->access_token)){
            return $next($request);
        }else{
            return response(['msg' => 'u r not allowed']);
        }
    }
}
