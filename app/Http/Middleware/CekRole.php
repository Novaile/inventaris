<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // ini yang dipake

class CekRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        if (Auth::user()->role != $role) {
            return redirect('/');
        }

        return $next($request);
    }
}
