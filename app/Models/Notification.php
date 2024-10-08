<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'type', 'data', 'read_at'];
    protected $table = 'notifications';

    public $timestamps = true;


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
