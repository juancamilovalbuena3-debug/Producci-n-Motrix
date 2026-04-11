<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Empleado') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            {{-- ✅ Mensaje de éxito --}}
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-200 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- ❌ Mensajes de validación --}}
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-200 text-red-800 rounded">
                    <ul class="list-disc ps-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- ✏️ Formulario de edición --}}
            <div class="bg-white p-6 shadow rounded">
                <form action="{{ route('empleados.update', $empleado->id) }}" method="POST" class="flex flex-col gap-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block font-semibold">Nombre</label>
                        <input type="text" name="nombre" value="{{ old('nombre', $empleado->nombre) }}" 
                               class="border p-2 rounded w-full" required>
                    </div>

                    <div>
                        <label class="block font-semibold">Puesto</label>
                        <input type="text" name="puesto" value="{{ old('puesto', $empleado->puesto) }}" 
                               class="border p-2 rounded w-full" required>
                    </div>

                    <div>
                        <label class="block font-semibold">Salario</label>
                        <input type="number" step="0.01" name="salario" value="{{ old('salario', $empleado->salario) }}" 
                               class="border p-2 rounded w-full" required>
                    </div>

                    <div>
                        <label class="block font-semibold">Email</label>
                        <input type="email" name="email" value="{{ old('email', $empleado->email) }}" 
                               class="border p-2 rounded w-full" required>
                    </div>

                    {{-- ✅ Botones de acción --}}
                    <div class="flex justify-end gap-3 mt-4">
                        <a href="{{ route('empleados.index') }}" class="bg-white hover:bg-gray-200 text-black font-semibold px-4 py-2 rounded flex-1 border">
                            Cancelar
                        </a>
                        <button type="submit" class="bg-white hover:bg-gray-200 text-black font-semibold px-4 py-2 rounded flex-1 border">
                            Guardar cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>