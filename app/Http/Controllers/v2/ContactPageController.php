<?php

namespace App\Http\Controllers\v2;

use App\Http\Controllers\Controller;

class ContactPageController extends Controller
{
    public function __invoke()
    {
        return view('components.pages.contact');
    }
}
