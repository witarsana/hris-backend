<?php

namespace App\Http\Middleware;

use App\Model\Tenant\User;
use Closure;

class ApiTenant
{
    public function handle($request, Closure $next)
    {
        if($request->header('tenant-token')){
            $key = $request->header('tenant-token');
            //find user by token 
            $oUser = User::where('api_token',$key)->first();
            
            if ($oUser){
                $request->attributes->add(['userLoginId' => $oUser->id]);
                return $next($request);
            }else{
                return redirect()->route('needlogin');
            }
            
        }

        return redirect()->route('needlogin');
        
    }
}
