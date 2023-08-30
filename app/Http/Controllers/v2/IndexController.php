<?php

namespace App\Http\Controllers\v2;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function __invoke()
    {
        return view('index');
    }
}
