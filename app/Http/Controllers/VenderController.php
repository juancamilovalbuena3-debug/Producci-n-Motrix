<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Vehiculo;

class VenderController extends Controller
{
    // Mostrar formulario de venta
    public function create()
    {
        return view('vehiculos.vender');
    }

    // Guardar vehículo en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'tipo'        => 'required|string',
            'marca'       => 'required|string',
            'modelo'      => 'required|string',
            'precio'      => 'required|numeric',
            'transmision' => 'required|string|in:Automatico,Manual',
            'descripcion' => 'nullable|string',
            'imagen'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // ── Guardar en base de datos Laravel ──────────────────────
        $vehiculo               = new Vehiculo();
        $vehiculo->tipo         = $request->tipo;
        $vehiculo->marca        = $request->marca;
        $vehiculo->modelo       = $request->modelo;
        $vehiculo->precio       = $request->precio;
        $vehiculo->transmision  = $request->transmision;   // ✅ NUEVO
        $vehiculo->descripcion  = $request->descripcion;

        if ($request->hasFile('imagen')) {
            $file     = $request->file('imagen');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/vehiculos', $filename);
            $vehiculo->imagen = $filename;
        }

        $vehiculo->save();

        // ── Sincronizar con microservicio Python ───────────────────
        try {
            $tipo  = strtolower($request->tipo); // 'carro' o 'moto'
            $ruta  = $tipo === 'moto' ? 'http://127.0.0.1:8080/motos/crear'
                                      : 'http://127.0.0.1:8080/productos/crear';

            Http::post($ruta, [
                'id_laravel'  => $vehiculo->id,
                'nombre'      => $request->marca . ' ' . $request->modelo,
                'marca'       => $request->marca,
                'modelo'      => $request->modelo,
                'precio'      => $request->precio,
                'transmision' => $request->transmision,   // ✅ NUEVO
                'combustible' => 'Gasolina',
                'descripcion' => $request->descripcion ?? '',
                'garantia'    => '1 año',
                'seguridad'   => 'ABS',
                'colores'     => ['Blanco', 'Negro'],
                'imagen'      => 'images/default.jpg',
            ]);
        } catch (\Exception $e) {
            // Si Python no está corriendo, igual guarda en Laravel
        }

        return redirect()->route('dashboard')->with('success', 'Vehículo publicado con éxito 🚗🏍️');
    }
}