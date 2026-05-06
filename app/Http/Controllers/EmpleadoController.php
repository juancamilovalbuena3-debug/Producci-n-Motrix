<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\Vehiculo;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Http;

class EmpleadoController extends Controller
{
    private string $microservicio;

    public function __construct()
    {
        $this->microservicio = env('PYTHON_MICROSERVICE_URL', 'https://motrix-python-api.onrender.com');
    }

    public function index(Request $request)
    {
        $queryEmpleados = Empleado::query();

        if ($request->filled('busqueda')) {
            $busqueda = trim($request->busqueda);
            $queryEmpleados->where(function ($q) use ($busqueda) {
                $q->where('nombre', 'like', '%' . strtolower($busqueda) . '%')
                  ->orWhere('email', 'like', '%' . strtolower($busqueda) . '%');
            });
        }

        $empleados = $queryEmpleados->paginate(10)->withQueryString();

        $queryVehiculos = Vehiculo::query();

        if ($request->filled('busqueda')) {
            $busqueda = trim($request->busqueda);
            $queryVehiculos->where(function ($q) use ($busqueda) {
                $q->where('marca', 'like', "%$busqueda%")
                  ->orWhere('modelo', 'like', "%$busqueda%");
            });
        }

        if ($request->filled('tipo')) {
            $queryVehiculos->where('tipo', $request->tipo);
        }

        $vehiculos = $queryVehiculos->paginate(10)->withQueryString();

        return view('empleados.index', compact('empleados', 'vehiculos'));
    }

    public function create()
    {
        return view('empleados.create');
    }

    public function store(Request $request)
    {
        try {
            $respuesta = Http::timeout(10)->post("{$this->microservicio}/validar/empleado", [
                'nombre'  => $request->nombre,
                'puesto'  => $request->puesto,
                'salario' => $request->salario,
                'email'   => $request->email,
            ]);

            $resultado = $respuesta->json();

            if (!($resultado['valido'] ?? false)) {
                return back()
                    ->withErrors($resultado['errores'] ?? ['general' => 'Error al validar los datos.'])
                    ->withInput();
            }
        } catch (\Exception $e) {
            $validated = $request->validate([
                'nombre'  => 'required|string|max:255',
                'puesto'  => 'required|string|max:255',
                'salario' => 'required|numeric|min:1',
                'email'   => 'required|email|unique:empleados,email',
            ], [
                'nombre.required'  => 'El nombre es obligatorio.',
                'nombre.string'    => 'El nombre debe ser texto.',
                'nombre.max'       => 'El nombre no puede superar los 255 caracteres.',
                'puesto.required'  => 'El puesto es obligatorio.',
                'puesto.string'    => 'El puesto debe ser texto.',
                'puesto.max'       => 'El puesto no puede superar los 255 caracteres.',
                'salario.required' => 'El salario es obligatorio.',
                'salario.numeric'  => 'El salario debe ser un número válido.',
                'salario.min'      => 'El salario debe ser mayor a cero.',
                'email.required'   => 'El correo electrónico es obligatorio.',
                'email.email'      => 'El correo electrónico no tiene un formato válido.',
                'email.unique'     => 'Ya existe un empleado registrado con este correo electrónico.',
            ]);

            Empleado::create($validated);
            return redirect()->route('empleados.create')->with('success', 'Empleado creado correctamente.');
        }

        Empleado::create([
            'nombre'  => $request->nombre,
            'puesto'  => $request->puesto,
            'salario' => $request->salario,
            'email'   => $request->email,
        ]);

        return redirect()->route('empleados.create')->with('success', 'Empleado creado correctamente.');
    }

    public function edit($id)
    {
        $empleado = Empleado::findOrFail($id);
        return view('empleados.edit', compact('empleado'));
    }

    public function update(Request $request, $id)
    {
        $empleado = Empleado::findOrFail($id);

        try {
            $respuesta = Http::timeout(10)->post("{$this->microservicio}/validar/empleado", [
                'id'      => $empleado->id,
                'nombre'  => $request->nombre,
                'puesto'  => $request->puesto,
                'salario' => $request->salario,
                'email'   => $request->email,
            ]);

            $resultado = $respuesta->json();

            if (!($resultado['valido'] ?? false)) {
                return back()
                    ->withErrors($resultado['errores'] ?? ['general' => 'Error al validar los datos.'])
                    ->withInput();
            }
        } catch (\Exception $e) {
            $validated = $request->validate([
                'nombre'  => 'required|string|max:255',
                'puesto'  => 'required|string|max:255',
                'salario' => 'required|numeric|min:1',
                'email'   => 'required|email|unique:empleados,email,' . $empleado->id,
            ], [
                'nombre.required'  => 'El nombre es obligatorio.',
                'nombre.string'    => 'El nombre debe ser texto.',
                'nombre.max'       => 'El nombre no puede superar los 255 caracteres.',
                'puesto.required'  => 'El puesto es obligatorio.',
                'puesto.string'    => 'El puesto debe ser texto.',
                'puesto.max'       => 'El puesto no puede superar los 255 caracteres.',
                'salario.required' => 'El salario es obligatorio.',
                'salario.numeric'  => 'El salario debe ser un número válido.',
                'salario.min'      => 'El salario debe ser mayor a cero.',
                'email.required'   => 'El correo electrónico es obligatorio.',
                'email.email'      => 'El correo electrónico no tiene un formato válido.',
                'email.unique'     => 'Ya existe un empleado registrado con este correo electrónico.',
            ]);

            $empleado->update($validated);
            return redirect()->route('empleados.index')->with('success', 'Empleado actualizado correctamente.');
        }

        $empleado->update([
            'nombre'  => $request->nombre,
            'puesto'  => $request->puesto,
            'salario' => $request->salario,
            'email'   => $request->email,
        ]);

        return redirect()->route('empleados.index')->with('success', 'Empleado actualizado correctamente.');
    }

    public function destroy($id)
    {
        $empleado = Empleado::findOrFail($id);
        $empleado->delete();
        return redirect()->route('empleados.index')->with('success', 'Empleado eliminado correctamente.');
    }

    public function exportPdf(Request $request)
    {
        $query = Empleado::query();

        if ($request->filled('busqueda')) {
            $busqueda = trim($request->busqueda);
            $query->where(function ($q) use ($busqueda) {
                $q->where('nombre', 'like', '%' . strtolower($busqueda) . '%')
                  ->orWhere('email', 'like', '%' . strtolower($busqueda) . '%');
            });
        }

        $empleados = $query->get();
        $fecha = now()->format('d/m/Y H:i');

        $pdf = Pdf::loadView('empleados.pdf', compact('empleados', 'fecha'))
                  ->setPaper('a4', 'landscape');

        $filename = 'empleados_' . now()->format('Ymd_His') . '.pdf';
        return $pdf->download($filename);
    }

    public function exportCsv(Request $request)
    {
        $query = Empleado::query();

        if ($request->filled('busqueda')) {
            $busqueda = trim($request->busqueda);
            $query->where(function ($q) use ($busqueda) {
                $q->where('nombre', 'like', '%' . strtolower($busqueda) . '%')
                  ->orWhere('email', 'like', '%' . strtolower($busqueda) . '%');
            });
        }

        $empleados = $query->get();

        $response = new StreamedResponse(function () use ($empleados) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Nombre', 'Puesto', 'Salario', 'Email']);
            foreach ($empleados as $empleado) {
                fputcsv($handle, [
                    $empleado->id,
                    $empleado->nombre,
                    $empleado->puesto,
                    $empleado->salario,
                    $empleado->email,
                ]);
            }
            fclose($handle);
        });

        $filename = 'empleados_' . now()->format('Ymd_His') . '.csv';
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');

        return $response;
    }
}
