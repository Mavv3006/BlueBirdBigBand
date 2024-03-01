<?php

namespace App\DataTransferObjects\View;

readonly class InertiaMetaInfoDto
{
    public string $title;

    public string $description;

    public string $url;

    public function __construct()
    {
        $this->url = config('app.url');
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
}
