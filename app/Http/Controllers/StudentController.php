<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Http\Requests\StudentStoreRequest;
use App\Http\Requests\StudentUpdateRequest;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }
    
    public function store(StudentStoreRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($request->password);
        $data['status'] = true; // Asignar un valor por defecto si es necesario

        Student::create($data);

        return redirect()->route('students.index')->with('success', 'Estudiante creado exitosamente.');
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(StudentUpdateRequest $request, Student $student)
    {
        $data = $request->validated();
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            // Excluimos la contraseña si el campo está vacío
            unset($data['password']);
        }

        $student->update($data);

        return redirect()->route('students.index')->with('success', 'Estudiante actualizado exitosamente.');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Estudiante eliminado exitosamente.');
    }
}