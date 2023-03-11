<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Instrument extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'default_picture_filepath'
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
        'id'
    ];

    public function musicians(): HasMany
    {
        return $this->hasMany(Musician::class, 'instrument_id', 'id');
    }
}
