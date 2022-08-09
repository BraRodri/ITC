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
        'con_firma',
        'estado',
        'user_created'
    ];

    public function registroServicio(){
        return $this->belongsTo(RegistroServicios::class, 'registro_servicio_id');
    }

    public function abonos(){
        return $this->hasMany(PagosFacturas::class, 'factura_id');
    }

    public function creador(){
        return $this->belongsTo(User::class, 'user_created');
    }
}
