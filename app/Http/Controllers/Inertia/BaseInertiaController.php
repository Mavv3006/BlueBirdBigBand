<?php

namespace App\Http\Controllers\Inertia;

use App\DataTransferObjects\View\InertiaMetaInfoDto;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Inertia\Response;

abstract class BaseInertiaController extends Controller
{
    abstract public function getDescription(): string;

    abstract public function getTitle(): string;

    public function getImageUrl(): ?string
    {
        return null;
    }

    abstract public function render(): Response;

    protected function setUpMetaInfos(): void
    {
        $service = App::make(InertiaMetaInfoDto::class);
        $service->setTitle($this->getTitle());
        $service->setDescription($this->getDescription());
        $service->setImageUrl($this->getImageUrl());
    }

    public function __invoke(): Response
    {
        $this->setUpMetaInfos();

        return $this->render();
    }
}
