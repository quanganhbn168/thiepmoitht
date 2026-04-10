<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    // Role constants
    const ROLE_SUPER_ADMIN = 'super_admin';
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
        'password',
        'role',
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
     * Filament access control - Single Panel
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return true; // Use Shield to restrict actual resources inside the panel
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
        return $this->isSuperAdmin() || $this->hasRole('admin');
    }

    public function isCustomer(): bool
    {
        return $this->hasRole('customer');
    }

    public function getRoleLabel(): string
    {
        if ($this->isSuperAdmin()) return 'Super Admin';
        
        $roles = $this->roles->pluck('name')->toArray();
        if (empty($roles)) return 'Chưa phân quyền';
        
        return implode(', ', $roles);
    }

    // ==========================================
    // RELATIONSHIPS
    // ==========================================

}
