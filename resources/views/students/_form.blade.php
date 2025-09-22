@csrf
<div class="space-y-4">
    <div>
        <label for="nombres" class="block text-sm font-medium text-gray-700">Nombres</label>
        <input type="text" name="nombres" id="nombres" value="{{ old('nombres', $student->nombres ?? '') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        @error('nombres') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>
    <div>
        <label for="correo" class="block text-sm font-medium text-gray-700">Correo</label>
        <input type="email" name="correo" id="correo" value="{{ old('correo', $student->correo ?? '') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        @error('correo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>
    <div>
        <label for="cedula" class="block text-sm font-medium text-gray-700">Cédula</label>
        <input type="text" name="cedula" id="cedula" value="{{ old('cedula', $student->cedula ?? '') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        @error('cedula') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>
    <div>
        <label for="edad" class="block text-sm font-medium text-gray-700">Edad</label>
        <input type="number" name="edad" id="edad" value="{{ old('edad', $student->edad ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        @error('edad') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>
    <div>
        <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
        <input type="text" name="telefono" id="telefono" value="{{ old('telefono', $student->telefono ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        @error('telefono') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>
    <div>
        <label for="direccion" class="block text-sm font-medium text-gray-700">Dirección</label>
        <textarea name="direccion" id="direccion" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('direccion', $student->direccion ?? '') }}</textarea>
        @error('direccion') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>
    <div>
        <label for="status" class="block text-sm font-medium text-gray-700">Estado</label>
        <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            <option value="activo" @selected(old('status', $student->status ?? '') == 'activo')>Activo</option>
            <option value="inactivo" @selected(old('status', $student->status ?? '') == 'inactivo')>Inactivo</option>
            <option value="graduado" @selected(old('status', $student->status ?? '') == 'graduado')>Graduado</option>
        </select>
        @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>
</div>
<div class="flex justify-end mt-6">
    <a href="{{ route('students.index') }}" class="bg-gray-200 text-gray-800 py-2 px-4 rounded-md shadow-sm hover:bg-gray-300">Cancelar</a>
    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        Guardar
    </button>
</div>
