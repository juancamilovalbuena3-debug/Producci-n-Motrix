<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            {{ __('Publicar Vehículo en Venta ') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-cover bg-center min-h-screen" style="background-image: url('{{ asset('images/logo.jpg') }}');">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/80 overflow-hidden shadow-xl sm:rounded-lg flex">
                <div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-md mt-6">

                    @if (session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->has('general'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <strong>Error:</strong> {{ $errors->first('general') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('vender.store') }}"
                          id="form-vehiculo"
                          class="space-y-4"
                          enctype="multipart/form-data">
                        @csrf

                        <!-- Tipo -->
                        <div>
                            <label for="tipo" class="block font-semibold mb-1">Tipo:</label>
                            <select name="tipo" id="tipo" class="border rounded p-2 w-full">
                                <option value="Carro" {{ old('tipo') == 'Carro' ? 'selected' : '' }}>Carro</option>
                                <option value="Moto"  {{ old('tipo') == 'Moto'  ? 'selected' : '' }}>Moto</option>
                            </select>
                        </div>

                        <!-- Transmisión -->
                        <div>
                            <label for="transmision" class="block font-semibold mb-1">Transmisión:</label>
                            <select name="transmision" id="transmision" class="border rounded p-2 w-full">
                                <option value="Automatico" {{ old('transmision') == 'Automatico' ? 'selected' : '' }}>Automático</option>
                                <option value="Manual"     {{ old('transmision') == 'Manual'     ? 'selected' : '' }}>Manual</option>
                            </select>
                        </div>

                        <!-- Marca -->
                        <div>
                            <label for="marca" class="block font-semibold mb-1">Marca:</label>
                            <input type="text" name="marca" id="marca" value="{{ old('marca') }}"
                                   class="border rounded p-2 w-full border-gray-300">
                            <p class="text-red-600 text-sm mt-1" id="error-marca"></p>
                        </div>

                        <!-- Modelo -->
                        <div>
                            <label for="modelo" class="block font-semibold mb-1">Modelo:</label>
                            <input type="text" name="modelo" id="modelo" value="{{ old('modelo') }}"
                                   class="border rounded p-2 w-full border-gray-300">
                            <p class="text-red-600 text-sm mt-1" id="error-modelo"></p>
                        </div>

                        <!-- Precio -->
                        <div>
                            <label for="precio" class="block font-semibold mb-1">Precio:</label>
                            <input type="number" name="precio" id="precio" value="{{ old('precio') }}"
                                   class="border rounded p-2 w-full border-gray-300">
                            <p class="text-red-600 text-sm mt-1" id="error-precio"></p>
                        </div>

                        <!-- Descripción -->
                        <div>
                            <label for="descripcion" class="block font-semibold mb-1">Descripción:</label>
                            <textarea name="descripcion" id="descripcion" rows="4"
                                      class="border rounded p-2 w-full">{{ old('descripcion') }}</textarea>
                            <p class="text-red-600 text-sm mt-1" id="error-descripcion"></p>
                        </div>

                        <!-- Imagen -->
                        <div>
                            <label for="imagen" class="block font-semibold mb-1">Imagen del vehículo (opcional):</label>
                            <input type="file" name="imagen" id="imagen" accept="image/*"
                                   class="border rounded p-2 w-full">
                        </div>

                        <!-- Botón publicar -->
                        <div class="text-center">
                            <button type="button" onclick="validarYEnviar()"
                                    class="bg-blue-600 text-white font-semibold px-6 py-3 rounded-lg text-lg shadow-md transition-all duration-300 transform hover:scale-105 hover:bg-blue-700">
                                Publicar Vehículo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
            const m  = validarMarca();
            const mo = validarModelo();
            const p  = validarPrecio();
            const d  = validarDescripcion();
            if (m && mo && p && d) {
                document.getElementById('form-vehiculo').submit();
            }
        }

        document.getElementById('marca').addEventListener('input', validarMarca);
        document.getElementById('modelo').addEventListener('input', validarModelo);
        document.getElementById('precio').addEventListener('input', validarPrecio);
        document.getElementById('descripcion').addEventListener('input', validarDescripcion);

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