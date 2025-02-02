<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\NewsletterRequestDto;
use App\Enums\NewsletterType;
use App\Enums\StateMachines\NewsletterState;
use App\Http\Requests\NewsletterRequestingRequest;
use App\Models\NewsletterRequest;
use App\Services\NewsletterRequest\NewsletterRequestService;
use Inertia\Inertia;

class NewsletterRequestController extends Controller
{
    public function request(NewsletterRequestingRequest $request)
    {
        $data = $request->validated();
        $type = NewsletterType::from($data['type']);
        $dto = new NewsletterRequestDto(
            email: $data['email'],
            type: $type,
            data_privacy_consent: $type == NewsletterType::Adding ? $data['data_privacy_consent'] : null,
            data_privacy_consent_text: $type == NewsletterType::Adding ? $data['data_privacy_consent_text'] : null,
            ip_address: $request->ip(),
            status: NewsletterState::Requested,
        );
        NewsletterRequestService::createNew($dto);
    }

    public function confirm(NewsletterRequest $newsletterRequest)
    {
        NewsletterRequestService::confirm($newsletterRequest);

        return redirect(route('newsletter.confirm.success'));
    }

    public function subscribe()
    {
        return Inertia::render('Newsletter/SubscribePage');
    }

    public function confirmSuccess()
    {
        return Inertia::render('Newsletter/ConfirmSuccess');
    }
}
