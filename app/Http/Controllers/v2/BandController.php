<?php

namespace App\Http\Controllers\v2;

use App\Http\Controllers\Controller;

class BandController extends Controller
{
    public function __invoke()
    {
        return view('components.pages.band');
    }
}
