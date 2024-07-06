<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reservation_id',
        'host_id',
        'quantity',
        'currency',
        'payment_status', // 'pending', 'completed', 'failed', 'refunded'
        'stripe_transaction_id',
        'commission',
    ];

    protected $table = 'transactions';
    public $timestamps = true;

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reservation():BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }

    public function host():BelongsTo
    {
        return $this->belongsTo(Host::class);
    }
}
