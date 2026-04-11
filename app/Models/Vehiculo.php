<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use HasFactory;

    protected $table = 'vehiculos';

    protected $fillable = [
        'tipo',
        'marca',
        'modelo',
        'precio',
        'descripcion',
        'imagen', // Agregado para subir la imagen
    ];
}
