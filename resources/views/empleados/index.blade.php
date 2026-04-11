<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black-800 leading-tight">
            {{ __('Gestión de Empleados y Vehículos') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-white min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg flex">

                <!-- Sidebar -->
                <aside class="w-64 bg-gray-100/90 border-r p-6">
                    <h2 class="text-lg font-bold mb-4">Panel</h2>
                    <ul class="space-y-2">
                        <li><a href="{{ route('dashboard') }}" class="text-black font-semibold">Inicio</a></li>
                        <li><a href="{{ route('empleados.index') }}" class="text-black font-semibold">Empleados</a></li>
                        <li><a href="{{ route('carros') }}" class="text-black font-semibold">Carros</a></li>
                        <li><a href="{{ route('motos') }}" class="text-black font-semibold">Motos</a></li>
                        <li><a href="{{ route('vender') }}" class="text-black font-semibold">Vender Vehículo</a></li>
                        <li><a href="{{ route('configuracion') }}" class="text-black font-semibold">Configuración</a></li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-red-600 mt-2 font-semibold">Cerrar sesión</button>
                        </form>
                    </ul>
                </aside>

                <!-- Contenido principal -->
                <main class="flex-1 p-6">
                    <h1 class="text-2xl font-bold mb-6">Gestión de Empleados y Vehículos</h1>

                    {{-- ✅ Mensaje de error visual (cuando Python no está corriendo) --}}
                    @if(session('error'))
                        <div class="mb-6 flex items-center space-x-3 p-5 bg-yellow-50 border border-yellow-300 rounded-xl shadow text-yellow-800">
                            <span class="text-2xl">⚠️</span>
                            <div>
                                <p class="font-semibold text-base">{{ session('error') }}</p>
                                <p class="text-sm mt-1">Asegúrate de ejecutar: <code class="bg-yellow-100 px-2 py-0.5 rounded font-mono">python main.py</code></p>
                            </div>
                        </div>
                    @endif

                    {{-- ✅ Mensaje de éxito --}}
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-800 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Pestañas -->
                    {{-- ✅ FIX: solo cambia a 'vehiculos' si el parámetro tab=vehiculos está en la URL --}}
                    <div x-data="{ tab: '{{ request('tab') === 'vehiculos' ? 'vehiculos' : 'empleados' }}' }">
                        <div class="flex space-x-4 border-b mb-6">
                            <button
                                @click="tab = 'empleados'"
                                :class="tab === 'empleados' ? 'border-b-2 border-black text-black font-semibold' : 'text-gray-600 hover:text-black'"
                                class="pb-2 transition">
                                Empleados
                            </button>
                            <button
                                @click="tab = 'vehiculos'"
                                :class="tab === 'vehiculos' ? 'border-b-2 border-black text-black font-semibold' : 'text-gray-600 hover:text-black'"
                                class="pb-2 transition">
                                Vehículos
                            </button>
                        </div>

                        <!-- Tabla de empleados -->
                        <div x-show="tab === 'empleados'">
                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-xl font-semibold">Lista de Empleados</h2>
                                <div class="space-x-2">
                                    <a href="{{ route('empleados.export.pdf', ['busqueda' => request('tab') === 'empleados' ? request('busqueda') : '']) }}"
                                       class="bg-white hover:bg-gray-200 text-black px-3 py-2 rounded shadow text-sm font-semibold border transition">
                                        Exportar PDF
                                    </a>
                                    <a href="{{ route('empleados.export.csv', ['busqueda' => request('tab') === 'empleados' ? request('busqueda') : '']) }}"
                                       class="bg-white hover:bg-gray-200 text-black px-3 py-2 rounded shadow text-sm font-semibold border transition">
                                        Exportar CSV
                                    </a>
                                </div>
                            </div>

                            <!-- 🔍 Buscador empleados -->
                            <div class="flex justify-between items-center mb-6">
                                <form method="GET" action="{{ route('empleados.index') }}" class="flex space-x-2">
                                    {{-- ✅ FIX: identifica que la búsqueda es de empleados --}}
                                    <input type="hidden" name="tab" value="empleados">
                                    <input type="text" name="busqueda" value="{{ request('tab') !== 'vehiculos' ? request('busqueda') : '' }}"
                                           placeholder="Buscar por nombre o correo"
                                           class="border rounded px-3 py-2 w-64 focus:ring-black focus:border-black">
                                    <button type="submit"
                                            class="bg-white hover:bg-gray-200 text-black px-4 py-2 rounded shadow font-semibold border transition">
                                        Buscar
                                    </button>
                                    <a href="{{ route('empleados.index') }}"
                                       class="bg-white hover:bg-gray-200 text-black px-4 py-2 rounded shadow font-semibold border transition">
                                        Limpiar
                                    </a>
                                </form>

                                <a href="{{ route('empleados.create') }}"
                                   class="bg-white hover:bg-gray-200 text-black px-4 py-2 rounded shadow font-semibold border transition">
                                    + Agregar Empleado
                                </a>
                            </div>

                            @if($empleados->count() > 0)
                                <table class="table-auto w-full border bg-white shadow rounded text-gray-800">
                                    <thead class="bg-gray-300">
                                        <tr>
                                            <th class="px-4 py-2 border">Nombre</th>
                                            <th class="px-4 py-2 border">Cargo</th>
                                            <th class="px-4 py-2 border">Salario</th>
                                            <th class="px-4 py-2 border">Correo</th>
                                            <th class="px-4 py-2 border">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($empleados as $empleado)
                                            <tr>
                                                <td class="border px-4 py-2">{{ $empleado->nombre }}</td>
                                                <td class="border px-4 py-2">{{ $empleado->puesto }}</td>
                                                <td class="border px-4 py-2">${{ number_format($empleado->salario, 2) }}</td>
                                                <td class="border px-4 py-2">{{ $empleado->email }}</td>
                                                <td class="border px-4 py-2 flex space-x-2">
                                                    <a href="{{ route('empleados.edit', $empleado->id) }}"
                                                       class="bg-white hover:bg-gray-200 text-black px-3 py-1 rounded shadow font-semibold border transition">
                                                        Editar
                                                    </a>
                                                    <form action="{{ route('empleados.destroy', $empleado->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" onclick="return confirm('¿Eliminar este empleado?')"
                                                                class="bg-white hover:bg-gray-200 text-black px-3 py-1 rounded shadow font-semibold border transition">
                                                            Eliminar
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="mt-4">{{ $empleados->links() }}</div>
                            @else
                                @if(request('busqueda') && request('tab') !== 'vehiculos')
                                    <div class="text-center py-12 text-gray-500">
                                        <p class="text-xl"> No se encontraron empleados con "<strong>{{ request('busqueda') }}</strong>".</p>
                                        <p class="text-sm mt-2">Intenta con otro nombre o correo.</p>
                                        <a href="{{ route('empleados.index') }}" class="inline-block mt-4 text-blue-600 underline text-sm">Limpiar búsqueda</a>
                                    </div>
                                @else
                                    <div class="text-center py-12 text-gray-500">
                                        <p class="text-xl"> No hay empleados registrados aún.</p>
                                        <p class="text-sm mt-2">Haz clic en <strong>+ Agregar Empleado</strong> para comenzar.</p>
                                    </div>
                                @endif
                            @endif
                        </div>

                        <!-- Tabla de vehículos -->
                        <div x-show="tab === 'vehiculos'">
                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-xl font-semibold">Vehículos Publicados</h2>
                                <div class="space-x-2">
                                    <a href="{{ route('vehiculos.export.pdf', ['busqueda' => request('busqueda'), 'tipo' => request('tipo')]) }}"
                                       class="bg-white hover:bg-gray-200 text-black px-3 py-2 rounded shadow text-sm font-semibold border transition">
                                        Exportar PDF
                                    </a>
                                    <a href="{{ route('vehiculos.export.csv', ['busqueda' => request('busqueda'), 'tipo' => request('tipo')]) }}"
                                       class="bg-white hover:bg-gray-200 text-black px-3 py-2 rounded shadow text-sm font-semibold border transition">
                                        Exportar CSV
                                    </a>
                                </div>
                            </div>

                            <!-- 🔍 Buscador vehículos -->
                            <div class="flex justify-between items-center mb-6">
                                <form method="GET" action="{{ route('empleados.index') }}" class="flex space-x-2">
                                    <input type="hidden" name="tab" value="vehiculos">
                                    <input type="text" name="busqueda" value="{{ request('tab') === 'vehiculos' ? request('busqueda') : '' }}"
                                           placeholder="Buscar por marca o modelo"
                                           class="border rounded px-3 py-2 w-64 focus:ring-black focus:border-black">
                                    <select name="tipo" class="border rounded px-3 py-2 focus:ring-black focus:border-black">
                                        <option value="">Todos los tipos</option>
                                        <option value="carro" {{ request('tipo') == 'carro' ? 'selected' : '' }}>Carros</option>
                                        <option value="moto" {{ request('tipo') == 'moto' ? 'selected' : '' }}>Motos</option>
                                    </select>
                                    <button type="submit"
                                            class="bg-white hover:bg-gray-200 text-black px-4 py-2 rounded shadow font-semibold border transition">
                                        Buscar
                                    </button>
                                    <a href="{{ route('empleados.index', ['tab' => 'vehiculos']) }}"
                                       class="bg-white hover:bg-gray-200 text-black px-4 py-2 rounded shadow font-semibold border transition">
                                        Limpiar
                                    </a>
                                </form>

                                <a href="{{ route('vehiculos.create') }}"
                                   class="bg-white hover:bg-gray-200 text-black px-4 py-2 rounded shadow font-semibold border transition">
                                    + Agregar Vehículo
                                </a>
                            </div>

                            @if($vehiculos->count() > 0)
                                <table class="table-auto w-full border bg-white shadow rounded text-gray-800">
                                    <thead class="bg-gray-300">
                                        <tr>
                                            <th class="px-4 py-2 border">ID</th>
                                            <th class="px-4 py-2 border">Imagen</th>
                                            <th class="px-4 py-2 border">Tipo</th>
                                            <th class="px-4 py-2 border">Marca</th>
                                            <th class="px-4 py-2 border">Modelo</th>
                                            <th class="px-4 py-2 border">Precio</th>
                                            <th class="px-4 py-2 border">Descripción</th>
                                            <th class="px-4 py-2 border">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($vehiculos as $vehiculo)
                                            <tr>
                                                <td class="border px-4 py-2">{{ $vehiculo->id }}</td>
                                                <td class="border px-4 py-2">
                                                    @if($vehiculo->imagen)
                                                        <img src="{{ asset('images/'.$vehiculo->imagen) }}" alt="Imagen" class="w-20 h-auto rounded">
                                                    @else
                                                        <span class="text-gray-500">Sin imagen</span>
                                                    @endif
                                                </td>
                                                <td class="border px-4 py-2">{{ $vehiculo->tipo }}</td>
                                                <td class="border px-4 py-2">{{ $vehiculo->marca }}</td>
                                                <td class="border px-4 py-2">{{ $vehiculo->modelo }}</td>
                                                <td class="border px-4 py-2">${{ number_format($vehiculo->precio, 2) }}</td>
                                                <td class="border px-4 py-2">{{ $vehiculo->descripcion }}</td>
                                                <td class="border px-4 py-2 flex space-x-2">
                                                    <a href="{{ route('vehiculos.edit', $vehiculo->id) }}"
                                                       class="bg-white hover:bg-gray-200 text-black px-3 py-1 rounded shadow font-semibold border transition">
                                                        Editar
                                                    </a>
                                                    <form action="{{ route('vehiculos.destroy', $vehiculo->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" onclick="return confirm('¿Eliminar este vehículo?')"
                                                                class="bg-white hover:bg-gray-200 text-black px-3 py-1 rounded shadow font-semibold border transition">
                                                            Eliminar
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="mt-4">{{ $vehiculos->links() }}</div>
                            @else
                                @if(request('busqueda') || request('tipo'))
                                    <div class="text-center py-12 text-gray-500">
                                        <p class="text-xl">🔍 No se encontraron vehículos
                                            @if(request('busqueda')) con "<strong>{{ request('busqueda') }}</strong>"@endif
                                            @if(request('tipo')) de tipo "<strong>{{ request('tipo') }}</strong>"@endif.
                                        </p>
                                        <p class="text-sm mt-2">Intenta con otra marca, modelo o tipo.</p>
                                        <a href="{{ route('empleados.index', ['tab' => 'vehiculos']) }}" class="inline-block mt-4 text-blue-600 underline text-sm">Limpiar búsqueda</a>
                                    </div>
                                @else
                                    <div class="text-center py-12 text-gray-500">
                                        <p class="text-xl">🚗 No hay vehículos publicados aún.</p>
                                        <p class="text-sm mt-2">Haz clic en <strong>+ Agregar Vehículo</strong> para comenzar.</p>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <!-- Alpine.js -->
    <script src="//unpkg.com/alpinejs" defer></script>
</x-app-layout>