<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagosFacturas extends Model
{
    use HasFactory;

    protected $fillable = [
        'factura_id',
        'tipo',
        'fecha',
        'descripcion',
        'valor',
        'estado'
    ];
}
