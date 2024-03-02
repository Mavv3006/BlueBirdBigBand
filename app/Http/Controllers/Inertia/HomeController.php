<?php

namespace App\Http\Controllers\Inertia;

use Inertia\Inertia;
use Inertia\Response;

class HomeController extends BaseInertiaController
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
        return Inertia::render('Index');
    }
}
