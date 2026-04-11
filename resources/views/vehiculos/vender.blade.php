<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            {{ __('Publicar Vehículo en Venta 🚘') }}
        </h2>
    </x-slot>

    <!-- Fondo global con la imagen del carro -->
    <div class="py-12 bg-cover bg-center min-h-screen" style="background-image: url('{{ asset('images/logo.jpg') }}');">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Caja semi-transparente para que se vea el fondo -->
            <div class="bg-white/80 overflow-hidden shadow-xl sm:rounded-lg flex">

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

                    <form method="POST" action="{{ route('vender.store') }}" 
                          class="space-y-4" 
                          enctype="multipart/form-data">
                        @csrf

                        <!-- Tipo -->
                        <div>
                            <label for="tipo" class="block font-semibold mb-1">Tipo:</label>
                            <select name="tipo" id="tipo" class="border rounded p-2 w-full" required>
                                <option value="Carro" {{ old('tipo') == 'Carro' ? 'selected' : '' }}>Carro</option>
                                <option value="Moto" {{ old('tipo') == 'Moto' ? 'selected' : '' }}>Moto</option>
                            </select>
                        </div>

                        <!-- Marca -->
                        <div>
                            <label for="marca" class="block font-semibold mb-1">Marca:</label>
                            <input type="text" name="marca" id="marca" value="{{ old('marca') }}"
                                   class="border rounded p-2 w-full" required>
                        </div>

                        <!-- Modelo -->
                        <div>
                            <label for="modelo" class="block font-semibold mb-1">Modelo:</label>
                            <input type="text" name="modelo" id="modelo" value="{{ old('modelo') }}"
                                   class="border rounded p-2 w-full" required>
                        </div>

                        <!-- Precio -->
                        <div>
                            <label for="precio" class="block font-semibold mb-1">Precio:</label>
                            <input type="number" name="precio" id="precio" value="{{ old('precio') }}"
                                   class="border rounded p-2 w-full" required>
                        </div>

                        <!-- Descripción -->
                        <div>
                            <label for="descripcion" class="block font-semibold mb-1">Descripción:</label>
                            <textarea name="descripcion" id="descripcion" rows="4" 
                                      class="border rounded p-2 w-full">{{ old('descripcion') }}</textarea>
                        </div>

                        <!-- Imagen -->
                        <div>
                            <label for="imagen" class="block font-semibold mb-1">Imagen del vehículo (opcional):</label>
                            <input type="file" name="imagen" id="imagen" accept="image/*"
                                   class="border rounded p-2 w-full">
                        </div>

                        <!-- Botón publicar -->
                        <div class="text-center">
                            <button type="submit" 
                                    class="bg-white text-black border font-semibold px-6 py-3 rounded-lg text-lg shadow-md transition-all duration-300 transform hover:scale-105 hover:bg-gray-200">
                                 Publicar Vehículo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
