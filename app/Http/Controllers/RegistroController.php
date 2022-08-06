<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\Facturas;
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

            //crear factura al servicio
            $crear_factura = array(
                'registro_servicio_id' => $data->id,
                'tipo' => 'Servicio',
                'fecha' => date('Y-m-d'),
                'valor' => $data->valor,
                'saldo' => $data->valor,
                'estado' => 1
            );

            if(Facturas::create($crear_factura)){
                $error = false;
                $mensaje = '';
            } else {
                $error = true;
                $mensaje = 'Error, se presento un problema al crear la factura al servicio!';
            }

        } else {
            $error = true;
            $mensaje = 'Error, se presento un problema al registrar el serivicio!';
        }

        echo json_encode(array('error' => $error, 'mensaje' => $mensaje));
    }

    public function serviciosAll()
    {
        $datos = array();

        $data = RegistroServicios::all();
        if(count($data) > 0){
            foreach ($data as $key => $value) {

                $botones = '';
                $botones .= '<div class="btn-group" role="group">';
                $botones .= "<a href='".route('servicios.edit', $value->id)."' class='btn btn-success btn-sm'>Editar</a>";
               // $botones .= "<button class='btn btn-danger btn-sm' onclick='eliminarUsuario(".$value->id.");'>Eliminar</button>";
                $botones .= '</div>';

                $factura = Facturas::where('registro_servicio_id', $value->id)->first();
                $url_factura = route('facturacion.ver', $factura->id);

                $datos[] = array(
                    $value->id,
                    $value->estudiante->nombres,
                    $value->fecha,
                    $value->servicio,
                    $value->tipo_servicio,
                    '$'.number_format($value->valor, 0, ",", "."),
                    "<span class='badge bg-" . Helper::getColorEstadoNormal($value->estado) . "'>" . Helper::getEstadoNormal($value->estado) . "</span>",
                    "<a href='$url_factura' class='btn btn-primary btn-sm'>Factura</a>",
                    $botones
                );

            }
        }

        echo json_encode([
            'data' => $datos,
        ]);
    }

}
