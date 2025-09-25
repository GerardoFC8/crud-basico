<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }

    public function edit(User $user): View
    {
        $roles = Role::all();
        $permissions = Permission::all();
        
        $permissionsViaRoles = $user->getPermissionsViaRoles();

        return view('user.edit', [
            'user' => $user,
            'roles' => $roles,
            'permissions' => $permissions,
            'permissionsViaRoles' => $permissionsViaRoles,
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);
        
        DB::beginTransaction();
        try {
            $roleIds = $request->input('roles', []);
            $roles = Role::whereIn('id', $roleIds)->pluck('name');
            $user->syncRoles($roles);
            
            $permissionIds = $request->input('permissions', []);
            $permissions = Permission::whereIn('id', $permissionIds)->pluck('name');

            $user->syncPermissions($permissions);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar roles/permisos de usuario: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar el usuario.');
        }

        return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente.');
    }
}