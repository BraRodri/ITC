<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RegistroServicios extends Model
{
    use HasFactory;

    protected $fillable = [
        'estudiante_id',
        'fecha',
        'servicio_id',
        'tipo_servicio',
        'servicio',
        'valor',
        'estado'
    ];

    public function estudiante(){
        return $this->belongsTo(User::class, 'estudiante_id');
    }
}
