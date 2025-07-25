<?php

namespace App\Models;

use App\Enums\StateMachines\UserStates;
use App\StateMachines\User\ActivatedUserState;
use App\StateMachines\User\BaseUserState;
use App\StateMachines\User\RegisteredUserState;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens;
    use HasFactory;
    use HasRoles;
    use Notifiable;

    protected $fillable = [
        'name',
        'password',
        'status',
    ];

    protected $casts = [
        'status' => UserStates::class,
    ];

    protected $attributes = [
        'status' => UserStates::Registered,
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected array $guard_name = ['api', 'web'];

    public function state(): BaseUserState
    {
        return match ($this->status) {
            UserStates::Registered => new RegisteredUserState($this),
            UserStates::Activated => new ActivatedUserState($this)
        };
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasPermissionTo('route.access-admin');
    }
}
