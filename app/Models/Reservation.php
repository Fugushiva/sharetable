<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class);
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

    /**
     * Scope a query to only include active reservations for a specific annonce.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $annonceId
     *
     */
    public function scopeReservationExists($query, $annonceId, $userId)
    {
        return $query->where('annonce_id', $annonceId)
            ->where('user_id', $userId)
            ->where('status', 'active')
            ->exists();
    }


    /**
     * Get the host of the reservation
     *
     * @return User
     */
    public function host()
    {
        return $this->annonce->host;
    }

    /**
     * Check if the user is the guest of the reservation
     *
     * @param User $user
     * @return bool
     */
    public function isGuest(User $user)
    {
        return $this->user_id === $user->id;
    }

    /**
     * Check if the user is the host of the reservation
     *
     * @param User $user
     * @return bool
     */
    public function isHost(User $user)
    {
        return $this->host()->id === $user->id;
    }

    /**
     * Check if the reservation is active
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

}
