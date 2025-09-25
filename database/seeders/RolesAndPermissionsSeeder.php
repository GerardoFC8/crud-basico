<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('model_has_permissions')->truncate();
        Role::truncate();
        DB::table('model_has_roles')->truncate();
        Permission::truncate();
        DB::table('role_has_permissions')->truncate();
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // create permissions
        $permissions = [
            'posts.index',
            'posts.create',
            'posts.edit',
            'posts.destroy',
            'categories.index',
            'categories.create',
            'categories.edit',
            'categories.destroy',
            'roles.index',
            'roles.create',
            'roles.edit',
            'roles.destroy',
            'permissions.index',
            'permissions.create',
            'permissions.edit',
            'permissions.destroy',
            'users.index',
            'users.edit',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // create roles and assign existing permissions
        $roleAdmin = Role::create(['name' => 'Admin']);
        // Admin gets all permissions
        $roleAdmin->givePermissionTo(Permission::all());

        $rolePosts = Role::create(['name' => 'PostsManager']);
        $rolePosts->givePermissionTo([
            'posts.index',
            'posts.create',
            'posts.edit',
            'posts.destroy',
        ]);

        $roleCategories = Role::create(['name' => 'CategoriesManager']);
        $roleCategories->givePermissionTo([
            'categories.index',
            'categories.create',
            'categories.edit',
            'categories.destroy',
        ]);
    }
}
