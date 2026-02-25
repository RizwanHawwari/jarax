<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_code',
        'user_id',
        'subtotal',
        'shipping_cost',
        'total',
        'status',
        'payment_proof',
        'notes',
        'admin_notes',
        'shipping_address',
        'shipping_city',
        'shipping_postal_code',
        'shipping_phone',
        'courier',
        'tracking_number',
        'paid_at',
        'shipped_at',
        'completed_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total' => 'decimal:2',
        'paid_at' => 'datetime',
        'shipped_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            $transaction->transaction_code = 'TRX-' . strtoupper(Str::random(8));
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function getStatusBadgeAttribute(): array
    {
        return match($this->status) {
            'pending' => ['color' => 'gray', 'label' => 'Menunggu Pembayaran'],
            'paid' => ['color' => 'yellow', 'label' => 'Menunggu Verifikasi'],
            'processing' => ['color' => 'blue', 'label' => 'Diproses'],
            'shipped' => ['color' => 'purple', 'label' => 'Dikirim'],
            'completed' => ['color' => 'green', 'label' => 'Selesai'],
            'cancelled' => ['color' => 'red', 'label' => 'Dibatalkan'],
            'rejected' => ['color' => 'red', 'label' => 'Ditolak'],
            default => ['color' => 'gray', 'label' => 'Unknown'],
        };
    }

    public function canBeVerified(): bool
    {
        return in_array($this->status, ['pending', 'paid']);
    }

    public function canBeShipped(): bool
    {
        return in_array($this->status, ['paid', 'processing']);
    }
}