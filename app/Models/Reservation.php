<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'annonce_id',
        'user_id',
        'status'
    ];

    protected $table = 'reservations';

    public $timestamps = true;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function annonce(): BelongsTo
    {
        return $this->belongsTo(Annonce::class);
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function bookingCode(): HasOne
    {
        return $this->hasOne(BookingCode::class);
    }

    /**
     * Scope a query to only include active reservations for a specific user.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActiveForUser($query, $userId)
    {
        return $query->where('user_id', $userId)->where('status', 'active')->with('annonce');
    }

    public function scopeReservationExists($query, $annonceId, $userId)
    {
        return $query->where('annonce_id', $annonceId)
            ->where('user_id', $userId)
            ->where('status', 'active')
            ->exists();
    }
}
