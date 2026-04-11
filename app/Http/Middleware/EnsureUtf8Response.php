<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUtf8Response
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->is('livewire/update')) {
            return $next($request);
        }

        try {
            $response = $next($request);
            $content = $response->getContent();
            $cleaned = iconv('UTF-8', 'UTF-8//IGNORE', $content);
            if ($cleaned) {
                $response->setContent($cleaned);
            }
            return $response;
        } catch (\InvalidArgumentException $e) {
            // Devolver respuesta vacía válida para que Livewire no explote la vista
            return response()->json([
                'components' => [],
                'assets' => [],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'components' => [],
                'assets' => [],
            ]);
        }
    }
}