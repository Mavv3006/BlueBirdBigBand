<?php

namespace App\Services\Auth;

use App\DataTransferObjects\AuthenticateDto;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthService
{
    private string $username;

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws ValidationException
     */
    public function authenticate(AuthenticateDto $dto): void
    {
        $this->username = $dto->name;

        $this->ensureIsNotRateLimited();

        $user = User::where('name', $dto->name)->first();

        if (!$user->activated) {
            throw ValidationException::withMessages(['name' => trans('auth.activated')]);
        }

        $isAuthenticated = Auth::attempt([
            'name' => $dto->name,
            'password' => $dto->password,
        ]);

        if (!$isAuthenticated) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages(['name' => trans('auth.failed')]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages(['name' => trans('auth.throttle', ['seconds' => $seconds, 'minutes' => ceil($seconds / 60)])]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->username).'|'.request()->ip());
    }
}
