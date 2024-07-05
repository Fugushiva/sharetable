<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Annonce extends Model
{
    use HasFactory;

    protected $fillable = [
        'host_id',
        'country_id',
        'title',
        'description',
        'schedule',
        'cuisine',
        'max_guest',
        'price'
    ];

    protected $table = 'annonces';

    public $timestamps = true;


    public function host(): BelongsTo
    {
        return $this->belongsTo(Host::class);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function pictures(): HasMany
    {
        return $this->hasMany(AnnoncePicture::class);
    }

    /**
     * Upload pictures for the annonce
     * @param array $pictures
     */
    public function uploadPictures(array $pictures)
    {
        foreach ($pictures as $picture) {
            $filename = generateUniqueImageName($picture);
            $path = $picture->storeAs('img/annonces/' . $this->id, $filename, 'public');

            $this->pictures()->create([
                'path' => 'storage/' . $path,
            ]);
        }
    }


}
