<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class StaffController extends Controller
{
    
    public function index(Request $request)
    {
        // Cek authorization di setiap method
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Halaman ini hanya dapat diakses oleh Super Admin.');
        }

        $query = User::where('role', UserRole::PETUGAS->value);

        // Search by name, email, or staff code
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->search . '%')
                  ->orWhere('last_name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('staff_code', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('staff_status', $request->status);
        }

        // Filter by position
        if ($request->filled('position')) {
            $query->where('position', $request->position);
        }

        $staffs = $query->latest()->paginate(15);

        $statusCounts = [
            'all' => User::where('role', UserRole::PETUGAS->value)->count(),
            'active' => User::where('role', UserRole::PETUGAS->value)->where('staff_status', 'active')->count(),
            'cuti' => User::where('role', UserRole::PETUGAS->value)->where('staff_status', 'cuti')->count(),
            'inactive' => User::where('role', UserRole::PETUGAS->value)->where('staff_status', 'inactive')->count(),
        ];

        $positions = [
            'gudang' => 'Petugas Gudang',
            'verifikasi' => 'Petugas Verifikasi',
            'cs' => 'Customer Service',
            'shipping' => 'Petugas Pengiriman',
        ];

        return view('admin.staff.index', compact('staffs', 'statusCounts', 'positions'));
    }

    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Halaman ini hanya dapat diakses oleh Super Admin.');
        }

        $positions = [
            'gudang' => 'Petugas Gudang',
            'verifikasi' => 'Petugas Verifikasi',
            'cs' => 'Customer Service',
            'shipping' => 'Petugas Pengiriman',
        ];

        return view('admin.staff.create', compact('positions'));
    }

    public function store(Request $request)
{
    if (!auth()->user()->isAdmin()) {
        abort(403, 'Halaman ini hanya dapat diakses oleh Super Admin.');
    }

    $validated = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'nullable|string|max:255',
        'email' => 'required|email|max:255|unique:users,email',
        'phone_number' => 'nullable|string|max:20',
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'position' => 'required|in:gudang,verifikasi,cs,shipping',
        'staff_status' => 'required|in:active,cuti,inactive',
        'join_date' => 'nullable|date',
        'notes' => 'nullable|string|max:500',
    ]);

    $validated['role'] = UserRole::PETUGAS->value;
    $validated['password'] = Hash::make($validated['password']);
    
    // Generate unique staff code
    $lastStaff = User::where('role', UserRole::PETUGAS->value)
                     ->whereNotNull('staff_code')
                     ->latest('id')
                     ->first();
    
    if ($lastStaff && $lastStaff->staff_code) {
        $nextId = intval(substr($lastStaff->staff_code, 3)) + 1;
    } else {
        $nextId = 1;
    }
    
    $validated['staff_code'] = 'ST-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

    User::create($validated);

    return redirect()->route('admin.staff.index')->with('success', 'Petugas berhasil ditambahkan!');
}

    public function show(User $staff)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Halaman ini hanya dapat diakses oleh Super Admin.');
        }

        if (!$staff->isPetugas()) {
            abort(403, 'User ini bukan petugas!');
        }

        return view('admin.staff.show', compact('staff'));
    }

    public function edit(User $staff)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Halaman ini hanya dapat diakses oleh Super Admin.');
        }

        if (!$staff->isPetugas()) {
            abort(403, 'User ini bukan petugas!');
        }

        $positions = [
            'gudang' => 'Petugas Gudang',
            'verifikasi' => 'Petugas Verifikasi',
            'cs' => 'Customer Service',
            'shipping' => 'Petugas Pengiriman',
        ];

        return view('admin.staff.edit', compact('staff', 'positions'));
    }

    public function update(Request $request, User $staff)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Halaman ini hanya dapat diakses oleh Super Admin.');
        }

        if (!$staff->isPetugas()) {
            abort(403, 'User ini bukan petugas!');
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $staff->id,
            'phone_number' => 'nullable|string|max:20',
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'position' => 'required|in:gudang,verifikasi,cs,shipping',
            'staff_status' => 'required|in:active,cuti,inactive',
            'join_date' => 'nullable|date',
            'notes' => 'nullable|string|max:500',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $staff->update($validated);

        return redirect()->route('admin.staff.show', $staff)->with('success', 'Data petugas berhasil diupdate!');
    }

    public function destroy(User $staff)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Halaman ini hanya dapat diakses oleh Super Admin.');
        }

        if (!$staff->isPetugas()) {
            abort(403, 'User ini bukan petugas!');
        }

        // Prevent deleting self
        if ($staff->id === auth()->id()) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun Anda sendiri!');
        }

        $staff->delete();

        return redirect()->route('admin.staff.index')->with('success', 'Petugas berhasil dihapus!');
    }

    public function toggleStatus(User $staff)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Halaman ini hanya dapat diakses oleh Super Admin.');
        }

        if (!$staff->isPetugas()) {
            abort(403, 'User ini bukan petugas!');
        }

        $newStatus = $staff->staff_status === 'active' ? 'inactive' : 'active';
        $staff->update(['staff_status' => $newStatus]);

        return redirect()->back()->with('success', 'Status petugas berhasil diubah!');
    }
}