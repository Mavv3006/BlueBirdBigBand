<?php

namespace App\DataTransferObjects;

use App\Enums\NewsletterType;
use App\Enums\StateMachines\NewsletterState;

readonly class NewsletterRequestDto
{
    public function __construct(
        public string $email,
        public NewsletterType $type,
        public ?bool $data_privacy_consent,
        public ?string $data_privacy_consent_text,
        public string $ip_address,
        public NewsletterState $status
    ) {}
}
