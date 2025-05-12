<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!$request->user() || $request->user()->role !== $role) {
            if ($request->user()) {
                return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut!');
            }
            return redirect()->route('login');
        }

        return $next($request);
    }
}
