<?php

namespace App\Http\Controllers;

use App\Models\RegistroServicios;
use Illuminate\Http\Request;

class RegistroController extends Controller
{

    public function servicios()
    {
        return view('pages.registro.servicios.index');
    }

    public function serviciosCreate(Request $request)
    {
        $error = false;
        $mensaje = '';

        $guardar = array(
            'estudiante_id' => $request->estudiante,
            'fecha' => $request->fecha,
            'servicio_id' => $request->servicio,
            'tipo_servicio' => $request->tipo_servicio,
            'servicio' => $request->nombre_servicio,
            'valor' => $request->valor_servicio,
            'estado' => $request->estado
        );

        if($data = RegistroServicios::create($guardar)){
            $error = false;
            $mensaje = '';
        } else {
            $error = true;
            $mensaje = 'Error, se presento un problema al registrar el serivicio!';
        }

        echo json_encode(array('error' => $error, 'mensaje' => $mensaje));
    }

}
