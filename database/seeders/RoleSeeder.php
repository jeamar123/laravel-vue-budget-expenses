<?php

namespace Database\Seeders;

use App\Enums\Role;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role as SpatieRole;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    protected const PERMISSIONS = [
        'user:view',
        'user:create',
        'user:update',
        'user:delete',
        'activity_log:view',
        'activity_log:create',
        'activity_log:update',
        'activity_log:delete',
        'transaction:view',
        'transaction:create',
        'transaction:update',
        'transaction:delete',
        'category:view',
        'category:create',
        'category:update',
        'category:delete',
        'account:view',
        'account:create',
        'account:update',
        'account:delete',
    ];

    protected const ROLES = [
        // Role::SUPER_ADMIN->value => [
        'super_admin' => [
            'user:view',
            'user:create',
            'user:update',
            'user:delete',
            'activity_log:view',
            'activity_log:create',
            'activity_log:update',
            'activity_log:delete',
            'transaction:view',
            'transaction:create',
            'transaction:update',
            'transaction:delete',
            'category:view',
            'category:create',
            'category:update',
            'category:delete',
            'account:view',
            'account:create',
            'account:update',
            'account:delete',
        ],
        // Role::USER->value => [
        'user' => [
            'user:view',
            'user:update',
            'transaction:view',
            'transaction:create',
            'transaction:update',
            'transaction:delete',
            'category:view',
            'category:create',
            'category:update',
            'category:delete',
            'account:view',
            'account:create',
            'account:update',
            'account:delete',
        ]
    ];

    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        foreach (self::PERMISSIONS as $permission) {
           Permission::findOrCreate($permission);
        }

        foreach (self::ROLES as $name => $permissions) {
            SpatieRole::create(['name' => $name])
                ->permissions()
                ->sync(Permission::whereIn('name', $permissions)->pluck('id'));
        }
    }
}
