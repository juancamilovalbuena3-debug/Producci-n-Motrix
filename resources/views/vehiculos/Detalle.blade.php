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

                <div class="md:w-1/2">
                    <img src="{{ asset($producto['imagen']) }}"
                         alt="{{ $producto['nombre'] }}"
                         class="w-full h-72 object-cover">
                </div>

                <div class="md:w-1/2 p-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $producto['nombre'] }}</h1>
                    <p class="text-4xl font-bold text-blue-600 mb-4">${{ number_format($producto['precio']) }}</p>

                    @if(isset($producto['descripcion']))
                    <p class="text-gray-600 text-sm mb-4">{{ $producto['descripcion'] }}</p>
                    @endif

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
                            <span class="font-medium">{{ number_format($producto['kilometraje']) }} km</span>
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
                            <span class="font-medium text-right text-sm">{{ $producto['seguridad'] }}</span>
                        </div>
                        @endif
                        @if(isset($producto['colores']))
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-500">Colores</span>
                            <span class="font-medium text-sm">{{ implode(', ', $producto['colores']) }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-500">ID</span>
                            <span class="font-medium">#{{ $producto['id'] }}</span>
                        </div>
                    </div>

                    <a href="{{ route('carros') }}" class="block text-center mt-3 text-gray-500 hover:text-gray-700 text-sm">
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
