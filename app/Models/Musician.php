<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Musician extends Model
{
    use HasFactory;

    protected $fillable = [
        'isActive',
        'firstname',
        'lastname',
        'instrument_id',
        'picture_filepath',
        'seating_position',
    ];

    protected $casts = [
        'isActive' => 'boolean',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function instrument(): BelongsTo
    {
        return $this->belongsTo(Instrument::class, 'instrument_id', 'id');
    }
}
