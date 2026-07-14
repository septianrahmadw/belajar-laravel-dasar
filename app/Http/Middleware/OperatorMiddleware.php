<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OperatorMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('admin.login');
        }

        if (!auth()->user()->hasAccess('operator')) {
            auth()->logout();
            return redirect()->route('admin.login')->withErrors([
                'email' => 'Anda tidak memiliki akses operator.',
            ]);
        }

        return $next($request);
    }
}
