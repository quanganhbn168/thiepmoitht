<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    private const RESOURCE_ACTIONS = [
        'view_any',
        'view',
        'create',
        'update',
        'delete',
        'delete_any',
        'force_delete',
        'force_delete_any',
        'restore',
        'restore_any',
        'replicate',
        'reorder',
    ];

    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $superAdmin = Role::findOrCreate(User::ROLE_SUPER_ADMIN);
        $admin = Role::findOrCreate(User::ROLE_ADMIN);
        $agent = Role::findOrCreate(User::ROLE_AGENT);
        $customer = Role::findOrCreate(User::ROLE_CUSTOMER);

        $reunionPermissions = $this->resourcePermissions('reunion');
        $messagePermissions = $this->resourcePermissions('reunion::message');
        $rsvpPermissions = $this->resourcePermissions('reunion::rsvp');

        collect()
            ->merge($reunionPermissions)
            ->merge($messagePermissions)
            ->merge($rsvpPermissions)
            ->unique()
            ->each(fn (string $permission): Permission => Permission::findOrCreate($permission));

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $customer->syncPermissions([
            ...$messagePermissions,
            ...$rsvpPermissions,
        ]);

        $agent->syncPermissions([
            ...$reunionPermissions,
            ...$messagePermissions,
            ...$rsvpPermissions,
        ]);

        $admin->syncPermissions(Permission::all());
        $superAdmin->syncPermissions(Permission::all());

        User::where('email', User::SUPER_ADMIN_EMAIL)->first()?->assignRole(User::ROLE_SUPER_ADMIN);

        User::query()
            ->where('email', '!=', User::SUPER_ADMIN_EMAIL)
            ->where('role', User::ROLE_CUSTOMER)
            ->get()
            ->each(fn (User $user) => $user->syncRoles([User::ROLE_CUSTOMER]));

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    private function resourcePermissions(string $resource): array
    {
        return array_map(
            fn (string $action): string => "{$action}_{$resource}",
            self::RESOURCE_ACTIONS,
        );
    }
}
