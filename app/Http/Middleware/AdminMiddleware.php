<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('admin.login');
        }

        if (!auth()->user()->hasAccess('admin')) {
            auth()->logout();
            return redirect()->route('admin.login')->withErrors([
                'email' => 'Anda tidak memiliki akses administrator.',
            ]);
        }

        return $next($request);
    }
}
