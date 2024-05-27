<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnnoncePicture extends Model
{
    use HasFactory;

    protected $fillable = ['picture'];

    protected $table = 'annonces_pictures';

    public $timestamps = true;

    public function annonce():BelongsTo
    {
        return $this->belongsTo(Annonce::class);
    }

}
