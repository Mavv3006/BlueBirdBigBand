<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsletterRequestingRequest;
use App\Models\NewsletterRequest;
use App\Services\NewsletterRequest\NewsletterRequestService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NewsletterRequestController extends Controller
{
    public function request(NewsletterRequestingRequest $request)
    {
        NewsletterRequestService::createNew($request);

        return redirect(route('newsletter'));
    }

    public function confirm(NewsletterRequest $newsletterRequest)
    {
        NewsletterRequestService::confirm($newsletterRequest);

        return redirect(route('newsletter.confirm.success'));
    }

    public function confirmSuccess(Request $request)
    {
        return Inertia::render('Newsletter/ConfirmSuccess');
    }
}
