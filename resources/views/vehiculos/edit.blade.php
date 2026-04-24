<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            {{ __('Editar Vehículo') }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-md mt-6">

        {{-- Errores generales --}}
        @if ($errors->has('general'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <strong>Error:</strong> {{ $errors->first('general') }}
            </div>
        @endif

        <form action="{{ route('vehiculos.update', $vehiculo->id) }}" method="POST" enctype="multipart/form-data" id="form-vehiculo">
            @csrf
            @method('PUT')

            <!-- Tipo -->
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="tipo">Tipo</label>
                <select name="tipo" id="tipo" class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200">
                    <option value="Carro" {{ old('tipo', $vehiculo->tipo) == 'Carro' ? 'selected' : '' }}>Carro</option>
                    <option value="Moto" {{ old('tipo', $vehiculo->tipo) == 'Moto' ? 'selected' : '' }}>Moto</option>
                </select>
            </div>

            <!-- Marca -->
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="marca">Marca</label>
                <input type="text" name="marca" id="marca" value="{{ old('marca', $vehiculo->marca) }}"
                       class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200 border-gray-300">
                <p class="text-red-600 text-sm mt-1" id="error-marca"></p>
            </div>

            <!-- Modelo -->
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="modelo">Modelo</label>
                <input type="text" name="modelo" id="modelo" value="{{ old('modelo', $vehiculo->modelo) }}"
                       class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200 border-gray-300">
                <p class="text-red-600 text-sm mt-1" id="error-modelo"></p>
            </div>

            <!-- Precio -->
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="precio">Precio</label>
                <input type="number" name="precio" id="precio" value="{{ old('precio', $vehiculo->precio) }}"
                       class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200 border-gray-300">
                <p class="text-red-600 text-sm mt-1" id="error-precio"></p>
            </div>

            <!-- Descripción -->
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="descripcion">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="4"
                          class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200">{{ old('descripcion', $vehiculo->descripcion) }}</textarea>
                <p class="text-red-600 text-sm mt-1" id="error-descripcion"></p>
            </div>

            <!-- Imagen -->
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="imagen">Imagen</label>
                @if($vehiculo->imagen)
                    <img src="{{ asset('storage/vehiculos/'.$vehiculo->imagen) }}" alt="Imagen" class="w-32 h-auto rounded mb-2">
                @endif
                <input type="file" name="imagen" id="imagen" class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200">
            </div>

            <!-- Botones -->
            <div class="flex space-x-4">
                <button type="button" onclick="validarYEnviar()"
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

    <script>
        function setError(inputId, errorId, mensaje) {
            const input = document.getElementById(inputId);
            const error = document.getElementById(errorId);
            if (mensaje) {
                input.classList.add('border-red-500', 'bg-red-50');
                input.classList.remove('border-gray-300');
                error.textContent = mensaje;
            } else {
                input.classList.remove('border-red-500', 'bg-red-50');
                input.classList.add('border-gray-300');
                error.textContent = '';
            }
        }

        function validarMarca() {
            const valor = document.getElementById('marca').value.trim();
            if (!valor) { setError('marca', 'error-marca', 'La marca es obligatoria.'); return false; }
            if (valor.length < 2) { setError('marca', 'error-marca', 'La marca debe tener al menos 2 caracteres.'); return false; }
            if (valor.length > 80) { setError('marca', 'error-marca', 'La marca no puede superar los 80 caracteres.'); return false; }
            setError('marca', 'error-marca', ''); return true;
        }

        function validarModelo() {
            const valor = document.getElementById('modelo').value.trim();
            if (!valor) { setError('modelo', 'error-modelo', 'El modelo es obligatorio.'); return false; }
            if (valor.length < 2) { setError('modelo', 'error-modelo', 'El modelo debe tener al menos 2 caracteres.'); return false; }
            if (valor.length > 80) { setError('modelo', 'error-modelo', 'El modelo no puede superar los 80 caracteres.'); return false; }
            setError('modelo', 'error-modelo', ''); return true;
        }

        function validarPrecio() {
            const str = document.getElementById('precio').value.trim();
            const valor = parseFloat(str);
            if (!str) { setError('precio', 'error-precio', 'El precio es obligatorio.'); return false; }
            if (isNaN(valor) || valor <= 0) { setError('precio', 'error-precio', 'El precio debe ser mayor a cero.'); return false; }
            if (valor < 1000000) { setError('precio', 'error-precio', 'El precio mínimo permitido es de $1,000,000.'); return false; }
            if (valor > 9999999999) { setError('precio', 'error-precio', 'El precio ingresado es demasiado alto.'); return false; }
            setError('precio', 'error-precio', ''); return true;
        }

        function validarDescripcion() {
            const valor = document.getElementById('descripcion').value.trim();
            if (valor.length > 500) { setError('descripcion', 'error-descripcion', 'La descripción no puede superar los 500 caracteres.'); return false; }
            setError('descripcion', 'error-descripcion', ''); return true;
        }

        function validarYEnviar() {
            const m = validarMarca();
            const mo = validarModelo();
            const p = validarPrecio();
            const d = validarDescripcion();
            if (m && mo && p && d) {
                document.getElementById('form-vehiculo').submit();
            }
        }

        document.getElementById('marca').addEventListener('input', validarMarca);
        document.getElementById('modelo').addEventListener('input', validarModelo);
        document.getElementById('precio').addEventListener('input', validarPrecio);
        document.getElementById('descripcion').addEventListener('input', validarDescripcion);

        // Mostrar errores del servidor al volver con back()
        @if ($errors->has('marca'))
            setError('marca', 'error-marca', '{{ $errors->first('marca') }}');
        @endif
        @if ($errors->has('modelo'))
            setError('modelo', 'error-modelo', '{{ $errors->first('modelo') }}');
        @endif
        @if ($errors->has('precio'))
            setError('precio', 'error-precio', '{{ $errors->first('precio') }}');
        @endif
    </script>
</x-app-layout>