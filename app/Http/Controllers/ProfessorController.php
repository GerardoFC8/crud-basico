<?php

namespace App\Http\Controllers;

use App\Models\Professor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class ProfessorController extends Controller
{
    public function __construct()
    {
        // Proteger las rutas con permisos
        $this->middleware('can:professors.index')->only('index');
        $this->middleware('can:professors.create')->only('create', 'store');
        $this->middleware('can:professors.edit')->only('edit', 'update');
        $this->middleware('can:professors.destroy')->only('destroy');
    }

    public function index()
    {
        $professors = Professor::all();
        return view('professors.index', compact('professors'));
    }

    public function create()
    {
        $roles = Role::where('guard_name', 'professor')->get();
        return view('professors.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:professors',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'nullable|array'
        ]);

        $professor = Professor::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($request->roles) {
            $professor->assignRole($request->roles);
        }

        return redirect()->route('professors.index')->with('success', 'Profesor creado exitosamente.');
    }

    public function edit(Professor $professor)
    {
        $roles = Role::where('guard_name', 'professor')->get();
        return view('professors.edit', compact('professor', 'roles'));
    }

    public function update(Request $request, Professor $professor)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:professors,email,' . $professor->id,
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'nullable|array'
        ]);

        $data = $request->only('name', 'email');
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $professor->update($data);

        $professor->syncRoles($request->roles ?? []);

        return redirect()->route('professors.index')->with('success', 'Profesor actualizado exitosamente.');
    }

    public function destroy(Professor $professor)
    {
        $professor->delete();
        return redirect()->route('professors.index')->with('success', 'Profesor eliminado exitosamente.');
    }
}
