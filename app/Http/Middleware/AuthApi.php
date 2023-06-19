<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Auth;
use DB;

class AuthApi
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
        if(!isset($request['token']) || empty($request['token'])){
            return response()->json([
                'success' => false,
                'error'=>"Unauthorized access."
            ], 401);
        }else{
            $userObj = User::where('api_token',$request['token'])->where('api_token','!=',"")->first();
            if(empty($userObj)){
                return response()->json([
                    'success' => false,
                    'error'=>"Invalid Token passed."
                ], 401);
            }else{
                if(!$userObj->hasanyrole('collector|partner')){
                    return response()->json([
                        'success' => false,
                        'error'=>"User is not having a valid role"
                    ], 401);
                }
            }
        }
        return $next($request);
    }
}
