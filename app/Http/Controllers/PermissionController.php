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
        $permission = Permission::create($request->validated());

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
