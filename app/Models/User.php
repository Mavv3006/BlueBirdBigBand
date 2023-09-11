<?php

namespace App\Models;

use App\Enums\StateMachines\UserStates;
use App\StateMachines\User\ActivatedUserState;
use App\StateMachines\User\BaseUserState;
use App\StateMachines\User\RegisteredUserState;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
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
}
