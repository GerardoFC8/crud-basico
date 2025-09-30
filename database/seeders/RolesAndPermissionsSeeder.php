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

        // --- Crear Permisos para el guard 'web' ---
        $web_permissions = [
            'posts.index', 'posts.create', 'posts.edit', 'posts.destroy',
            'categories.index', 'categories.create', 'categories.edit', 'categories.destroy',
            'roles.index', 'roles.create', 'roles.edit', 'roles.destroy',
            'permissions.index', 'permissions.create', 'permissions.edit', 'permissions.destroy',
            'users.index', 'users.edit',
            'professors.index', 'professors.create', 'professors.edit', 'professors.destroy',
            'students.index', 'students.create', 'students.edit', 'students.destroy',
        ];

        foreach ($web_permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }
        
        // --- Crear Permisos compartidos para todos los guards ---
        Permission::create(['name' => 'dashboard.view', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard.view', 'guard_name' => 'professor']);
        Permission::create(['name' => 'dashboard.view', 'guard_name' => 'student']);

        // --- Crear Roles ---

        // Rol de Administrador (guard 'web')
        $roleAdmin = Role::create(['name' => 'Admin', 'guard_name' => 'web']);
        $roleAdmin->givePermissionTo(Permission::where('guard_name', 'web')->get());

        // Rol para gestionar Posts (guard 'web')
        $rolePosts = Role::create(['name' => 'PostsManager', 'guard_name' => 'web']);
        $rolePosts->givePermissionTo(['posts.index', 'posts.create', 'posts.edit', 'posts.destroy']);

        // Rol para Profesores (guard 'professor')
        $roleProfessor = Role::create(['name' => 'Profesor', 'guard_name' => 'professor']);
        $roleProfessor->givePermissionTo(Permission::where('guard_name', 'professor')->get());

        // Rol para Alumnos (guard 'student')
        $roleStudent = Role::create(['name' => 'Alumno', 'guard_name' => 'student']);
        $roleStudent->givePermissionTo(Permission::where('guard_name', 'student')->get());
    }
}