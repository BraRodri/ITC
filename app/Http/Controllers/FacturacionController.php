<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\Facturas;
use App\Models\PagosFacturas;
use App\Models\Servicios;
use App\Models\TiposServicios;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;

class FacturacionController extends Controller
{

    public function index()
    {
        return view('pages.facturacion.index');
    }

    public function all()
    {
        $datos = array();

        $data = Facturas::all();
        if(count($data) > 0){
            foreach ($data as $key => $value) {

                $url_descargar = route('facturacion.download', $value->id);

                $botones = '';
                $botones .= '<div class="btn-group" role="group">';
                $botones .= "<a href='".route('facturacion.ver', $value->id)."' class='btn btn-success btn-sm'><i class='fa-solid fa-eye'></i></a>";
                if(intval($value->saldo) > 0){
                    $botones .= "<button class='btn btn-primary btn-sm' onclick='realizarPago(".$value->id.");'><i class='fa-solid fa-hand-holding-dollar'></i></button>";
                }
                //$botones .= "<button class='btn btn-dark btn-sm' onclick='verMovimientos(".$value->id.");'>Movimientos</button>";
                $botones .= "<a href='".$url_descargar."' target='_blank' class='btn btn-dark btn-sm'><i class='fa-solid fa-download'></i></a>";
                $botones .= '</div>';

                $datos[] = array(
                    substr(str_repeat(0, 5).$value->id, - 5),
                    $value->registroServicio->estudiante->nombres,
                    $value->fecha,
                    $value->registroServicio->servicio,
                    $value->registroServicio->tipo_servicio,
                    '$'.number_format($value->valor, 0, ",", "."),
                    '$'.number_format($value->saldo, 0, ",", "."),
                    "<span class='badge bg-" . Helper::getColorEstadoFacturas($value->estado) . "'>" . Helper::getEstadoFacturas($value->estado) . "</span>",
                    $botones
                );

            }
        }

        echo json_encode([
            'data' => $datos,
        ]);
    }

    public function view($id)
    {
        $factura = Facturas::findOrFail($id);
        //$movimientos = PagosFacturas::where('factura_id', $factura->id)->get();
        $estados = Helper::getDataEstadoFacturas();
        return view('pages.facturacion.view')->with([
            'factura' => $factura,
            //'movimientos' => $movimientos,
            'estados' => $estados
        ]);
    }

    public function update(Request $request)
    {
        $factura_id = $request->factura_id;
        $factura = Facturas::find($factura_id);
        if($factura){

            $actualizar = array(
                'estado' => $request->estado_factura
            );
            Facturas::findOrFail($factura_id)->update($actualizar);

        }
        return redirect()->back();
    }

    public function pagosAll($id)
    {
        $datos = array();

        $data = PagosFacturas::where('factura_id', $id)->get();
        if(count($data) > 0){
            foreach ($data as $key => $value) {

                $botones = '';
                $botones .= '<div class="btn-group" role="group">';
                $botones .= "<button type='button' class='btn btn-success btn-sm' onclick='editarPago($value->id);'><i class='fa-solid fa-pen-to-square'></i></button>";
                $botones .= '</div>';

                $datos[] = array(
                    $value->id,
                    $value->tipo,
                    $value->fecha,
                    $value->descripcion,
                    '$'.number_format($value->valor, 0, ",", "."),
                    "<span class='badge bg-" . Helper::getColorEstadoPagos($value->estado) . "'>" . Helper::getEstadoPagos($value->estado) . "</span>",
                    $botones
                );

            }
        }

        echo json_encode([
            'data' => $datos,
        ]);
    }

    public function pagoscreate(Request $request)
    {
        $error = false;
        $mensaje = '';

        $factura_id = $request->factura_id;
        $valor_pago = intval($request->valor);
        $factura = Facturas::find($factura_id);

        //se valida si existe la factura
        if(!$factura){
            $error = true;
            $mensaje = 'Error, se presento un problama, no pudimos encontrar la factura para agregar el pago!';
        } else {

            $convertido_valor = number_format($valor_pago, 0, ",", ".");

            //se valida si el pago es mayor al saldo de la factura
            if($valor_pago > $factura->saldo){
                $error = true;
                $mensaje = "Error, el valor $$convertido_valor es mayor al saldo a pagar de la factura, no es posible realizar el pago!";
            } else {

                if($request->estado == 1 || $request->estado == 2){

                    $nuevo_pago = array(
                        'factura_id' => $factura_id,
                        'tipo' => $request->tipo,
                        'fecha' => $request->fecha,
                        'descripcion' => $request->descripcion,
                        'valor' => $valor_pago,
                        'estado' => $request->estado
                    );

                    if(PagosFacturas::create($nuevo_pago)){

                        if($request->estado == 1){
                            //despues del pago, descontar el saldo
                            $saldo_viejo = intval($factura->saldo);
                            $nuevo_saldo = $saldo_viejo - $valor_pago;

                            $actualizar = array(
                                'saldo' => $nuevo_saldo
                            );

                            if($nuevo_saldo == 0){
                                $actualizar["estado"] = 2;
                            }

                            if(Facturas::findOrFail($factura_id)->update($actualizar)){
                                $error = false;
                            } else {
                                $error = true;
                                $mensaje = 'Error, se presento un problema al actualizar el nuevo saldo de la factura!';
                            }
                        } else {
                            $error = false;
                        }

                    } else {
                        $error = true;
                        $mensaje = 'Error, se presento un problema al agregar el pago a la factura!';
                    }

                } else {
                    $error = true;
                    $mensaje = 'Lo sentimos, no podemos crear un pago el cual el estado es "Anulado"';
                }

            }

        }

        echo json_encode(array('error' => $error, 'mensaje' => $mensaje));
    }

    public function pagosUpdate(Request $request)
    {
        $error = false;
        $mensaje = '';

        $pago_id = $request->pago_id;
        $pago = PagosFacturas::find($pago_id);

        if(!$pago){
            $error = true;
            $mensaje = 'Error, se presento un problama, no pudimos encontrar el pago para actualizarlo!';
        } else {

            $factura = Facturas::find($pago->factura_id);

            //se valida si existe la factura
            if(!$factura){
                $error = true;
                $mensaje = 'Error, se presento un problama, no pudimos encontrar la factura para actualizar el pago!';
            } else {

                if($pago->estado == 1){

                    if($request->estado == 1){

                        $actualizar = array(
                            'tipo' => $request->tipo
                        );
                        if(PagosFacturas::findOrFail($pago_id)->update($actualizar)){
                            $error = false;
                        } else {
                            $error = true;
                            $mensaje = 'Error, se presento un problama, no pudimos actualizar el pago!';
                        }

                    } else if($request->estado == 2 || $request->estado == 3){

                        $actualizar = array(
                            'tipo' => $request->tipo,
                            'estado' => $request->estado
                        );
                        if(PagosFacturas::findOrFail($pago_id)->update($actualizar)){

                            $valor_pago = $pago->valor;
                            $nuevo_saldo = $factura->saldo + $valor_pago;

                            $actualizar_factura = array(
                                'saldo' => $nuevo_saldo
                            );
                            if($nuevo_saldo > 0){
                                $actualizar_factura["estado"] = 1;
                            }
                            if(Facturas::findOrFail($factura->id)->update($actualizar_factura)){
                                $error = false;
                            } else {
                                $error = true;
                                $mensaje = 'Error, se presento un problama, no pudimos actualizar el saldo nuevo de la factura!';
                            }

                        } else {
                            $error = true;
                            $mensaje = 'Error, se presento un problama, no pudimos actualizar el pago!';
                        }

                    }

                } else if($pago->estado == 2){

                    if($request->estado == 1){

                        $convertido_valor = number_format($pago->valor, 0, ",", ".");
                        if($pago->valor > $factura->saldo){
                            $error = true;
                            $mensaje = "Error, el valor $$convertido_valor es mayor al saldo a pagar de la factura, no es posible realizar el pago!";
                        } else {

                            $actualizar = array(
                                'tipo' => $request->tipo,
                                'estado' => $request->estado
                            );
                            if(PagosFacturas::findOrFail($pago_id)->update($actualizar)){

                                $saldo_viejo = intval($factura->saldo);
                                $nuevo_saldo = $saldo_viejo - $pago->valor;

                                $actualizar = array(
                                    'saldo' => $nuevo_saldo
                                );

                                if($nuevo_saldo == 0){
                                    $actualizar["estado"] = 2;
                                }

                                if(Facturas::findOrFail($factura->id)->update($actualizar)){
                                    $error = false;
                                } else {
                                    $error = true;
                                    $mensaje = 'Error, se presento un problema al actualizar el nuevo saldo de la factura!';
                                }

                            } else {
                                $error = true;
                                $mensaje = 'Error, se presento un problama, no pudimos actualizar el pago!';
                            }

                        }

                    } else if($request->estado == 2){
                        $actualizar = array(
                            'tipo' => $request->tipo
                        );
                        if(PagosFacturas::findOrFail($pago_id)->update($actualizar)){
                            $error = false;
                        } else {
                            $error = true;
                            $mensaje = 'Error, se presento un problama, no pudimos actualizar el pago!';
                        }
                    } else if($request->estado == 3){
                        $actualizar = array(
                            'tipo' => $request->tipo,
                            'estado' => $request->estado
                        );
                        if(PagosFacturas::findOrFail($pago_id)->update($actualizar)){
                            $error = false;
                        } else {
                            $error = true;
                            $mensaje = 'Error, se presento un problama, no pudimos actualizar el pago!';
                        }
                    }

                } else if($pago->estado == 3){

                    if($request->estado == 1){

                        $convertido_valor = number_format($pago->valor, 0, ",", ".");
                        if($pago->valor > $factura->saldo){
                            $error = true;
                            $mensaje = "Error, el valor $$convertido_valor es mayor al saldo a pagar de la factura, no es posible realizar el pago!";
                        } else {

                            $actualizar = array(
                                'tipo' => $request->tipo,
                                'estado' => $request->estado
                            );
                            if(PagosFacturas::findOrFail($pago_id)->update($actualizar)){

                                $saldo_viejo = intval($factura->saldo);
                                $nuevo_saldo = $saldo_viejo - $pago->valor;

                                $actualizar = array(
                                    'saldo' => $nuevo_saldo
                                );

                                if($nuevo_saldo == 0){
                                    $actualizar["estado"] = 2;
                                }

                                if(Facturas::findOrFail($factura->id)->update($actualizar)){
                                    $error = false;
                                } else {
                                    $error = true;
                                    $mensaje = 'Error, se presento un problema al actualizar el nuevo saldo de la factura!';
                                }

                            } else {
                                $error = true;
                                $mensaje = 'Error, se presento un problama, no pudimos actualizar el pago!';
                            }

                        }

                    } else if($request->estado == 2){

                        $actualizar = array(
                            'tipo' => $request->tipo,
                            'estado' => $request->estado
                        );
                        if(PagosFacturas::findOrFail($pago_id)->update($actualizar)){
                            $error = false;
                        } else {
                            $error = true;
                            $mensaje = 'Error, se presento un problama, no pudimos actualizar el pago!';
                        }

                    } else if($request->estado == 3){
                        $actualizar = array(
                            'tipo' => $request->tipo
                        );
                        if(PagosFacturas::findOrFail($pago_id)->update($actualizar)){
                            $error = false;
                        } else {
                            $error = true;
                            $mensaje = 'Error, se presento un problama, no pudimos actualizar el pago!';
                        }
                    }

                }

            }

        }

        echo json_encode(array('error' => $error, 'mensaje' => $mensaje));
    }

    public function pagosGet($id)
    {
        $pago = PagosFacturas::findOrFail($id);
        echo json_encode(array('data' => $pago));
    }

    public function download($id)
    {
        //datos
        $factura = Facturas::findOrFail($id);
        $num_factura = substr(str_repeat(0, 5).$factura->id, - 5);

        $pdf = Pdf::loadView('pdf.factura', compact('factura'));
        return $pdf->stream("factura_$num_factura.pdf");
        //return $pdf->download("factura_$num_factura.pdf");
    }

    public function reportes()
    {
        $facturas = Facturas::all();
        $estados = Helper::getDataEstadoFacturas();
        $servicios = Servicios::where('estado', 1)->get();
        $estudiantes = User::where('estado', 1)->whereHas('roles', function ($query) {
            $query->where('name', 'Estudiante');
        })->get();
        $tipos_servicios = TiposServicios::where('estado', 1)->get();
        return view('pages.facturacion.reportes')->with([
            'estados'=> $estados,
            'servicios' => $servicios,
            'usuarios' => $estudiantes,
            'tipos_servicios' => $tipos_servicios,
            'facturas' => $facturas
        ]);
    }

    public $usuario_id, $tipo_servicio, $servicio;
    public function generarReportes(Request $request)
    {
        //dd($request);
        //datos
        $this->usuario_id = $request->usuario;
        $this->tipo_servicio = $request->tipo_servicio;
        $this->servicio = $request->servicio;
        $fecha_i = $request->fecha_desde;
        $fecha_n = $request->fecha_hasta;

        $reporte = Facturas::where('id', '<>', '');

        if($request->factura != null){
            $reporte = $reporte->where('id', $request->factura);
        }

        if($request->usuario != null){
            $reporte = $reporte->whereHas('registroServicio', function($query) {
                $query->where('estudiante_id', '=', $this->usuario_id);
            });
        }

        if($request->tipo_servicio != null){
            $reporte = $reporte->whereHas('registroServicio', function($query) {
                $query->where('tipo_servicio', '=', $this->tipo_servicio);
            });
        }

        if($request->servicio != null){
            $reporte = $reporte->whereHas('registroServicio', function($query) {
                $query->where('servicio', '=', $this->servicio);
            });
        }

        if($request->estado != null){
            $reporte = $reporte->where('estado', $request->estado);
        }

        if($request->fecha_desde != null && $request->fecha_hasta != null){
            $reporte = $reporte->whereBetween(DB::raw('DATE(created_at)'), [$fecha_i, $fecha_n]);
        }

        $reporte = $reporte->get();

        return (new FastExcel($reporte))->download('reporte_facturas_'.date('YmdHms').'.xlsx', function ($data) {
            return [
                "Numero Factura" => '#'.substr(str_repeat(0, 5).$data->id, - 5),
                "Tipo Documento Estudiante" => $data->registroServicio->estudiante->tipo_documento,
                "Numero de Documento Estudiante" => $data->registroServicio->estudiante->numero_documento,
                "Nombres Estudiante" => $data->registroServicio->estudiante->nombres,
                "Tipo de Servicio" => $data->registroServicio->tipo_servicio,
                "Servicio" => $data->registroServicio->servicio,
                "Precio" => '$'.number_format($data->valor, 0, ",", "."),
                "Saldo" => '$'.number_format($data->saldo, 0, ",", "."),
                "Estado" => Helper::getEstadoFacturas($data->estado),
                "Fecha Creación" => date("Y-m-d h:i:s a", strtotime($data->created_at))
            ];
        });
    }

}
