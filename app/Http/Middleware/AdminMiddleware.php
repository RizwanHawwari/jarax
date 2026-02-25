<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Ambil role user (bisa berupa string ATAU Enum object)
        $role = auth()->user()->role;
        
        // Handle jika role adalah Enum object
        $roleValue = is_object($role) && property_exists($role, 'value') ? $role->value : $role;

        // Cek apakah role adalah admin
        if ($roleValue !== 'admin') {
            abort(403, 'Unauthorized access. Admin only.');
        }

        return $next($request);
    }
}