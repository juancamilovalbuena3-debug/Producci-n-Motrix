<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
            'tipo' => 'required|string',
            'marca' => 'required|string',
            'modelo' => 'required|string',
            'anio' => 'required|numeric',
            'color' => 'nullable|string',
            'precio' => 'required|numeric',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $vehiculo = new Vehiculo();
        $vehiculo->tipo = $request->tipo;
        $vehiculo->marca = $request->marca;
        $vehiculo->modelo = $request->modelo;
        $vehiculo->precio = $request->precio;
        $vehiculo->descripcion = $request->descripcion;

        // Guardar imagen si se sube
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->storeAs('public/vehiculos', $filename);
            $vehiculo->imagen = $filename;
        }

        $vehiculo->save();

        return redirect()->route('dashboard')->with('success', 'Vehículo publicado con éxito 🚗🏍️');
    }
}
