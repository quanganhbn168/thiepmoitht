<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles
        $superAdmin = Role::create(['name' => User::ROLE_SUPER_ADMIN]);
        $admin = Role::create(['name' => User::ROLE_ADMIN]);
        $agent = Role::create(['name' => User::ROLE_AGENT]);
        $customer = Role::create(['name' => User::ROLE_CUSTOMER]);

        // Create permissions
        $permissions = [
            // Wedding permissions
            'view weddings',
            'create weddings',
            'edit weddings',
            'delete weddings',
            
            // User permissions
            'view users',
            'create users',
            'edit users',
            'delete users',
            
            // Agent permissions
            'view agents',
            'create agents',
            'edit agents',
            'delete agents',
            
            // Template permissions
            'view templates',
            'manage templates',
            
            // RSVP/Wishes permissions
            'view rsvps',
            'manage rsvps',
            'view wishes',
            'manage wishes',
            
            // Service permissions
            'view services',
            'manage services',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign all permissions to super_admin
        $superAdmin->givePermissionTo(Permission::all());

        // Assign permissions to admin
        $admin->givePermissionTo([
            'view weddings', 'create weddings', 'edit weddings', 'delete weddings',
            'view users', 'create users', 'edit users', 'delete users',
            'view agents', 'create agents', 'edit agents', 'delete agents',
            'view templates', 'manage templates',
            'view rsvps', 'manage rsvps',
            'view wishes', 'manage wishes',
            'view services', 'manage services',
        ]);

        // Assign permissions to agent
        $agent->givePermissionTo([
            'view weddings', 'create weddings', 'edit weddings',
            'view users', 'create users', 'edit users',  // Their customers
            'view rsvps', 'manage rsvps',
            'view wishes', 'manage wishes',
        ]);

        // Assign permissions to customer
        $customer->givePermissionTo([
            'view weddings', 'create weddings', 'edit weddings',
            'view rsvps',
            'view wishes',
        ]);

        // Assign super_admin role to the god user
        $godUser = User::where('email', User::SUPER_ADMIN_EMAIL)->first();
        if ($godUser) {
            $godUser->assignRole(User::ROLE_SUPER_ADMIN);
        }
    }
}
