<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Agregar Empleado') }}
        </h2>
    </x-slot>

    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Éxito --}}
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Empleado agregado correctamente',
                    showConfirmButton: false,
                    timer: 2000
                });
            });
        </script>
    @endif

    {{-- Error general --}}
    @if ($errors->has('general'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ $errors->first('general') }}'
                });
            });
        </script>
    @endif

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-md rounded">
                <h2 class="text-lg font-semibold mb-4">Nuevo Empleado</h2>

                <form id="formEmpleado" action="{{ route('empleados.store') }}" method="POST">
                    @csrf

                    {{-- Nombre --}}
                    <div class="mb-4">
                        <label class="block font-medium mb-1">Nombre:</label>
                        <input type="text" name="nombre" value="{{ old('nombre') }}"
                            class="w-full border px-3 py-2 rounded {{ $errors->has('nombre') ? 'border-red-500 bg-red-50' : 'border-gray-300' }}">
                        @error('nombre')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Puesto --}}
                    <div class="mb-4">
                        <label class="block font-medium mb-1">Puesto:</label>
                        <input type="text" name="puesto" value="{{ old('puesto') }}"
                            class="w-full border px-3 py-2 rounded {{ $errors->has('puesto') ? 'border-red-500 bg-red-50' : 'border-gray-300' }}">
                        @error('puesto')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Salario --}}
                    <div class="mb-4">
                        <label class="block font-medium mb-1">Salario:</label>
                        <input type="number" step="0.01" name="salario" value="{{ old('salario') }}"
                            class="w-full border px-3 py-2 rounded {{ $errors->has('salario') ? 'border-red-500 bg-red-50' : 'border-gray-300' }}">
                        @error('salario')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="mb-4">
                        <label class="block font-medium mb-1">Email:</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full border px-3 py-2 rounded {{ $errors->has('email') ? 'border-red-500 bg-red-50' : 'border-gray-300' }}">
                        @error('email')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex space-x-4">
                        <button type="button" onclick="confirmarEnvio()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Guardar
                        </button>

                        <a href="{{ route('empleados.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function confirmarEnvio() {
            Swal.fire({
                title: '¿Guardar empleado?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, guardar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {

                    Swal.fire({
                        title: 'Guardando...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    document.getElementById('formEmpleado').submit();
                }
            });
        }
    </script>
</x-app-layout>