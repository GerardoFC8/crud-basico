<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Lista de Estudiantes (Livewire)</h1>
        <button wire:click="create()" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded-md shadow-sm">
            Crear Estudiante
        </button>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif
    
    @if($isOpen)
        @include('livewire.student-modal')
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-4">
             <input wire:model.live="search" type="text" class="w-full rounded-md border-gray-300 shadow-sm" placeholder="Buscar por nombre, correo o cédula...">
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombres</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Correo</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cédula</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Acciones</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($students as $student)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $student->nombres }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $student->correo }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $student->cedula }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($student->status == 'activo') bg-green-100 text-green-800 @elseif($student->status == 'inactivo') bg-red-100 text-red-800 @else bg-blue-100 text-blue-800 @endif">
                                    {{ ucfirst($student->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="edit({{ $student->id }})" class="text-purple-600 hover:text-purple-900">Editar</button>
                                <button wire:click="delete({{ $student->id }})" class="text-red-600 hover:text-red-900 ml-4" onclick="return confirm('¿Estás seguro de que quieres eliminar a este estudiante?');">Eliminar</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">No hay estudiantes que coincidan con la búsqueda.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">
        {{ $students->links() }}
    </div>
</div>
