<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnnoncePicture extends Model
{
    use HasFactory;

    protected $fillable = ['path', 'annonce_id'];

    protected $table = 'annonces_pictures';

    public function annonce(): BelongsTo
    {
        return $this->belongsTo(Annonce::class);
    }
}
