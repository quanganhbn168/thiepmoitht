<?php

namespace App\Policies;

use App\Models\ReunionMessage;
use App\Models\User;

class ReunionMessagePolicy
{
    public function before(User $user): ?bool
    {
        return $user->isSuperAdmin() ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_reunion::message');
    }

    public function view(User $user, ReunionMessage $reunionMessage): bool
    {
        return $user->can('view_reunion::message')
            && $this->ownsReunion($user, $reunionMessage);
    }

    public function create(User $user): bool
    {
        return $user->can('create_reunion::message');
    }

    public function update(User $user, ReunionMessage $reunionMessage): bool
    {
        return $user->can('update_reunion::message')
            && $this->ownsReunion($user, $reunionMessage);
    }

    public function delete(User $user, ReunionMessage $reunionMessage): bool
    {
        return $user->can('delete_reunion::message')
            && $this->ownsReunion($user, $reunionMessage);
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_reunion::message');
    }

    public function forceDelete(User $user, ReunionMessage $reunionMessage): bool
    {
        return $user->can('force_delete_reunion::message')
            && $this->ownsReunion($user, $reunionMessage);
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_reunion::message');
    }

    public function restore(User $user, ReunionMessage $reunionMessage): bool
    {
        return $user->can('restore_reunion::message')
            && $this->ownsReunion($user, $reunionMessage);
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_reunion::message');
    }

    public function replicate(User $user, ReunionMessage $reunionMessage): bool
    {
        return $user->can('replicate_reunion::message')
            && $this->ownsReunion($user, $reunionMessage);
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_reunion::message');
    }

    private function ownsReunion(User $user, ReunionMessage $reunionMessage): bool
    {
        $ownerId = $reunionMessage->relationLoaded('reunion')
            ? $reunionMessage->reunion?->user_id
            : $reunionMessage->reunion()->value('user_id');

        return (int) $ownerId === (int) $user->id;
    }
}
