<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SchoolOwnerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('school-owner.login');
        }

        if (!auth()->user()->hasAnyRole(['school_owner', 'admin'])) {
            abort(403, 'Access denied.');
        }

        return $next($request);
    }
}