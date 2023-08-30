<?php

namespace App\Livewire;

use App\Livewire\Forms\LoginForm;
use App\Services\Auth\AuthService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Login extends Component
{
    public LoginForm $form;

    protected AuthService $authService;

    public function mount(
        AuthService $authService,
    ) {
    }

    public function login()
    {
        $this->form->login($this->authService);
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.login');
    }
}
