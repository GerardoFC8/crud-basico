<?php

namespace App\Http\Controllers;

use App\Models\UserType;
use Illuminate\Http\Request;

class UserTypeController extends Controller
{
    public function __construct()
    {
        // Puedes agregar aquí tus middlewares de permisos si lo deseas
        // $this->middleware('can:user_types.index')->only('index');
    }

    public function index()
    {
        $userTypes = UserType::all();
        return view('user-types.index', compact('userTypes'));
    }

    public function create()
    {
        return view('user-types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:user_types,name',
            'description' => 'nullable|string',
        ]);

        UserType::create($request->all());

        return redirect()->route('user-types.index')->with('success', 'Tipo de usuario creado correctamente.');
    }

    public function edit(UserType $userType)
    {
        return view('user-types.edit', compact('userType'));
    }

    public function update(Request $request, UserType $userType)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:user_types,name,' . $userType->id,
            'description' => 'nullable|string',
        ]);

        $userType->update($request->all());

        return redirect()->route('user-types.index')->with('success', 'Tipo de usuario actualizado correctamente.');
    }

    public function destroy(UserType $userType)
    {
        // Considera la lógica de qué hacer con los usuarios de este tipo.
        // Por ahora, simplemente lo eliminamos.
        $userType->delete();

        return redirect()->route('user-types.index')->with('success', 'Tipo de usuario eliminado correctamente.');
    }
}
