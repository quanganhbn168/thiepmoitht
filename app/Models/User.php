<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasRoles, Notifiable;

    // Role constants
    const ROLE_SUPER_ADMIN = 'super_admin';

    const ROLE_ADMIN = 'admin';

    const ROLE_AGENT = 'agent';

    const ROLE_CUSTOMER = 'customer';

    // Super admin email (hidden everywhere)
    const SUPER_ADMIN_EMAIL = 'quanganhadmin@thtmedia.com.vn';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Keep the administration and customer workspaces separate.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return match ($panel->getId()) {
            'admin' => $this->isAdmin()
                || $this->hasRole(self::ROLE_AGENT)
                || $this->role === self::ROLE_AGENT,
            'customer' => $this->isCustomer(),
            default => false,
        };
    }

    // ==========================================
    // ROLE CHECKS
    // ==========================================

    public function isSuperAdmin(): bool
    {
        return $this->email === self::SUPER_ADMIN_EMAIL || $this->hasRole('super_admin');
    }

    public function isAdmin(): bool
    {
        return $this->isSuperAdmin()
            || $this->hasRole(self::ROLE_ADMIN)
            || $this->role === self::ROLE_ADMIN;
    }

    public function isCustomer(): bool
    {
        return $this->hasRole(self::ROLE_CUSTOMER) || $this->role === self::ROLE_CUSTOMER;
    }

    public function getRoleLabel(): string
    {
        if ($this->isSuperAdmin()) {
            return 'Super Admin';
        }

        $roles = $this->roles->pluck('name')->toArray();
        if (empty($roles)) {
            return 'Chưa phân quyền';
        }

        return implode(', ', $roles);
    }

    // ==========================================
    // RELATIONSHIPS
    // ==========================================
    public function gatherings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Gathering::class);
    }

    public function weddings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Wedding::class);
    }
}
