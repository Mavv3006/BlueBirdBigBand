<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Concert extends Model
{
    use HasFactory;

    protected $casts = [
        'date' => 'datetime',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    protected $fillable = [
        'start_time',
        'end_time',
        'venue_street',
        'venue_street_number',
        'event_description',
        'venue_description',
        'band_id',
        'date',
        'venue_plz',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function band(): BelongsTo
    {
        return $this->belongsTo(Band::class, 'band_id', 'id');
    }

    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class, 'venue_plz', 'plz');
    }

    public function setlist(): HasMany
    {
        return $this->hasMany(SetlistEntry::class);
    }

    public function isUpcoming(): bool
    {
        return $this->date >= Carbon::today()->toDateString();
    }

    public function isPlayed(): bool
    {
        return $this->date < Carbon::today()->toDateString();
    }
}
