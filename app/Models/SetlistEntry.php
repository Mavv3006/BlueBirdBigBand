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

    public function setlistHeader(): BelongsTo
    {
        return $this->belongsTo(SetlistHeader::class, 'setlist_id', 'id');
    }
}
