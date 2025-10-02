<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleStoreRequest;
use App\Http\Requests\RoleUpdateRequest;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:roles.index')->only('index');
        $this->middleware('can:roles.create')->only(['create', 'store']);
        $this->middleware('can:roles.edit')->only(['edit', 'update']);
        $this->middleware('can:roles.destroy')->only('destroy');
    }
    
    public function index(Request $request): View
    {
        $roles = Role::with('permissions')->get();

        return view('role.index', [
            'roles' => $roles,
        ]);
    }

    public function create(Request $request): View
    {
        $permissions = Permission::all();
        $guards = array_keys(config('auth.guards'));

        return view('role.create', compact('permissions', 'guards'));
    }

    public function store(RoleStoreRequest $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            
            $role = Role::create($request->only('name', 'guard_name'));
            $role->permissions()->sync($request->input('permissions', []));
            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            // Log the error for debugging
            Log::error('Error creating role: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error al crear el rol.');
        }

        return redirect()->route('roles.index')->with('success', 'Rol creado exitosamente.');
    }

    public function show(Request $request, Role $role): View
    {
        $role->load('permissions');
        return view('role.show', [
            'role' => $role,
        ]);
    }

    public function edit(Request $request, Role $role): View
    {
        // Solo obtenemos los permisos que pertenecen al mismo guard que el rol
        $permissions = Permission::where('guard_name', $role->guard_name)->get();
        $role->load('permissions'); // Carga los permisos asociados a este rol

        return view('role.edit', [
            'role' => $role,
            'permissions' => $permissions,
        ]);
    }

    public function update(RoleUpdateRequest $request, Role $role): RedirectResponse
    {
        DB::beginTransaction();
        try {
            // Actualizamos solo el nombre, el guard no debería cambiar una vez creado.
            $role->update($request->only('name'));

            $role->permissions()->sync($request->input('permissions', []));
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            // Log the error for debugging
            Log::error('Error updating role: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar el rol.');
        }

        return redirect()->route('roles.index')->with('success', 'Rol actualizado exitosamente.');
    }

    public function destroy(Request $request, Role $role): RedirectResponse
    {
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Rol eliminado exitosamente.');
    }
}