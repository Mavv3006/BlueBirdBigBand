<?php

namespace App\Services\KonzertmeisterIntegration;

use App\Models\KonzertmeisterEvent;

class KonzertmeisterEventsCountSingleton
{
    private ?int $count = null;

    private static ?self $instance = null;

    public function getCount(): int
    {
        if (is_null($this->count)) {
            $this->count = KonzertmeisterEvent::query()->count();
        }

        return $this->count;
    }

    protected function __construct() {}

    public static function getInstance(): static
    {
        if (self::$instance === null) {
            self::$instance = new static;
        }

        return self::$instance;
    }
}
