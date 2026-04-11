<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = 'compras';

    protected $fillable = [
        'user_id',
        'vehiculo',
        'precio',
        'tipo',
        'color',
        'metodo_pago',
        'banco',
        'cuotas',
        'nombre_comprador',
        'documento',
        'telefono',
        'direccion',
        'observaciones',
        'firma_comprador',
    ];
}