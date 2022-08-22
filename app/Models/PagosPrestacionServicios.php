<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagosPrestacionServicios extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'fecha_emision',
        'nombre_usuario',
        'numero_documento_usuario',
        'domicilio_usuario',
        'valor',
        'valor_texto',
        'conceptos',
        'observaciones',
        'firma'
    ];
}
