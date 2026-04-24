<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            {{ __('Motos disponibles') }}
        </h2>
    </x-slot>

    <div class="p-6">

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-800 rounded-lg">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-800 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6" id="grid-motos">
            @php $motos = $motos ?? []; @endphp
            @forelse($motos as $moto)
            @php
                $t = strtolower(trim($moto['transmision'] ?? ''));
                if (str_contains($t, 'auto')) {
                    $transmisionNormalizada = 'Automático';
                } elseif (str_contains($t, 'man')) {
                    $transmisionNormalizada = 'Manual';
                } else {
                    $transmisionNormalizada = $moto['transmision'] ?? '';
                }
            @endphp
            <div class="border rounded-lg shadow-md p-4 bg-white"
                 data-precio="{{ $moto['precio'] }}"
                 data-nombre="{{ $moto['nombre'] }}">

                <img src="{{ asset($moto['imagen']) }}"
                     alt="{{ $moto['nombre'] }}"
                     class="rounded-lg mb-4 w-full h-48 object-cover">

                <h3 class="text-lg font-bold">{{ $moto['nombre'] }}</h3>
                <p class="text-gray-600">Precio: ${{ number_format($moto['precio']) }}</p>
                <p class="text-gray-500">{{ $transmisionNormalizada }} · {{ $moto['combustible'] }}</p>

                <div class="mt-4 flex space-x-2">
                    <a href="{{ route('motos.detalle', $moto['id']) }}"
                       class="bg-white hover:bg-gray-200 text-black font-semibold px-4 py-2 rounded flex-1 border text-center">
                        Ver Detalles
                    </a>
                    <a href="{{ route('motos.form.comprar', $moto['id']) }}"
                       class="bg-white hover:bg-gray-200 text-black font-semibold px-4 py-2 rounded flex-1 border text-center">
                        Comprar
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-12 text-gray-500">
                <p class="text-xl">No se pudo conectar con el microservicio Python.</p>
            </div>
            @endforelse
        </div>

    </div>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const orden = localStorage.getItem('orden_vehiculos') || 'nombre';
            const grid  = document.getElementById('grid-motos');
            const cards = Array.from(grid.querySelectorAll('[data-precio]'));

            cards.sort((a, b) => {
                if (orden === 'precio_asc') {
                    return parseFloat(a.dataset.precio) - parseFloat(b.dataset.precio);
                } else if (orden === 'precio_desc') {
                    return parseFloat(b.dataset.precio) - parseFloat(a.dataset.precio);
                } else {
                    return a.dataset.nombre.localeCompare(b.dataset.nombre);
                }
            });

            cards.forEach(card => grid.appendChild(card));
        });
    </script>

</x-app-layout>