<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingCode extends Model
{
    use HasFactory;

    protected $fillable = [
        "reservation_id",
        "code",
        "validated"
    ];

    protected $table = 'booking_codes';

    public $timestamps = true;

    public function reservation():BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }
}
