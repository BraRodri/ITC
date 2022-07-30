<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servicios extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'codigo',
        'nombre',
        'tipo_servicio_id',
        'ciudad',
        'precio',
        'estado'
    ];

    public function tipoServicio(){
        return $this->belongsTo(TiposServicios::class, 'tipo_servicio_id');
    }
}
