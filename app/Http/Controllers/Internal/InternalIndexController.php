<?php

namespace App\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class InternalIndexController extends Controller
{
    public function __invoke(): \Illuminate\Contracts\Foundation\Application|Application|RedirectResponse|Redirector
    {
        return redirect(route('home'), 301);
    }
}
