<?php

namespace App\Filament\Customer\Auth;

use App\Models\User;
use App\Support\VietnamesePhoneNumber;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\Register as BaseRegister;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Register extends BaseRegister
{
    protected function getPhoneFormComponent(): Component
    {
        return TextInput::make('phone')
            ->label('Số điện thoại')
            ->tel()
            ->required()
            ->maxLength(20)
            ->placeholder('VD: 0987 654 321')
            ->dehydrateStateUsing(fn (mixed $state): string => VietnamesePhoneNumber::normalize($state))
            ->rule(function (): \Closure {
                return function (string $attribute, mixed $value, \Closure $fail): void {
                    $phone = VietnamesePhoneNumber::normalize($value);

                    if (! VietnamesePhoneNumber::isValid($phone)) {
                        $fail('Số điện thoại cần là số di động Việt Nam hợp lệ.');

                        return;
                    }

                    if (User::query()->where('phone', $phone)->exists()) {
                        $fail('Số điện thoại này đã được dùng cho tài khoản khác.');
                    }
                };
            });
    }

    /**
     * @return array<int | string, string | Form>
     */
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPhoneFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeRegister(array $data): array
    {
        $data['phone'] = VietnamesePhoneNumber::normalize($data['phone'] ?? null);

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected function handleRegistration(array $data): Model
    {
        /** @var User $user */
        $user = parent::handleRegistration($data);

        Role::findOrCreate(User::ROLE_CUSTOMER);
        $user->assignRole(User::ROLE_CUSTOMER);

        return $user;
    }

    public function getTitle(): string
    {
        return 'Tạo tài khoản';
    }

    public function getHeading(): string
    {
        return 'Tạo tài khoản quản lý thiệp';
    }
}
