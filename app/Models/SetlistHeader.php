<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SetlistHeader extends Model
{
    use HasFactory;

    public function concert(): BelongsTo
    {
        return $this->belongsTo(Concert::class);
    }

    public function entries(): HasMany
    {
        return $this->hasMany(SetlistEntry::class, 'setlist_id', 'id');
    }
}
