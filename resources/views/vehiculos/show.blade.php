<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">{{ $vehiculo->marca }} {{ $vehiculo->modelo }}</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-md mt-6">
        <img src="{{ asset('storage/vehiculos/'.$vehiculo->imagen) }}" alt="{{ $vehiculo->marca }}" class="rounded-lg mb-4 w-full">
        <h3 class="text-2xl font-bold mb-2">{{ $vehiculo->marca }} {{ $vehiculo->modelo }}</h3>
        <p class="text-gray-600 mb-2">Tipo: {{ $vehiculo->tipo }}</p>
        <p class="text-gray-600 mb-2">Precio: ${{ number_format($vehiculo->precio, 0) }}</p>
        <p class="text-gray-500 mb-4">{{ $vehiculo->descripcion }}</p>

        <a href="{{ route('vehiculos.comprar', $vehiculo->id) }}" 
           class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded shadow-md">
           Comprar
        </a>
        <a href="{{ url()->previous() }}" 
           class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded shadow-md ml-2">
           Volver
        </a>
    </div>
</x-app-layout>
