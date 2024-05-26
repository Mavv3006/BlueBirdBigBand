<?php

namespace App\Http\Requests\Auth;

use App\Enums\StateMachines\UserStates;
use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        try {
            $user = User::where('name', $this->only('name'))->firstOrFail();

            if ($user->status != UserStates::Activated) {
                Log::notice('User is not activated', ['user_id' => $user->id, 'user_name' => $user->name]);
                throw ValidationException::withMessages(['name' => trans('auth.activated')]);
            }

            $isAuthenticated = Auth::attempt($this->only('name', 'password'));

            if (!$isAuthenticated) {
                RateLimiter::hit($this->throttleKey());
                Log::notice('User failed to login.', ['user_id' => $user->id, 'user_name' => $user->name]);

                throw ValidationException::withMessages(['name' => trans('auth.failed')]);
            }

            Log::notice('User successfully logged in.', ['user_id' => $user->id, 'user_name' => $user->name]);
            RateLimiter::clear($this->throttleKey());

        } catch (ModelNotFoundException) {
            Log::notice('User not found.', ['user_name' => $this->only('name')]);
            throw ValidationException::withMessages(['name' => trans('auth.failed')]);
        }
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

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages(['name' => trans('auth.throttle', ['seconds' => $seconds, 'minutes' => ceil($seconds / 60)])]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('name')).'|'.$this->ip());
    }
}
