<?php

namespace App\Models;

use App\Enums\NewsletterType;
use App\Enums\StateMachines\NewsletterState;
use App\StateMachines\NewsletterRequest\BaseNewsletterState;
use App\StateMachines\NewsletterRequest\CompletedNewsletterState;
use App\StateMachines\NewsletterRequest\ConfirmedNewsletterState;
use App\StateMachines\NewsletterRequest\RequestedNewsletterState;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsletterRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'completed_at',
        'confirmed_at',
        'email',
        'type',
    ];

    protected $casts = [
        'status' => NewsletterState::class,
        'type' => NewsletterType::class,
    ];

    public function state(): BaseNewsletterState
    {
        return match ($this->status) {
            NewsletterState::Requested => new RequestedNewsletterState($this),
            NewsletterState::Confirmed => new ConfirmedNewsletterState($this),
            NewsletterState::Completed => new CompletedNewsletterState($this)
        };
    }
}
