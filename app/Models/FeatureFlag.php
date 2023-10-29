<?php

namespace App\Models;

use App\Enums\FeatureFlagName;
use App\Enums\StateMachines\FeatureFlagState;
use App\StateMachines\FeatureFlag\BaseFeatureFlagState;
use App\StateMachines\FeatureFlag\OffFeatureFlagState;
use App\StateMachines\FeatureFlag\OnFeatureFlagState;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeatureFlag extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'name',
    ];

    protected $casts = [
        'name' => FeatureFlagName::class,
        'status' => FeatureFlagState::class,
    ];

    protected $attributes = [
        'status' => FeatureFlagState::Off,
    ];

    protected $primaryKey = 'name';

    public $incrementing = false;

    public function state(): BaseFeatureFlagState
    {
        return match ($this->status) {
            FeatureFlagState::On => new OnFeatureFlagState($this),
            FeatureFlagState::Off => new OffFeatureFlagState($this),
        };
    }
}
