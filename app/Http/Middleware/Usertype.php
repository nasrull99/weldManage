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
        if (!Auth::check()) {
            return redirect()->route('login'); // Ensure the user is logged in
        }

        $authUserType = Auth::user()->usertype;

        // Check if the user has the correct role
        if ($authUserType == $usertype) {
            return $next($request); // Continue with the request if the user type is correct
        }

        // Redirect based on user type
        if ($authUserType == 'admin') {
            return redirect()->route('dashboard'); // Redirect admin to the admin dashboard
        }

        if ($authUserType == 'user') {
            return redirect()->route('customer.dashboard'); // Redirect user to the customer dashboard
        }

        return redirect()->route('login'); // Redirect to login if the user is not authenticated or invalid
    }
}
