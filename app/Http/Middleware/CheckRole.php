<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        $user = auth()->user();

        if (!$user) {
            abort(403, 'Usuario no autenticado');
        }

        try {
            $response = Http::timeout(5)->post('http://127.0.0.1:8080/check-role', [
                'email' => $user->email,
            ]);

            if ($response->failed()) {
                abort(403, 'Error al consultar el microservicio');
            }

            $userRole = $response->json('role');

            if (!$userRole) {
                abort(403, 'Rol no encontrado');
            }

            // Soporta múltiples roles separados por | (ej: 'admin|empleado')
            $rolesPermitidos = explode('|', $role);

            if (!in_array($userRole, $rolesPermitidos)) {
                // Redirige al dashboard con mensaje en vez de abortar
                return redirect()->route('dashboard')
                    ->with('error', 'No tienes permisos para acceder a esa sección.');
            }

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            return redirect()->route('dashboard')
                ->with('error', 'Microservicio Python no disponible. Ejecuta: python main.py');
        } catch (\Exception $e) {
            abort(500, 'Error interno: ' . $e->getMessage());
        }

        return $next($request);
    }
}
