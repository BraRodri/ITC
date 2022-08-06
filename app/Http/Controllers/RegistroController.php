<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\Facturas;
use App\Models\RegistroServicios;
use App\Models\Servicios;
use App\Models\TiposServicios;
use App\Models\User;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;

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

    public function reportes()
    {
        $estados = Helper::getDataEstadoServicios();
        $servicios = Servicios::where('estado', 1)->get();
        $estudiantes = User::where('estado', 1)->whereHas('roles', function ($query) {
            $query->where('name', 'Estudiante');
        })->get();
        $tipos_servicios = TiposServicios::where('estado', 1)->get();
        return view('pages.registro.servicios.reportes')->with([
            'estados'=> $estados,
            'servicios' => $servicios,
            'usuarios' => $estudiantes,
            'tipos_servicios' => $tipos_servicios
        ]);
    }

    public function generarReportes(Request $request)
    {
        //dd($request);
        //datos
        $fecha_i = $request->fecha_desde;
        $fecha_n = $request->fecha_hasta;

        $reporte = RegistroServicios::where('id', '<>', '');

        if($request->usuario != null){
            $reporte = $reporte->where('estudiante_id', $request->usuario);
        }

        if($request->tipo_servicio != null){
            $reporte = $reporte->where('tipo_servicio', $request->tipo_servicio);
        }

        if($request->servicio != null){
            $reporte = $reporte->where('servicio', $request->servicio);
        }

        if($request->estado != null){
            $reporte = $reporte->where('estado', $request->estado);
        }

        if($request->fecha_desde != null && $request->fecha_hasta != null){
            $reporte = $reporte->whereBetween(DB::raw('DATE(created_at)'), [$fecha_i, $fecha_n]);
        }

        $reporte = $reporte->get();

        return (new FastExcel($reporte))->download('reporte_registro_servicios_'.date('YmdHms').'.xlsx', function ($data) {

            $factura = Facturas::where('registro_servicio_id', $data->id)->first();

            return [
                "#" => $data->id,
                "Tipo Documento Estudiante" => $data->estudiante->tipo_documento,
                "Numero de Documento Estudiante" => $data->estudiante->numero_documento,
                "Nombres Estudiante" => $data->estudiante->nombres,
                "Tipo de Servicio" => $data->tipo_servicio,
                "Servicio" => $data->servicio,
                "Numero Factura" => '#'.substr(str_repeat(0, 5).$factura->id, - 5),
                "Precio" => '$'.number_format($data->valor, 0, ",", "."),
                "Estado" => Helper::getEstadoNormal($data->estado),
                "Fecha Creación" => date("Y-m-d h:i:s a", strtotime($data->created_at))
            ];
        });
    }

}
