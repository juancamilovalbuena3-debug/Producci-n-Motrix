<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('motos') }}" class="text-gray-500 hover:text-gray-700">← Volver</a>
            <h2 class="font-semibold text-xl text-gray-800">Detalle de la Moto</h2>
        </div>
    </x-slot>

    <div class="p-8 max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="md:flex">

                <div class="md:w-1/2">
                    <img src="{{ asset($moto['imagen']) }}"
                         alt="{{ $moto['nombre'] }}"
                         class="w-full h-72 object-cover">
                </div>

                <div class="md:w-1/2 p-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $moto['nombre'] }}</h1>
                    <p class="text-4xl font-bold text-blue-600 mb-4">
                        ${{ number_format($moto['precio']) }}
                    </p>

                    @if(isset($moto['descripcion']))
                        <p class="text-gray-600 text-sm mb-4">{{ $moto['descripcion'] }}</p>
                    @endif

                    <div class="space-y-3 mb-6">

                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-500">Transmisión</span>
                            <span class="font-medium">{{ $moto['transmision'] }}</span>
                        </div>

                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-500">Combustible</span>
                            <span class="font-medium">{{ $moto['combustible'] }}</span>
                        </div>

                        @if(isset($moto['anio']))
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-500">Año</span>
                            <span class="font-medium">{{ $moto['anio'] }}</span>
                        </div>
                        @endif

                        @if(isset($moto['kilometraje']))
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-500">Kilometraje</span>
                            <span class="font-medium">
                                {{ number_format($moto['kilometraje']) }} km
                            </span>
                        </div>
                        @endif

                        @if(isset($moto['garantia']))
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-500">Garantía</span>
                            <span class="font-medium">{{ $moto['garantia'] }}</span>
                        </div>
                        @endif

                        @if(isset($moto['seguridad']))
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-500">Seguridad</span>
                            <span class="font-medium text-right text-sm">
                                {{ $moto['seguridad'] }}
                            </span>
                        </div>
                        @endif

                        {{-- 🎨 COLORES SIEMPRE VISIBLES --}}
                        <div class="border-b pb-3">
                            <span class="text-gray-500 block mb-2">Colores disponibles</span>

                            @php
                                $coloresHex = [
                                    'Blanco'   => ['bg' => '#f5f5f5', 'border' => '#d1d5db'],
                                    'Negro'    => ['bg' => '#1a1a1a', 'border' => '#000000'],
                                    'Gris'     => ['bg' => '#9ca3af', 'border' => '#6b7280'],
                                    'Rojo'     => ['bg' => '#ef4444', 'border' => '#dc2626'],
                                    'Azul'     => ['bg' => '#3b82f6', 'border' => '#2563eb'],
                                    'Plata'    => ['bg' => '#e5e7eb', 'border' => '#9ca3af'],
                                    'Verde'    => ['bg' => '#22c55e', 'border' => '#16a34a'],
                                    'Amarillo' => ['bg' => '#facc15', 'border' => '#ca8a04'],
                                    'Naranja'  => ['bg' => '#f97316', 'border' => '#ea580c'],
                                    'Cafe'     => ['bg' => '#92400e', 'border' => '#78350f'],
                                ];

                                // 🔥 COLORES POR DEFECTO SI NO EXISTEN
                                $coloresDefault = ['Negro', 'Blanco'];

                                $listaColores = isset($moto['colores']) && !empty($moto['colores'])
                                    ? (is_array($moto['colores'])
                                        ? $moto['colores']
                                        : array_filter(array_map('trim', explode(',', $moto['colores']))))
                                    : $coloresDefault;

                                // Si la lista queda vacía, usar default
                                if (empty($listaColores)) {
                                    $listaColores = $coloresDefault;
                                }
                            @endphp

                            <div class="flex gap-3 flex-wrap">
                                @foreach($listaColores as $color)
                                    @php
                                        $colorNombre = trim($color);
                                        $hex = $coloresHex[$colorNombre] ?? ['bg' => '#e5e7eb', 'border' => '#9ca3af'];
                                    @endphp

                                    <div class="flex flex-col items-center gap-1">
                                        <span
                                            class="w-7 h-7 rounded-full border-2 shadow-sm hover:scale-125 transition cursor-pointer"
                                            style="background-color: {{ $hex['bg'] }};
                                                   border-color: {{ $hex['border'] }};"
                                            title="{{ $colorNombre }}">
                                        </span>
                                        <span class="text-xs text-gray-500">{{ $colorNombre }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-500">ID</span>
                            <span class="font-medium">#{{ $moto['id'] }}</span>
                        </div>
                    </div>

                    {{-- 🛒 BOTÓN --}}
                    <a href="{{ route('motos.comprar', $moto['id']) }}"
                       class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white
                              font-semibold py-3 px-6 rounded-lg transition duration-200 mb-3">
                        🛒 Comprar ahora
                    </a>

                    <a href="{{ route('motos') }}"
                       class="block text-center mt-1 text-gray-500 hover:text-gray-700 text-sm">
                        ← Seguir viendo motos
                    </a>
                </div>
            </div>
        </div>

        <p class="text-center text-xs text-gray-400 mt-4">
            📡 Datos del microservicio Python · Puerto 8080
        </p>
    </div>
</x-app-layout>