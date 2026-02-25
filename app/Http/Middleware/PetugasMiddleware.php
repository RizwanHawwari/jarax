<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PetugasMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $role = auth()->user()->role;
        $roleValue = is_object($role) && property_exists($role, 'value') ? $role->value : $role;

        // Admin dan Petugas bisa akses
        if (!in_array($roleValue, ['admin', 'petugas'])) {
            abort(403, 'Unauthorized access. Petugas only.');
        }

        return $next($request);
    }
}