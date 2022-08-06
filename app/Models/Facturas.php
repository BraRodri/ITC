<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facturas extends Model
{
    use HasFactory;

    protected $fillable = [
        'registro_servicio_id',
        'tipo',
        'fecha',
        'valor',
        'saldo',
        'estado'
    ];

    public function registroServicio(){
        return $this->belongsTo(RegistroServicios::class, 'registro_servicio_id');
    }
}
