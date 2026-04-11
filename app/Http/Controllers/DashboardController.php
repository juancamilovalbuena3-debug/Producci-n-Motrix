<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Muestra el panel principal sin la tabla de vehículos.
     */
    public function index()
    {
        return view('dashboard');
    }
}
