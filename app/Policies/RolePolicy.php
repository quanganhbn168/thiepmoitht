<?php

namespace App\Policies;

use App\Models\User;

class RolePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    public function view(User $user, $role): bool
    {
        return $user->isSuperAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    public function update(User $user, $role): bool
    {
        return $user->isSuperAdmin();
    }

    public function delete(User $user, $role): bool
    {
        return $user->isSuperAdmin();
    }
}
