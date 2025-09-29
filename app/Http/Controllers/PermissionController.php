<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionStoreRequest;
use App\Http\Requests\PermissionUpdateRequest;
use App\Models\Permission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:permissions.index')->only('index');
        $this->middleware('can:permissions.create')->only(['create', 'store']);
        $this->middleware('can:permissions.edit')->only(['edit', 'update']);
        $this->middleware('can:permissions.destroy')->only('destroy');
    }
    
    public function index(Request $request): View
    {
        $permissions = Permission::all();
        return view('permission.index', compact('permissions'));
    }

    public function create(Request $request): View
    {
        return view('permission.create');
    }

    public function store(PermissionStoreRequest $request): RedirectResponse
    {
        Permission::create($request->validated());

        return redirect()->route('permissions.index');
    }

    public function show(Request $request, Permission $permission): View
    {
        return view('permission.show', [
            'permission' => $permission,
        ]);
    }

    public function edit(Request $request, Permission $permission): View
    {
        return view('permission.edit', [
            'permission' => $permission,
        ]);
    }

    public function update(PermissionUpdateRequest $request, Permission $permission): RedirectResponse
    {
        $permission->update($request->validated());

        return redirect()->route('permissions.index');
    }

    public function destroy(Request $request, Permission $permission): RedirectResponse
    {
        $permission->delete();

        return redirect()->route('permissions.index');
    }
}
