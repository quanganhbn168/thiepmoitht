<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\VietnamesePhoneNumber;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:20', function (string $attribute, mixed $value, \Closure $fail): void {
                $phone = VietnamesePhoneNumber::normalize($value);

                if (! VietnamesePhoneNumber::isValid($phone)) {
                    $fail('Số điện thoại cần là số di động Việt Nam hợp lệ.');

                    return;
                }

                if (User::query()->where('phone', $phone)->exists()) {
                    $fail('Số điện thoại này đã được dùng cho tài khoản khác.');
                }
            }],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => VietnamesePhoneNumber::normalize($request->phone),
            'password' => Hash::make($request->password),
        ]);

        Role::findOrCreate(User::ROLE_CUSTOMER);
        $user->assignRole(User::ROLE_CUSTOMER);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
