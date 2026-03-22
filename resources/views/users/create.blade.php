<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nuevo Usuario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Datos Personales</h3>
                            
                            <div class="mb-4">
                                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nombre:</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
        
                            <div class="mb-4">
                                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
        
                            <div class="mb-4">
                                <label for="puesto" class="block text-gray-700 text-sm font-bold mb-2">Puesto:</label>
                                <input type="text" name="puesto" id="puesto" value="{{ old('puesto') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                @error('puesto') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Seguridad y Acceso</h3>

                            <div class="mb-4">
                                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Contraseña:</label>
                                <input type="password" name="password" id="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
        
                            <div class="mb-4">
                                <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Confirmar Contraseña:</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            </div>

                            <div class="mb-4 bg-yellow-50 p-3 rounded-lg border border-yellow-200">
                                <label for="role" class="block text-gray-700 text-sm font-bold mb-2">Tipo de Usuario (Rol):</label>
                                <select name="role" id="role" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline cursor-pointer" required onchange="togglePermissions()">
                                    <option value="">-- Seleccione un rol --</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('role') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div id="permissions-container" class="mt-6 border-t pt-6 hidden">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Configuración de Permisos</h3>
                        <p class="text-sm text-gray-600 mb-4">Seleccione las acciones específicas que este empleado puede realizar en el sistema.</p>
                        
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                @foreach($permissions as $permission)
                                    <label class="inline-flex items-center space-x-2 cursor-pointer hover:bg-gray-100 p-2 rounded transition-colors">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" 
                                               class="form-checkbox h-5 w-5 text-rose-600 rounded border-gray-300 focus:ring-rose-500 transition duration-150 ease-in-out">
                                        <span class="text-gray-700 text-sm capitalize">{{ str_replace('_', ' ', $permission->name) }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-8">
                        <a href="{{ route('users.index') }}" class="text-gray-500 hover:text-gray-700 mr-4 font-medium">Cancelar</a>
                        <button type="submit" class="bg-rose-600 hover:bg-rose-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
                            Guardar Usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Script simple para mostrar/ocultar permisos --}}
    <script>
        function togglePermissions() {
            const roleSelect = document.getElementById('role');
            const permissionsContainer = document.getElementById('permissions-container');
            const selectedText = roleSelect.options[roleSelect.selectedIndex].text;

            // Si el rol es 'Empleado', mostramos los permisos. 
            // Si es Admin, los ocultamos (asumimos que Admin tiene todo).
            if (selectedText === 'Empleado') {
                permissionsContainer.classList.remove('hidden');
            } else {
                permissionsContainer.classList.add('hidden');
                
                // Opcional: Desmarcar casillas si se cambia a Admin para limpiar el form
                const checkboxes = permissionsContainer.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach(cb => cb.checked = false);
            }
        }
    </script>
</x-app-layout>