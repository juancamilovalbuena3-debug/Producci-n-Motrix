<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Vehículos</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        th { background-color: #f2f2f2; }
        h2, h4 { text-align: center; margin: 0; }
    </style>
</head>
<body>
    <h2>Reporte de Vehículos</h2>

    <!-- Mostrar filtros aplicados -->
    <h4>
        @if(request('marca')) Marca: {{ request('marca') }} @endif
        @if(request('modelo')) | Modelo: {{ request('modelo') }} @endif
    </h4>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tipo</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Precio</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($vehiculos as $vehiculo)
                <tr>
                    <td>{{ $vehiculo->id }}</td>
                    <td>{{ $vehiculo->tipo }}</td>
                    <td>{{ $vehiculo->marca }}</td>
                    <td>{{ $vehiculo->modelo }}</td>
                    <td>${{ number_format($vehiculo->precio, 0, ',', '.') }}</td>
                    <td>{{ $vehiculo->descripcion ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No hay vehículos con los filtros aplicados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
