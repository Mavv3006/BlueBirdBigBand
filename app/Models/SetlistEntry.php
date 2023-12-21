<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SetlistEntry extends Model
{
    use HasFactory;

    public function song(): BelongsTo
    {
        return $this->belongsTo(Song::class);
    }

    public function concert(): BelongsTo
    {
        return $this->belongsTo(Concert::class);
    }
}
