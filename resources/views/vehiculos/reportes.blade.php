<x-app-layout>

    <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
    📊 Dashboard de Reportes
    </h2>
    </x-slot>

    <div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
    {{ session('success') }}
    </div>
    @endif

    @if($error)
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
    {{ $error }}
    </div>
    @endif

    <!-- TARJETAS -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white shadow rounded-lg p-6 text-center">
    <h3 class="text-gray-500 text-sm">Total Ventas</h3>
    <p class="text-3xl font-bold text-blue-600">{{ $reporte['total_ventas'] ?? 0 }}</p>
    </div>
    <div class="bg-white shadow rounded-lg p-6 text-center">
    <h3 class="text-gray-500 text-sm">Total Dinero</h3>
    <p class="text-3xl font-bold text-green-600">${{ number_format($reporte['total_dinero'] ?? 0) }}</p>
    </div>
    <div class="bg-white shadow rounded-lg p-6 text-center">
    <h3 class="text-gray-500 text-sm">Carros</h3>
    <p class="text-3xl font-bold text-indigo-600">{{ $reporte['total_carros'] ?? 0 }}</p>
    </div>
    <div class="bg-white shadow rounded-lg p-6 text-center">
    <h3 class="text-gray-500 text-sm">Motos</h3>
    <p class="text-3xl font-bold text-purple-600">{{ $reporte['total_motos'] ?? 0 }}</p>
    </div>
    </div>

    <!-- GRAFICAS -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="bg-white shadow rounded-lg p-6">
    <h3 class="font-semibold mb-4">📈 Ventas por fecha</h3>
    <canvas id="ventasChart"></canvas>
    </div>
    <div class="bg-white shadow rounded-lg p-6">
    <h3 class="font-semibold mb-4">🥧 Carros vs Motos</h3>
    <canvas id="tipoChart"></canvas>
    </div>
    <div class="bg-white shadow rounded-lg p-6">
    <h3 class="font-semibold mb-4">💰 Dinero por venta</h3>
    <canvas id="dineroChart"></canvas>
    </div>
    <div class="bg-white shadow rounded-lg p-6">
    <h3 class="font-semibold mb-4">🔥 Vehículos vendidos</h3>
    <canvas id="vehiculosChart"></canvas>
    </div>
    </div>

    <!-- TABLA COMPRAS CON DOCUMENTO -->
    <div class="bg-white shadow rounded-lg p-6">
    <h3 class="font-semibold text-lg mb-4">📄 Compras registradas con documento</h3>

    @if(isset($compras) && count($compras) > 0)
    <div class="overflow-x-auto">
    <table class="min-w-full border text-sm">
    <thead class="bg-gray-100">
    <tr>
        <th class="p-2 border">ID</th>
        <th class="p-2 border">Vehículo</th>
        <th class="p-2 border">Tipo</th>
        <th class="p-2 border">Precio</th>
        <th class="p-2 border">Comprador</th>
        <th class="p-2 border">Documento</th>
        <th class="p-2 border">Teléfono</th>
        <th class="p-2 border">Color</th>
        <th class="p-2 border">Método Pago</th>
        <th class="p-2 border">Dirección</th>
        <th class="p-2 border">Fecha</th>
        <th class="p-2 border">PDF</th>
        @if(auth()->user()->role === 'admin')
        <th class="p-2 border">Eliminar</th>
        @endif
    </tr>
    </thead>
    <tbody>
    @foreach($compras as $c)
    <tr class="border-t hover:bg-gray-50">
        <td class="p-2 border text-center">{{ $c->id }}</td>
        <td class="p-2 border font-semibold">{{ $c->vehiculo }}</td>
        <td class="p-2 border text-center">{{ ucfirst($c->tipo) }}</td>
        <td class="p-2 border text-green-600 font-semibold text-center">${{ number_format($c->precio) }}</td>
        <td class="p-2 border">{{ $c->nombre_comprador ?? '-' }}</td>
        <td class="p-2 border text-center">{{ $c->documento ?? '-' }}</td>
        <td class="p-2 border text-center">{{ $c->telefono ?? '-' }}</td>
        <td class="p-2 border text-center">{{ $c->color ?? '-' }}</td>
        <td class="p-2 border text-center">{{ $c->metodo_pago ?? '-' }}</td>
        <td class="p-2 border">{{ $c->direccion ?? '-' }}</td>
        <td class="p-2 border text-center">{{ $c->created_at->format('Y-m-d H:i') }}</td>
        <td class="p-2 border text-center">
            <a href="{{ route('compras.pdf', $c->id) }}" target="_blank"
               class="bg-white hover:bg-gray-100 text-black border border-gray-300 px-3 py-1 rounded text-xs shadow">
                📄 Ver PDF
            </a>
        </td>
        @if(auth()->user()->role === 'admin')
        <td class="p-2 border text-center">
            <form action="{{ route('compras.eliminar', $c->id) }}" method="POST"
                  onsubmit="return confirm('¿Eliminar esta compra?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs shadow">
                    🗑️ Eliminar
                </button>
            </form>
        </td>
        @endif
    </tr>
    @endforeach
    </tbody>
    </table>
    </div>
    @else
    <div class="text-center py-8 text-gray-500">
        <p class="text-lg">📭 No hay compras registradas aún.</p>
        <p class="text-sm mt-1">Las compras confirmadas aparecerán aquí con todos sus datos.</p>
    </div>
    @endif
    </div>

    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    // Datos reales desde Python via PHP
    const ventasPorMes   = @json($reporte['ventas_por_mes'] ?? []);
    const carrosVendidos = @json($reporte['ventas_por_vehiculo_carros'] ?? null) ?? {};
    const motosVendidas  = @json($reporte['ventas_por_vehiculo_motos'] ?? null) ?? {};
    const totalCarros    = {{ $reporte['total_carros'] ?? 0 }};
    const totalMotos     = {{ $reporte['total_motos'] ?? 0 }};

    // 📈 Ventas por mes (línea)
    new Chart(document.getElementById('ventasChart'), {
        type: 'line',
        data: {
            labels: ventasPorMes.map(v => v.mes),
            datasets: [{ label: 'Ventas', data: ventasPorMes.map(v => v.cantidad), borderColor: '#3b82f6', backgroundColor: 'rgba(59,130,246,0.1)', borderWidth: 3, tension: 0.3, fill: true }]
        },
        options: { responsive: true, plugins: { legend: { position: 'top' } } }
    });

    // 🥧 Carros vs Motos (pie)
    new Chart(document.getElementById('tipoChart'), {
        type: 'pie',
        data: {
            labels: ['Carros', 'Motos'],
            datasets: [{ data: [totalCarros, totalMotos], backgroundColor: ['#3b82f6', '#ec4899'] }]
        },
        options: { responsive: true }
    });

    // 💰 Dinero por mes (barras)
    new Chart(document.getElementById('dineroChart'), {
        type: 'bar',
        data: {
            labels: ventasPorMes.map(v => v.mes),
            datasets: [{ label: 'Precio venta', data: ventasPorMes.map(v => v.total), backgroundColor: '#10b981' }]
        },
        options: { responsive: true }
    });

    // 🔥 Vehículos vendidos (barras horizontales)
    const todosVehiculos = { ...carrosVendidos, ...motosVendidas };
    new Chart(document.getElementById('vehiculosChart'), {
        type: 'bar',
        data: {
            labels: Object.keys(todosVehiculos),
            datasets: [{ label: 'Vehículos vendidos', data: Object.values(todosVehiculos), backgroundColor: '#f59e0b' }]
        },
        options: { responsive: true, indexAxis: 'y' }
    });
    </script>

</x-app-layout>
