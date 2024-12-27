<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class Usertype
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $usertype): Response
    {
        if(!Auth::check())
        {
            return redirect()->route('login');
        }

        $authUserType = Auth::user()->usertype;

        switch($usertype)
        {
            case 'admin':
                if($authUserType == 'admin'){
                    return $next($request);
                }
                break;
            case 'user':
                if($authUserType == 'user'){
                    return $next($request);
                }
                break;
        }
        
        switch($authUserType)
        {
            case 'admin':
                return redirect()->route('dashboard');
            case 'user':
                return redirect()->route('customer.dashboard');
        }

        return redirect()->route('login');
    }
}