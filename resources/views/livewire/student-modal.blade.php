<div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form>
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                {{ $student_id ? 'Editar Estudiante' : 'Crear Nuevo Estudiante' }}
                            </h3>
                            <div class="mt-4 space-y-4">
                                <!-- Nombres -->
                                <div>
                                    <label for="nombres" class="block text-sm font-medium text-gray-700">Nombres</label>
                                    <input type="text" wire:model.live.debounce.500ms="nombres" id="nombres" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    @error('nombres') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                <!-- Correo -->
                                <div>
                                    <label for="correo" class="block text-sm font-medium text-gray-700">Correo</label>
                                    <input type="email" wire:model.live.debounce.500ms="correo" id="correo" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    @error('correo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                <!-- Cédula -->
                                <div>
                                    <label for="cedula" class="block text-sm font-medium text-gray-700">Cédula</label>
                                    <input type="text" wire:model.live.debounce.500ms="cedula" id="cedula" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    @error('cedula') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                <!-- Edad, Telefono, Direccion (Opcionales) -->
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="edad" class="block text-sm font-medium text-gray-700">Edad</label>
                                        <input type="number" wire:model="edad" id="edad" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        @error('edad') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                                        <input type="text" wire:model="telefono" id="telefono" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        @error('telefono') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div>
                                     <label for="direccion" class="block text-sm font-medium text-gray-700">Dirección</label>
                                     <textarea wire:model="direccion" id="direccion" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                                     @error('direccion') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                <!-- Status -->
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700">Estado</label>
                                    <select wire:model="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        <option value="activo">Activo</option>
                                        <option value="inactivo">Inactivo</option>
                                        <option value="graduado">Graduado</option>
                                    </select>
                                    @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click.prevent="store()" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-purple-600 text-base font-medium text-white hover:bg-purple-700 sm:ml-3 sm:w-auto sm:text-sm">
                        Guardar
                    </button>
                    <button wire:click="closeModal()" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>