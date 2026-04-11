<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Times New Roman', serif; font-size: 12px; margin: 40px; }
        h1 { text-align: center; font-size: 16px; text-transform: uppercase; }
        .centro { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin: 16px 0; }
        th, td { border: 1px solid black; padding: 6px 10px; }
        th { background: #f0f0f0; }
        .seccion { font-weight: bold; text-transform: uppercase; margin-top: 16px; }
    </style>
</head>
<body>
    <p class="centro">{{ $compra->created_at->format('d \d\e F \d\e Y') }}</p>
    <h1>Declaración Jurada de Medio de Pago</h1>
    <p class="centro">Señores: <strong>SUPERINTENDENCIA NACIONAL DE LOS REGISTROS PÚBLICOS</strong></p>
    <p class="centro">Registro de Propiedad Vehicular</p>
    <p>La empresa <strong>Motrix</strong>, en su calidad de empresa <strong>Vendedora</strong>,
    y el comprador abajo indicado, declaramos la compra del vehículo:</p>

    <table>
        <thead><tr><th>Vehículo</th><th>Tipo</th><th>Fecha</th><th>Importe</th></tr></thead>
        <tbody>
            <tr>
                <td>{{ $compra->vehiculo }}</td>
                <td>{{ ucfirst($compra->tipo) }}</td>
                <td>{{ $compra->created_at->format('Y-m-d') }}</td>
                <td>${{ number_format($compra->precio) }} COP</td>
            </tr>
        </tbody>
    </table>

    <p class="seccion">Forma de Cancelación:</p>
    <table>
        <thead><tr><th>Medio de Pago</th><th>Banco</th><th>Cuotas</th><th>Color</th><th>Importe Total</th></tr></thead>
        <tbody>
            <tr>
                <td>{{ $compra->metodo_pago ?? '-' }}</td>
                <td>{{ $compra->banco ?? '-' }}</td>
                <td>{{ $compra->cuotas ?? '-' }}</td>
                <td>{{ $compra->color ?? '-' }}</td>
                <td>${{ number_format($compra->precio) }} COP</td>
            </tr>
        </tbody>
    </table>

    <p class="seccion">Datos del Comprador:</p>
    <table>
        <tr><th>Nombre</th><td>{{ $compra->nombre_comprador ?? '-' }}</td></tr>
        <tr><th>Documento</th><td>{{ $compra->documento ?? '-' }}</td></tr>
        <tr><th>Teléfono</th><td>{{ $compra->telefono ?? '-' }}</td></tr>
        <tr><th>Dirección</th><td>{{ $compra->direccion ?? '-' }}</td></tr>
        @if($compra->observaciones)
        <tr><th>Observaciones</th><td>{{ $compra->observaciones }}</td></tr>
        @endif
    </table>

    <table style="margin-top: 60px;">
        <tr>
            <td style="width:50%; text-align:center; border:none; padding-top: 10px;">
                <img src="{{ public_path('images/firma_motrix.png') }}"
                     style="width: 160px; height: 55px; display: block; margin: 0 auto;" />
                <p><strong>CONCESIONARIO</strong></p>
            </td>
            <td style="width:50%; text-align:center; border:none; padding-top: 10px;">
                @if($compra->firma_comprador)
                    <img src="{{ $compra->firma_comprador }}"
                         style="width: 160px; height: 55px; display: block; margin: 0 auto;" />
                @endif
                <div style="border-top: 1px solid black; width: 80%; margin: 6px auto;"></div>
                <p><strong>COMPRADOR</strong></p>
                <p>{{ $compra->nombre_comprador ?? '' }}</p>
                <p>Firma y Huella</p>
            </td>
        </tr>
    </table>
</body>
</html>