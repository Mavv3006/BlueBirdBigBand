<?php

namespace App\Http\Controllers\Auth;

use App\DataTransferObjects\View\InertiaMetaInfoDto;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        $service = App::make(InertiaMetaInfoDto::class);
        $service->setTitle('');
        $service->setDescription('');

        return Inertia::render('Auth/Register', ['status' => '']);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): Response
    {
        $service = App::make(InertiaMetaInfoDto::class);
        $service->setTitle('');
        $service->setDescription('');

        $request->validate([
            'name' => 'required|string|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        return Inertia::render('Auth/Register', [
            'status' => __('messages.register-success', ['username' => $request->name]),
        ]);
    }
}
