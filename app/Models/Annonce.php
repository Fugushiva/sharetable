<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nnjeim\World\Models\Country;

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
        'price',
        'status',
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

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
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

    /**
     * Scope a query to only include annonces with a specific cuisine
     * @param $query
     * @param $cuisine
     * @return mixed
     */
    public function scopeFindByCuisine($query, $cuisine)
    {
        return $query->where('cuisine', 'like', '%' . $cuisine . '%');
    }

    /**
     * Scope a query to only include annonces with price above a certain value
     * @param $query
     * @param $price
     * @return mixed
     */
    public function scopeFindPriceAbove($query, $price)
    {
        return $query->where('price', '>=', $price);
    }

    /**
     * Scope a query to only include annonces with a price below a certain value
     * @param $query
     * @param $price
     * @return mixed
     */
    public function scopeFindPriceBelow($query, $price)
    {
        return $query->where('price', '<=', $price);
    }

    /**
     * Scope a query to only include annonces with a maximum number of guests below a certain value
     * @param $query
     * @param $guests
     * @return mixed
     */
    public function scopeFindGuestsBelow($query, $guests)
    {
        return $query->where('max_guest', '<=', $guests);
    }

    /**
     * Scope a query to only include annonces with a specific country
     * if no country is selected, show all annonces
     * @param $query
     * @param $countryId
     * @return mixed
     */
    public function scopeFindByCountry($query, $input)
    {
        $country = Country::where('name', $input)->first();
        if($country){
            return $query->where('country_id', $country->id);
        }else{
            return $query->where('country_id', '!=', null);
        }

    }









}
