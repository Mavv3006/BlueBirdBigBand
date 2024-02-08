<?php

namespace App\Models;

use App\Enums\NewsletterType;
use App\Enums\StateMachines\NewsletterState;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsletterRequest extends Model
{
    use HasFactory;

    protected $casts = [
        'status' => NewsletterState::class,
        'type' => NewsletterType::class,
    ];
}
