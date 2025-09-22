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
            <a href="{{ route('students.edit', $student->id) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
            <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="inline-block ml-4" onsubmit="return confirm('¿Estás seguro de que quieres eliminar a este estudiante?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
            </form>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">No hay estudiantes que coincidan con la búsqueda.</td>
    </tr>
@endforelse

