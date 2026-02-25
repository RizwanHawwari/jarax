<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
    'first_name',
    'last_name',
    'email',
    'password',
    'phone_number',
    'role',
    'is_active',
    'is_banned',
    'ban_reason',
    'banned_at',
    'banned_by',
    'staff_code',
    'position',
    'staff_status',
    'join_date',
    'notes',
];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
{
    return [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => UserRole::class,
        'is_active' => 'boolean',
        'is_banned' => 'boolean',
        'banned_at' => 'datetime',
        'join_date' => 'date',
    ];
}

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    // Helper: Cek Role
    public function isAdmin(): bool 
    { 
        $roleValue = is_object($this->role) && property_exists($this->role, 'value') 
            ? $this->role->value 
            : $this->role;
        return $roleValue === 'admin'; 
    }

    public function isStaff(): bool
{
    return $this->role === UserRole::PETUGAS;
}

public function getStaffCodeAttribute(): string
{
    // Return existing staff_code or generate display-only code
    return $this->attributes['staff_code'] ?? 'ST-' . str_pad($this->id, 4, '0', STR_PAD_LEFT);
}

public function getStaffStatusBadgeAttribute(): array
{
    return match($this->staff_status) {
        'active' => ['color' => 'green', 'label' => 'AKTIF'],
        'cuti' => ['color' => 'yellow', 'label' => 'CUTI'],
        'inactive' => ['color' => 'red', 'label' => 'NONAKTIF'],
        default => ['color' => 'gray', 'label' => 'UNKNOWN'],
    };
}

public function getPositionLabelAttribute(): string
{
    return match($this->position) {
        'gudang' => 'Petugas Gudang',
        'verifikasi' => 'Petugas Verifikasi',
        'cs' => 'Customer Service',
        'shipping' => 'Petugas Pengiriman',
        default => $this->position ?? 'Petugas',
    };
}
    
    public function isPetugas(): bool 
    { 
        $roleValue = is_object($this->role) && property_exists($this->role, 'value') 
            ? $this->role->value 
            : $this->role;
        return $roleValue === 'petugas'; 
    }
    
    public function isUser(): bool 
    { 
        $roleValue = is_object($this->role) && property_exists($this->role, 'value') 
            ? $this->role->value 
            : $this->role;
        return $roleValue === 'user'; 
    }

    // Helper: Cek Status Ban
    public function isBanned(): bool
    {
        return $this->is_banned === true;
    }

    public function isActive(): bool
    {
        return $this->is_active === true && !$this->isBanned();
    }

    public function getStatusBadgeAttribute(): array
    {
        if ($this->isBanned()) {
            return ['color' => 'red', 'label' => 'SUSPENDED'];
        }
        return ['color' => 'green', 'label' => 'AKTIF'];
    }

    // Method untuk Ban user
    public function ban(string $reason, $adminUser)
    {
        $this->update([
            'is_banned' => true,
            'ban_reason' => $reason,
            'banned_at' => now(),
            'banned_by' => $adminUser->id,
        ]);
    }

    // Method untuk Unban user
    public function unban()
    {
        $this->update([
            'is_banned' => false,
            'ban_reason' => null,
            'banned_at' => null,
            'banned_by' => null,
        ]);
    }

    // Relasi: User yang nge-ban
    public function bannedBy()
    {
        return $this->belongsTo(User::class, 'banned_by');
    }

    // Relasi: Transaksi user
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}