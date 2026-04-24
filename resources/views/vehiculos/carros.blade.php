<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            {{ __('Carros disponibles') }}
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

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6" id="grid-carros">
            @forelse($carros as $carro)
            @php
                $transmision = $carro['transmision'] ?? '';
                $transmisionNormalizada = match(strtolower(trim($transmision))) {
                    'automatico', 'automático', 'automatic' => 'Automático',
                    'manual'                                => 'Manual',
                    default                                 => $transmision,
                };
            @endphp
            <div class="border rounded-lg shadow-md p-4 bg-white"
                 data-precio="{{ $carro['precio'] }}"
                 data-nombre="{{ $carro['nombre'] }}">

                <img src="{{ asset($carro['imagen']) }}"
                     alt="{{ $carro['nombre'] }}"
                     class="rounded-lg mb-4 w-full h-48 object-cover">

                <h3 class="text-lg font-bold">{{ $carro['nombre'] }}</h3>
                <p class="text-gray-600">Precio: ${{ number_format($carro['precio']) }}</p>
                <p class="text-gray-500">{{ $transmisionNormalizada }} · {{ $carro['combustible'] }}</p>

                <div class="mt-4 flex space-x-2">
                    <a href="{{ route('carros.detalle', $carro['id']) }}"
                       class="bg-white hover:bg-gray-200 text-black font-semibold px-4 py-2 rounded flex-1 border text-center">
                        Ver Detalles
                    </a>
                    <a href="{{ route('carros.form.comprar', $carro['id']) }}"
                       class="bg-white hover:bg-gray-200 text-black font-semibold px-4 py-2 rounded flex-1 border text-center">
                        Comprar
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-12 text-gray-500">
                <p class="text-xl">⚠️ No se pudo conectar con el microservicio Python.</p>
                <p class="text-sm mt-2">Asegúrate de ejecutar: <code class="bg-gray-100 px-2 py-1 rounded">python main.py</code></p>
            </div>
            @endforelse
        </div>
    </div>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const orden = localStorage.getItem('orden_vehiculos') || 'nombre';
            const grid  = document.getElementById('grid-carros');
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