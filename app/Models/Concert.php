<?php

namespace App\Models;

use App\Enums\ConcertStatus;
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
        'status' => ConcertStatus::class,
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
        'konzertmeister_event_id',
        'status',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /** @return BelongsTo<Band, $this> */
    public function band(): BelongsTo
    {
        return $this->belongsTo(Band::class, 'band_id', 'id');
    }

    /** @return BelongsTo<Venue, $this> */
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

    public function konzertmeisterEvent(): BelongsTo
    {
        return $this->belongsTo(KonzertmeisterEvent::class);
    }

    public function setPublic(): void
    {
        $this->update(['status' => ConcertStatus::Public]);
    }
}
