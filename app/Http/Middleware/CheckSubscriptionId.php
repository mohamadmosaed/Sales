<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSubscriptionId
{
    public function handle(Request $request, Closure $next)
    {
        // Retrieve the authenticated user
        $user = auth()->user();

        // Check if the user's subscription_id is equal to 4
        if ($user && $user->subscription_id !== 4) {
            // If it's not 4, return a response or redirect
            return redirect()->route('home')->with('error', 'You are not authorized to access this subscription');
        }

        return $next($request);
    }

}
