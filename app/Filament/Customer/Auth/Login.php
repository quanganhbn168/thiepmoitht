<?php

namespace App\Filament\Customer\Auth;

use App\Support\VietnamesePhoneNumber;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Support\Str;

class Login extends BaseLogin
{
    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('login')
            ->label('Số điện thoại hoặc email')
            ->placeholder('VD: 0987 654 321 hoặc ban@email.com')
            ->required()
            ->autocomplete('username')
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1]);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function getCredentialsFromFormData(array $data): array
    {
        $login = trim((string) ($data['login'] ?? ''));

        return [
            filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone' => filter_var($login, FILTER_VALIDATE_EMAIL)
                ? Str::lower($login)
                : VietnamesePhoneNumber::normalize($login),
            'password' => $data['password'],
        ];
    }
}
