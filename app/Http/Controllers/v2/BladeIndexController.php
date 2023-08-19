<?php

namespace App\Http\Controllers\v2;

use App\Http\Controllers\Controller;

class BladeIndexController extends Controller
{
    public function __invoke()
    {
        return view('index');
    }
}
