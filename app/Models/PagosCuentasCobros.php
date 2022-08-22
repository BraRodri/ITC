<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagosCuentasCobros extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'numero_cuenta_cobro',
        'fecha_inicio',
        'fecha_terminacion',
        'nombre_usuario',
        'tipo_documento_usuario',
        'numero_documento_usuario',
        'valor',
        'valor_texto',
        'conceptos'
    ];
}
