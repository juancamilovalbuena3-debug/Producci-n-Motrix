<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Publicar Vehículo en Venta 🚗
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow p-6 rounded">
    <h1 class="text-2xl font-bold mb-6">Publicar Vehículo en Venta 🚗</h1>

    {{-- Error general del microservicio --}}
    @if ($errors->has('general'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <strong>Error:</strong> {{ $errors->first('general') }}
        </div>
    @endif

    <form action="{{ route('vender.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Tipo --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">Tipo:</label>
            <select
                name="tipo"
                class="w-full border p-2 rounded {{ $errors->has('tipo') ? 'border-red-500 bg-red-50' : 'border-gray-300' }}"
            >
                <option value="">-- Selecciona un tipo --</option>
                <option value="carro"     {{ old('tipo') == 'carro'     ? 'selected' : '' }}>Carro</option>
                <option value="moto"      {{ old('tipo') == 'moto'      ? 'selected' : '' }}>Moto</option>
               
               
            </select>
            @error('tipo')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Marca --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">Marca:</label>
            <input
                type="text"
                name="marca"
                value="{{ old('marca') }}"
                class="w-full border p-2 rounded {{ $errors->has('marca') ? 'border-red-500 bg-red-50' : 'border-gray-300' }}"
            >
            @error('marca')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Modelo --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">Modelo:</label>
            <input
                type="text"
                name="modelo"
                value="{{ old('modelo') }}"
                class="w-full border p-2 rounded {{ $errors->has('modelo') ? 'border-red-500 bg-red-50' : 'border-gray-300' }}"
            >
            @error('modelo')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Precio --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">Precio:</label>
            <input
                type="number"
                name="precio"
                value="{{ old('precio') }}"
                class="w-full border p-2 rounded {{ $errors->has('precio') ? 'border-red-500 bg-red-50' : 'border-gray-300' }}"
            >
            @error('precio')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Descripción --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">Descripción:</label>
            <textarea
                name="descripcion"
                rows="3"
                class="w-full border p-2 rounded {{ $errors->has('descripcion') ? 'border-red-500 bg-red-50' : 'border-gray-300' }}"
            >{{ old('descripcion') }}</textarea>
            @error('descripcion')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Imagen --}}
        <div class="mb-6">
            <label class="block font-semibold mb-1">Imagen del vehículo (opcional):</label>
            <input
                type="file"
                name="imagen"
                accept="image/*"
                class="w-full border p-2 rounded {{ $errors->has('imagen') ? 'border-red-500 bg-red-50' : 'border-gray-300' }}"
            >
            @error('imagen')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                        Publicar Vehículo
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>