<?php

namespace App\Livewire\Forms;

use App\DataTransferObjects\AuthenticateDto;
use App\Services\Auth\AuthService;
use Livewire\Attributes\Rule;
use Livewire\Form;

class LoginForm extends Form
{
    #[Rule('required|string')]
    public string $name;

    #[Rule('required|string')]
    public string $password;

    public function login(AuthService $service): void
    {
        $dto = new AuthenticateDto(
            name: $this->name,
            password: $this->password,
        );
        $service->authenticate($dto);
        session()->regenerate();
    }
}
