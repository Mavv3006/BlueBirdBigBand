<?php

namespace App\Models;

use App\Enums\KonzertmeisterEventType;
use App\Enums\StateMachines\KonzertmeisterEventConversionState;
use App\StateMachines\KonzertmeisterEvent\BaseKonzertmeisterEventConversionState;
use App\StateMachines\KonzertmeisterEvent\ConvertedKonzertmeisterEventConversionState;
use App\StateMachines\KonzertmeisterEvent\OpenKonzertmeisterEventConversionState;
use App\StateMachines\KonzertmeisterEvent\RejectedKonzertmeisterEventConversionState;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KonzertmeisterEvent extends Model
{
    use HasFactory;

    protected $casts = [
        'type' => KonzertmeisterEventType::class,
        'dtstart' => 'datetime',
        'dtend' => 'datetime',
        'conversion_state' => KonzertmeisterEventConversionState::class,
    ];

    public function concerts(): HasMany
    {
        return $this->hasMany(Concert::class);
    }

    public function band(): BelongsTo
    {
        return $this->belongsTo(Band::class);
    }

    public function conversionState(): BaseKonzertmeisterEventConversionState
    {
        return match ($this->conversion_state) {
            KonzertmeisterEventConversionState::Converted => new ConvertedKonzertmeisterEventConversionState($this),
            KonzertmeisterEventConversionState::Open => new OpenKonzertmeisterEventConversionState($this),
            KonzertmeisterEventConversionState::Rejected => new RejectedKonzertmeisterEventConversionState($this),
        };
    }
}
