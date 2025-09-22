<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Student;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class StudentManager extends Component
{
    use WithPagination;

    // Propiedades del modelo
    public $student_id;
    public $nombres, $correo, $cedula, $edad, $telefono, $direccion, $status = 'activo';

    // Propiedades de la UI
    public $isOpen = 0;
    public $search = '';
    
    // Usar el tema de Tailwind para la paginación
    protected $paginationTheme = 'tailwind';

    // Definir las reglas de validación en un método para reutilizarlas
    protected function rules()
    {
        return [
            'nombres' => 'required|string|max:255',
            // Valida que el correo sea único, ignorando el del estudiante actual si se está editando
            'correo' => ['required', 'email', Rule::unique('students')->ignore($this->student_id)],
            // Valida que la cédula sea única, ignorando la del estudiante actual si se está editando
            'cedula' => ['required', 'string', 'max:20', Rule::unique('students')->ignore($this->student_id)],
            'edad' => 'nullable|integer|min:1',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'status' => 'required|in:activo,inactivo,graduado',
        ];
    }

    /**
     * Este es el "truco" para la validación en tiempo real.
     * Se ejecuta automáticamente cada vez que una propiedad vinculada con wire:model.live se actualiza.
     */
    public function updated($propertyName)
    {
        // Valida solo la propiedad que se acaba de actualizar
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        $students = Student::where('nombres', 'like', '%' . $this->search . '%')
                           ->orWhere('correo', 'like', '%' . $this->search . '%')
                           ->orWhere('cedula', 'like', '%' . $this->search . '%')
                           ->latest()
                           ->paginate(10);
                           
        return view('livewire.student-manager', [
            'students' => $students,
        ])->layout('layouts.app');
    }

    // Abrir el modal de creación
    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    // Abrir el modal
    public function openModal()
    {
        $this->isOpen = true;
    }

    // Cerrar el modal
    public function closeModal()
    {
        $this->isOpen = false;
    }

    // Limpiar los campos del formulario
    private function resetInputFields()
    {
        $this->student_id = null;
        $this->nombres = '';
        $this->correo = '';
        $this->cedula = '';
        $this->edad = '';
        $this->telefono = '';
        $this->direccion = '';
        $this->status = 'activo';
        // Resetear los errores de validación al abrir/resetear el formulario
        $this->resetValidation();
    }

    // Guardar o actualizar un estudiante
    public function store()
    {
        // Usar el método rules() para validar el formulario completo
        $validatedData = $this->validate();

        Student::updateOrCreate(['id' => $this->student_id], $validatedData);

        session()->flash('message', 
            $this->student_id ? 'Estudiante actualizado exitosamente.' : 'Estudiante creado exitosamente.');

        $this->closeModal();
        $this->resetInputFields();
    }

    // Cargar datos del estudiante para editar
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $this->student_id = $id;
        $this->nombres = $student->nombres;
        $this->correo = $student->correo;
        $this->cedula = $student->cedula;
        $this->edad = $student->edad;
        $this->telefono = $student->telefono;
        $this->direccion = $student->direccion;
        $this->status = $student->status;
        
        // Resetear los errores de validación al abrir el modal para editar
        $this->resetValidation();
        $this->openModal();
    }

    // Eliminar estudiante
    public function delete($id)
    {
        Student::find($id)->delete();
        session()->flash('message', 'Estudiante eliminado exitosamente.');
    }
}