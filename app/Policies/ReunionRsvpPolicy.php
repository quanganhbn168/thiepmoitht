<?php

namespace App\Policies;

use App\Models\ReunionRsvp;
use App\Models\User;

class ReunionRsvpPolicy
{
    public function before(User $user): ?bool
    {
        return $user->isSuperAdmin() ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_reunion::rsvp');
    }

    public function view(User $user, ReunionRsvp $reunionRsvp): bool
    {
        return $user->can('view_reunion::rsvp')
            && $this->ownsReunion($user, $reunionRsvp);
    }

    public function create(User $user): bool
    {
        return $user->can('create_reunion::rsvp');
    }

    public function update(User $user, ReunionRsvp $reunionRsvp): bool
    {
        return $user->can('update_reunion::rsvp')
            && $this->ownsReunion($user, $reunionRsvp);
    }

    public function delete(User $user, ReunionRsvp $reunionRsvp): bool
    {
        return $user->can('delete_reunion::rsvp')
            && $this->ownsReunion($user, $reunionRsvp);
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_reunion::rsvp');
    }

    public function forceDelete(User $user, ReunionRsvp $reunionRsvp): bool
    {
        return $user->can('force_delete_reunion::rsvp')
            && $this->ownsReunion($user, $reunionRsvp);
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_reunion::rsvp');
    }

    public function restore(User $user, ReunionRsvp $reunionRsvp): bool
    {
        return $user->can('restore_reunion::rsvp')
            && $this->ownsReunion($user, $reunionRsvp);
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_reunion::rsvp');
    }

    public function replicate(User $user, ReunionRsvp $reunionRsvp): bool
    {
        return $user->can('replicate_reunion::rsvp')
            && $this->ownsReunion($user, $reunionRsvp);
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_reunion::rsvp');
    }

    private function ownsReunion(User $user, ReunionRsvp $reunionRsvp): bool
    {
        $ownerId = $reunionRsvp->relationLoaded('reunion')
            ? $reunionRsvp->reunion?->user_id
            : $reunionRsvp->reunion()->value('user_id');

        return (int) $ownerId === (int) $user->id;
    }
}
