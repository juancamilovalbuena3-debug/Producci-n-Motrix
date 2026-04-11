<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class ReporteController extends Controller
{
    public function index()
    {
        $response = Http::get('http://127.0.0.1:8080/reporte');

        $data = $response->json();

        return view('reportes.index', compact('data'));
    }
}
