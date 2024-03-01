<?php

namespace App\Http\Controllers\Inertia;

use App\Http\Controllers\Inertia\BaseInertiaController;
use Inertia\Inertia;
use Inertia\Response;

class ImprintController extends BaseInertiaController
{

    public function getDescription(): string
    {
        return '';
    }

    public function getTitle(): string
    {
        return '';
    }

    public function render(): Response
    {
        return Inertia::render('Contact/ImprintPage');
    }
}
