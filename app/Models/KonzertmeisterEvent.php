<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KonzertmeisterEvent extends Model
{
    use HasFactory;

    public function concerts(): HasMany
    {
        return $this->hasMany(Concert::class);
    }

    public function band(): BelongsTo
    {
        return $this->belongsTo(Band::class);
    }
}
