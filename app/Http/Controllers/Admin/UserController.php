<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', UserRole::USER->value);

        // Search by name or email
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->search . '%')
                  ->orWhere('last_name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_banned', false);
            } elseif ($request->status === 'banned') {
                $query->where('is_banned', true);
            }
        }

        $users = $query->latest()->paginate(15);

        $statusCounts = [
            'all' => User::where('role', UserRole::USER->value)->count(),
            'active' => User::where('role', UserRole::USER->value)->where('is_banned', false)->count(),
            'banned' => User::where('role', UserRole::USER->value)->where('is_banned', true)->count(),
        ];

        return view('admin.users.index', compact('users', 'statusCounts'));
    }

    public function show(User $user)
    {
        $user->load(['transactions', 'bannedBy']);
        return view('admin.users.show', compact('user'));
    }

    public function ban(Request $request, User $user)
    {
        $request->validate([
            'ban_reason' => 'required|string|max:500',
        ]);

        // Prevent banning admin or petugas
        if ($user->isAdmin() || $user->isPetugas()) {
            return redirect()->back()->with('error', 'Tidak dapat ban admin atau petugas!');
        }

        $user->ban($request->ban_reason, auth()->user());

        return redirect()->back()->with('success', 'User berhasil di-ban!');
    }

    public function unban(User $user)
    {
        $user->unban();

        return redirect()->back()->with('success', 'User berhasil di-unban!');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:20',
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'is_active' => 'boolean',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $validated['is_active'] = $request->has('is_active');

        $user->update($validated);

        return redirect()->route('admin.users.show', $user)->with('success', 'Data user berhasil diupdate!');
    }

    public function destroy(User $user)
    {
        // Prevent deleting admin or petugas
        if ($user->isAdmin() || $user->isPetugas()) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus admin atau petugas!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus!');
    }
}