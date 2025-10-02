<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Email as EmailRule;
use Illuminate\Validation\Rule;
use Livewire\Component;

class LoginForm extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;

    protected function rules(): array
    {
        return [
            'email' => [
                'required',
                Rule::exists('users','email'),
            ],
            'password' => ['required','min:6'],
        ];
    }

    protected array $messages = [
        'email.required' => 'Email wajib diisi.',
        'email.email'    => 'Format email tidak valid.',
        'email.exists'   => 'Email tidak terdaftar.',
        'password.required' => 'Kata sandi wajib diisi.',
        'password.min'      => 'Kata sandi minimal 6 karakter.',
    ];

    /** Validasi realtime per-field */
    public function updated($property): void
    {
        $this->validateOnly($property);
    }

    public function login()
    {
        $data = $this->validate();

        if (Auth::attempt(
            ['email' => $this->email, 'password' => $this->password],
            $this->remember
        )) {
            session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        // Jangan bocorkan apakah email valid saat gagal password
        $this->addError('password', 'Kredensial tidak valid.');
        return null;
    }

    public function render()
    {
        return view('livewire.auth.login-form', [
            'title' => 'Masuk',
        ])->layout('layouts.guest');
    }
}