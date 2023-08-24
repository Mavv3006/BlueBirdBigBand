<?php

namespace App\Http\Controllers\v2;

use App\Http\Controllers\Controller;
use App\Models\Concert;
use Illuminate\Http\Request;

class ConcertDetailsPageController extends Controller
{
    public function __invoke(Request $request, Concert $concert)
    {
        return $concert;
    }
}
