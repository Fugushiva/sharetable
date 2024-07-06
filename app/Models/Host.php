<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Nnjeim\World\Models\City;

class Host extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'city_id',
        'bio',
        'birthdate',
        'profile_picture'
    ];

    protected $table = 'hosts';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function annonces():HasMany
    {
        return $this->hasMany(Annonce::class);
    }

    public function city(): HasOne
    {
        return $this->hasOne(City::class);
    }

    public function transactions():HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
