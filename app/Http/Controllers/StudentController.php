<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $students = Student::all();
            
        return view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombres' => 'required|string|max:255',
            'correo' => 'required|email|unique:students,correo',
            'cedula' => 'required|string|unique:students,cedula|max:20',
            'edad' => 'nullable|integer|min:1',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'status' => 'required|in:activo,inactivo,graduado',
        ]);

        Student::create($request->all());

        return redirect()->route('students.index')
                         ->with('success', 'Estudiante creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        // En una aplicación real, podrías tener una vista 'show'.
        // Por simplicidad, redirigimos a la edición.
        return view('students.edit', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'nombres' => 'required|string|max:255',
            'correo' => 'required|email|unique:students,correo,' . $student->id,
            'cedula' => 'required|string|unique:students,cedula,' . $student->id . '|max:20',
            'edad' => 'nullable|integer|min:1',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'status' => 'required|in:activo,inactivo,graduado',
        ]);

        $student->update($request->all());

        return redirect()->route('students.index')
                         ->with('success', 'Estudiante actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index')
                         ->with('success', 'Estudiante eliminado exitosamente.');
    }
}
