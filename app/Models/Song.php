<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Song extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_path',
        'title',
        'author',
        'genre',
        'arranger',
        'size',
    ];

    public function setlistEntries(): HasMany
    {
        return $this->hasMany(SetlistEntry::class);
    }
}
