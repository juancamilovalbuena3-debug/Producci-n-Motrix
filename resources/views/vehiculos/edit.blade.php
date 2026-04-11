<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            {{ __('Editar Vehículo 🚘') }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-md mt-6">
        <!-- Mostrar errores de validación -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('vehiculos.update', $vehiculo->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Tipo -->
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="tipo">Tipo</label>
                <select name="tipo" id="tipo" class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200" required>
                    <option value="Carro" {{ old('tipo', $vehiculo->tipo) == 'Carro' ? 'selected' : '' }}>Carro</option>
                    <option value="Moto" {{ old('tipo', $vehiculo->tipo) == 'Moto' ? 'selected' : '' }}>Moto</option>
                </select>
            </div>

            <!-- Marca -->
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="marca">Marca</label>
                <input type="text" name="marca" id="marca" value="{{ old('marca', $vehiculo->marca) }}"
                       class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200" required>
            </div>

            <!-- Modelo -->
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="modelo">Modelo</label>
                <input type="text" name="modelo" id="modelo" value="{{ old('modelo', $vehiculo->modelo) }}"
                       class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200" required>
            </div>

            <!-- Precio -->
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="precio">Precio</label>
                <input type="number" name="precio" id="precio" value="{{ old('precio', $vehiculo->precio) }}"
                       class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200" required>
            </div>

            <!-- Descripción -->
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="descripcion">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="4"
                          class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200">{{ old('descripcion', $vehiculo->descripcion) }}</textarea>
            </div>

            <!-- Imagen -->
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="imagen">Imagen </label>
                @if($vehiculo->imagen)
                    <img src="{{ asset('storage/vehiculos/'.$vehiculo->imagen) }}" alt="Imagen" class="w-32 h-auto rounded mb-2">
                @endif
                <input type="file" name="imagen" id="imagen" class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200">
            </div>

            <!-- Botones -->
            <div class="flex space-x-4">
                <button type="submit"
                        class="bg-white hover:bg-gray-200 text-black font-semibold px-4 py-2 rounded flex-1 border">
                    Actualizar
                </button>
                <a href="{{ route('dashboard') }}"
                   class="bg-white hover:bg-gray-200 text-black font-semibold px-4 py-2 rounded flex-1 border">
                   Cancelar
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
