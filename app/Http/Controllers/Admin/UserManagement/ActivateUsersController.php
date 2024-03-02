<?php

namespace App\Http\Controllers\Admin\UserManagement;

use App\DataTransferObjects\View\InertiaMetaInfoDto;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\User\UserService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class ActivateUsersController extends BaseAdminController
{
    public function __construct(
        protected UserService $userService,
    ) {
        parent::__construct();
    }

    public function show(): Response
    {
        Gate::authorize('manage users');

        return Inertia::render(
            'Admin/ActivateUsers',
            ['users' => $this->userService->getNonActivatedUsers()]
        );
    }

    /**
     * @throws Exception
     */
    public function update(User $user): RedirectResponse
    {
        Gate::authorize('manage users');

        $user->state()->activate();

        return back();
    }
}
