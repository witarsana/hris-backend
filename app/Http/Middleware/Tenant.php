<?php

namespace App\Http\Middleware;

use App\Model\Main\Company;
Use App\Support\TenantConnector;
use Closure;

class Tenant
{
    use TenantConnector;

    public function handle($request, Closure $next)
    {
        
        //list($subdomain) = explode('.', $request->getHost(), 2);
        $subdomain =$request->user()->company_name;
        $company = Company::where("company_name",$subdomain)->first();

        //dd($company);        
        if (empty($company)){
            return redirect()->route('unregistered');
        }

        $this->reconnect($company);
        return $next($request);
        //dd("test");
    }
}
