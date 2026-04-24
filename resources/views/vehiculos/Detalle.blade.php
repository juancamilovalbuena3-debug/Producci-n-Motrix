<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('carros') }}" class="text-gray-500 hover:text-gray-700">← Volver</a>
            <h2 class="font-semibold text-xl text-gray-800">Detalle del Vehículo</h2>
        </div>
    </x-slot>

    <div class="p-8 max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="md:flex">

                <!-- Imagen -->
                <div class="md:w-1/2">
                    <img src="{{ asset($producto['imagen']) }}"
                         alt="{{ $producto['nombre'] }}"
                         class="w-full h-72 object-cover">
                </div>

                <!-- Info -->
                <div class="md:w-1/2 p-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">
                        {{ $producto['nombre'] }}
                    </h1>

                    <p class="text-4xl font-bold text-blue-600 mb-4">
                        ${{ number_format($producto['precio']) }}
                    </p>

                    @if(isset($producto['descripcion']))
                        <p class="text-gray-600 text-sm mb-4">
                            {{ $producto['descripcion'] }}
                        </p>
                    @endif

                    <!-- Características -->
                    <div class="space-y-3 mb-6">

                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-500">Transmisión</span>
                            <span class="font-medium">{{ $producto['transmision'] }}</span>
                        </div>

                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-500">Combustible</span>
                            <span class="font-medium">{{ $producto['combustible'] }}</span>
                        </div>

                        @if(isset($producto['anio']))
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-500">Año</span>
                            <span class="font-medium">{{ $producto['anio'] }}</span>
                        </div>
                        @endif

                        @if(isset($producto['kilometraje']))
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-500">Kilometraje</span>
                            <span class="font-medium">
                                {{ number_format($producto['kilometraje']) }} km
                            </span>
                        </div>
                        @endif

                        @if(isset($producto['garantia']))
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-500">Garantía</span>
                            <span class="font-medium">{{ $producto['garantia'] }}</span>
                        </div>
                        @endif

                        @if(isset($producto['seguridad']))
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-500">Seguridad</span>
                            <span class="font-medium text-sm">
                                {{ $producto['seguridad'] }}
                            </span>
                        </div>
                        @endif

                        <!-- 🎨 COLORES (SIEMPRE VISIBLES) -->
                        <div class="border-b pb-3">
                            <span class="text-gray-500 block mb-2">
                                Colores disponibles
                            </span>

                            @php
                                $colores = ['Blanco', 'Negro', 'Gris', 'Rojo', 'Azul', 'Plata', 'Verde'];

                                $coloresHex = [
                                    'Blanco' => '#f5f5f5',
                                    'Negro'  => '#1a1a1a',
                                    'Gris'   => '#9ca3af',
                                    'Rojo'   => '#ef4444',
                                    'Azul'   => '#3b82f6',
                                    'Plata'  => '#e5e7eb',
                                    'Verde'  => '#22c55e',
                                ];
                            @endphp

                            <div class="flex gap-3 flex-wrap">
                                @foreach($colores as $color)
                                    <div class="flex flex-col items-center gap-1">
                                        <span
                                            class="w-7 h-7 rounded-full border-2 shadow-sm hover:scale-110 transition"
                                            style="background-color: {{ $coloresHex[$color] }};"
                                        ></span>
                                        <span class="text-xs text-gray-500">
                                            {{ $color }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- ID -->
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-500">ID</span>
                            <span class="font-medium">#{{ $producto['id'] }}</span>
                        </div>

                    </div>

                    <!-- Botón comprar -->
                    <a href="{{ route('carros.comprar', $producto['id']) }}"
                       class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white
                              font-semibold py-3 px-6 rounded-lg transition mb-3">
                        🛒 Comprar ahora
                    </a>

                    <a href="{{ route('carros') }}"
                       class="block text-center text-gray-500 hover:text-gray-700 text-sm">
                        ← Seguir viendo carros
                    </a>

                </div>
            </div>
        </div>

        <p class="text-center text-xs text-gray-400 mt-4">
            📡 Datos del microservicio Python · Puerto 8080
        </p>
    </div>
</x-app-layout>