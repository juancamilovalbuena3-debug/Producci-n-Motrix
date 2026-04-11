<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\PaymentController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    /* ========================
       🏠 DASHBOARD
    ========================= */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /* ========================
       👨‍💼 EMPLEADOS (solo admin)
    ========================= */
    Route::middleware('role:admin')->group(function () {
        Route::resource('empleados', EmpleadoController::class);
        Route::get('/empleados/export/pdf', [EmpleadoController::class, 'exportPdf'])->name('empleados.export.pdf');
        Route::get('/empleados/export/csv', [EmpleadoController::class, 'exportCsv'])->name('empleados.export.csv');
    });

    /* ========================
       🚗 VEHÍCULOS (solo admin)
    ========================= */
    Route::middleware('role:admin')->group(function () {
        Route::get('/vehiculos', [VehiculoController::class, 'index'])->name('vehiculos.index');
        Route::get('/vehiculos/create', [VehiculoController::class, 'create'])->name('vehiculos.create');
        Route::post('/vehiculos', [VehiculoController::class, 'store'])->name('vehiculos.store');
        Route::get('/vehiculos/{id}/edit', [VehiculoController::class, 'edit'])->name('vehiculos.edit');
        Route::put('/vehiculos/{id}', [VehiculoController::class, 'update'])->name('vehiculos.update');
        Route::delete('/vehiculos/{id}', [VehiculoController::class, 'destroy'])->name('vehiculos.destroy');
        Route::get('/vehiculos/export/pdf', [VehiculoController::class, 'exportPdf'])->name('vehiculos.export.pdf');
        Route::get('/vehiculos/export/csv', [VehiculoController::class, 'exportCsv'])->name('vehiculos.export.csv');
    });

    /* ========================
       💰 VENDER + REPORTES (admin y empleado)
    ========================= */
    Route::middleware('role:admin|empleado')->group(function () {
        Route::get('/vender', [VehiculoController::class, 'create'])->name('vender');
        Route::post('/vender', [VehiculoController::class, 'store'])->name('vender.store');
        Route::get('/reportes', [VehiculoController::class, 'reportes'])->name('reportes');
    });

    /* ========================
       🐍 CARROS (todos los roles)
    ========================= */
    Route::get('/carros', [VehiculoController::class, 'carros'])->name('carros');
    Route::get('/carros/{id}/detalle', [VehiculoController::class, 'verDetalleCarro'])->name('carros.detalle');
    Route::get('/carros/{id}/comprar', [VehiculoController::class, 'formComprarCarro'])->name('carros.form.comprar');
    Route::post('/carros/{id}/comprar', [VehiculoController::class, 'comprarCarro'])->name('carros.comprar');

    /* ========================
       🐍 MOTOS (todos los roles)
    ========================= */
    Route::get('/motos', [VehiculoController::class, 'motos'])->name('motos');
    Route::get('/motos/{id}/detalle', [VehiculoController::class, 'verDetalleMoto'])->name('motos.detalle');
    Route::get('/motos/{id}/comprar', [VehiculoController::class, 'formComprarMoto'])->name('motos.form.comprar');
    Route::post('/motos/{id}/comprar', [VehiculoController::class, 'comprarMoto'])->name('motos.comprar');

    /* ========================
       📄 COMPRAS - PDF (todos los roles)
    ========================= */
    Route::get('/compras/{id}/pdf', [VehiculoController::class, 'descargarCompraPdf'])->name('compras.pdf');

    /* ========================
       🗑️ COMPRAS - ELIMINAR (solo admin)
    ========================= */
    Route::middleware('role:admin')->group(function () {
        Route::delete('/compras/{id}', [VehiculoController::class, 'eliminarCompra'])->name('compras.eliminar');
    });

    /* ========================
       ⚙️ CONFIGURACIÓN (todos los roles)
    ========================= */
    Route::get('/configuracion', [ConfiguracionController::class, 'index'])->name('configuracion');

    /* ========================
       💳 PAGOS (todos los roles)
    ========================= */
    Route::get('/pagar', [PaymentController::class, 'pagar'])->name('pagar');
    Route::get('/success', function () { return "Pago exitoso"; })->name('success');
    Route::get('/cancel', function () { return "Pago cancelado"; })->name('cancel');
});
