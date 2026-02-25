<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\BackupController;

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Product Routes
    Route::resource('products', ProductController::class);

    // Transaction Routes
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::post('/transactions/{transaction}/verify', [TransactionController::class, 'verify'])->name('transactions.verify');
    Route::post('/transactions/{transaction}/ship', [TransactionController::class, 'ship'])->name('transactions.ship');
    Route::post('/transactions/{transaction}/complete', [TransactionController::class, 'complete'])->name('transactions.complete');
    Route::post('/transactions/{transaction}/proof', [TransactionController::class, 'updateProof'])->name('transactions.proof');

    // User Routes
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::post('/users/{user}/ban', [UserController::class, 'ban'])->name('users.ban');
    Route::post('/users/{user}/unban', [UserController::class, 'unban'])->name('users.unban');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Staff/Petugas Routes
    Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
    Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.create');
    Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
    Route::get('/staff/{staff}', [StaffController::class, 'show'])->name('staff.show');
    Route::get('/staff/{staff}/edit', [StaffController::class, 'edit'])->name('staff.edit');
    Route::put('/staff/{staff}', [StaffController::class, 'update'])->name('staff.update');
    Route::delete('/staff/{staff}', [StaffController::class, 'destroy'])->name('staff.destroy');
    Route::post('/staff/{staff}/toggle-status', [StaffController::class, 'toggleStatus'])->name('staff.toggle-status');
});

// Petugas Routes
Route::middleware(['auth', 'petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', function () {
        return view('petugas.dashboard');
    })->name('dashboard');
});

// Report Routes
Route::middleware(['auth', 'admin'])->prefix('admin/reports')->name('admin.reports.')->group(function () {
    Route::get('/', [ReportController::class, 'index'])->name('index');
    Route::get('/sales', [ReportController::class, 'sales'])->name('sales');
    Route::get('/stock', [ReportController::class, 'stock'])->name('stock');
    Route::get('/transactions', [ReportController::class, 'transactions'])->name('transactions');
    Route::get('/export/sales', [ReportController::class, 'exportSales'])->name('export.sales');
});

// Backup Routes
Route::middleware(['auth', 'admin'])->prefix('admin/backup')->name('admin.backup.')->group(function () {
    Route::get('/', [BackupController::class, 'index'])->name('index');
    Route::post('/create', [BackupController::class, 'create'])->name('create');
    Route::get('/download/{filename}', [BackupController::class, 'download'])->name('download');
    Route::delete('/{filename}', [BackupController::class, 'destroy'])->name('destroy');
    Route::post('/restore', [BackupController::class, 'restore'])->name('restore');
    Route::post('/upload', [BackupController::class, 'upload'])->name('upload');
});

// User Routes (General - Harus Paling Bawah)
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('dashboard');
});

Route::get('/', function () {
    return view('auth.login');
});

// Dashboard umum (fallback)
Route::get('/dashboard', function () {
    if (auth()->check()) {
        // Redirect berdasarkan role jika akses /dashboard langsung
        if (auth()->user()->role === 'admin' || (is_object(auth()->user()->role) && auth()->user()->role->value === 'admin')) {
            return redirect()->route('admin.dashboard');
        }
        if (auth()->user()->role === 'petugas' || (is_object(auth()->user()->role) && auth()->user()->role->value === 'petugas')) {
            return redirect()->route('petugas.dashboard');
        }
        return redirect()->route('user.dashboard');
    }
    return redirect()->route('login');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';