<?php

namespace App\Http\Controllers\v2;

use App\Http\Controllers\Controller;

class ConcertsPageController extends Controller
{
    public function __invoke()
    {
        return view('components.pages.concerts');
    }
}
