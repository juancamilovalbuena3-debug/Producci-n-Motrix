content = """<?php

namespace App\\Http\\Controllers;

use Illuminate\\Http\\Request;
use Illuminate\\Support\\Facades\\Http;

class MotosController extends Controller
{
    public function index()
    {
        try {
            $response = Http::timeout(5)->get('http://127.0.0.1:8080/motos');
            $motos = $response->json();
        } catch (\\Exception $e) {
            $motos = [];
        }
        return view('vehiculos.motos', compact('motos'));
    }

    public function detalle($id)
    {
        try {
            $response = Http::timeout(5)->get("http://127.0.0.1:8080/moto/$id");
            $moto = $response->json();
        } catch (\\Exception $e) {
            $moto = null;
        }
        return view('vehiculos.detalle_moto', compact('moto'));
    }

    public function comprar($id)
    {
        try {
            $response = Http::timeout(5)->post("http://127.0.0.1:8080/comprar-moto/$id");
            $resultado = $response->json();
            return redirect()->route('motos.index')->with('success', 'Compra exitosa: ' . $resultado['vehiculo']);
        } catch (\\Exception $e) {
            return redirect()->route('motos.index')->with('error', 'Error al procesar la compra.');
        }
    }
}
"""

with open(r'C:\\Users\\adminsena\\Downloads\\motrixpython-main\\app\\Http\\Controllers\\MotosController.php', 'w') as f:
    f.write(content)
print('Controlador guardado OK')