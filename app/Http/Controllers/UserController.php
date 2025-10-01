<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:users.index')->only('index');
        // $this->middleware('can:users.create')->only(['create', 'store']);
        $this->middleware('can:users.edit')->only(['edit', 'update']);
        $this->middleware('can:users.destroy')->only('destroy');
    }

    public function index(): View
    {
        $users = User::with('userType', 'roles')->get();
        return view('user.index', compact('users'));
    }

    public function create(): View
    {
        $userTypes = UserType::all();
        $roles = Role::all();
        return view('user.create', compact('userTypes', 'roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'user_type_id' => ['required', 'exists:user_types,id'],
            'roles' => ['nullable', 'array']
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type_id' => $request->user_type_id,
        ]);

        $user->syncRoles($request->roles);

        return redirect()->route('users.index')->with('success', 'Usuario creado correctamente.');
    }

    public function edit(User $user): View
    {
        $userTypes = UserType::all();
        $roles = Role::all();
        $user->load('roles');

        return view('user.edit', compact('user', 'userTypes', 'roles'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'user_type_id' => ['required', 'exists:user_types,id'],
            'roles' => ['nullable', 'array']
        ]);

        $data = $request->only('name', 'email', 'user_type_id');
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        $user->syncRoles($request->roles);

        return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente.');
    }
    
    public function destroy(User $user): RedirectResponse
    {
        // Evitar que un admin se elimine a sí mismo
        if (auth()->id() == $user->id) {
            return back()->with('error', 'No puedes eliminar tu propio usuario.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuario eliminado correctamente.');
    }
}
