<?php

namespace App\Http\Controllers\Inertia;

use Inertia\Inertia;
use Inertia\Response;

class AboutUsController extends BaseInertiaController
{
    public function getDescription(): string
    {
        return 'bla bla bla';
    }

    public function getTitle(): string
    {
        return 'this is a test';
    }

    public function render(): Response
    {
        return Inertia::render('Band/AboutPage');
    }
}
