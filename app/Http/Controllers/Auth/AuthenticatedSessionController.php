<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Redirect berdasarkan role
        return $this->redirectToDashboard(Auth::user());
    }

    /**
     * Redirect user based on their role.
     */
    protected function redirectToDashboard($user): RedirectResponse
    {
        // Debug: Uncomment baris bawah untuk melihat role user saat login
        // dd($user->role, get_class($user->role));
        
        if (!$user->role) {
            return redirect()->route('user.dashboard');
        }

        // Cek role dan redirect sesuai
        if ($user->role === 'admin' || (is_object($user->role) && $user->role->value === 'admin')) {
            return redirect()->route('admin.dashboard');
        }
        
        if ($user->role === 'petugas' || (is_object($user->role) && $user->role->value === 'petugas')) {
            return redirect()->route('petugas.dashboard');
        }

        // Default untuk user biasa
        return redirect()->route('user.dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}