<?php

namespace App\Http\Controllers;

use App\Models\PagosPrestacionServicios;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use NumberFormatter;
use Spatie\Permission\Models\Role;

class PagosPrestacionServiciosController extends Controller
{

    public function index()
    {
        return view('pages.prestacion_servicios.index');
    }

    public function guardar(Request $request)
    {
        $error = false;
        $mensaje = '';

        $usuario = User::find($request->usuario);
        if($usuario){

            $formatterES = new NumberFormatter("es", NumberFormatter::SPELLOUT);
            $valor_texto = $formatterES->format($request->valor);

            $data = array(
                'usuario_id' => $usuario->id,
                'fecha_emision' => $request->fecha_emision,
                'nombre_usuario' => $usuario->nombres,
                'numero_documento_usuario' => $usuario->numero_documento,
                'domicilio_usuario' => $usuario->direccion,
                'valor' => $request->valor,
                'valor_texto' => $valor_texto,
                'conceptos' => $request->conceptos,
                'observaciones' => $request->observaciones,
            );

            if(PagosPrestacionServicios::create($data)){
                $error = false;
            } else {
                $error = true;
                $mensaje = 'Error, se presento un problema al registrar el pago!';
            }

        } else {
            $error = true;
            $mensaje = 'Error, no pudimos encontrar el usuario seleccionado, intenta de nuevo!';
        }

        echo json_encode(array('error' => $error, 'mensaje' => $mensaje));
    }

    public function all()
    {
        $datos = array();

        $data = PagosPrestacionServicios::all();
        if(count($data) > 0){
            foreach ($data as $key => $value) {

                $botones = '';
                $botones .= '<div class="btn-group" role="group">';
                $botones .= "<a href='".route('prestacion.servicios.edit', $value->id)."' class='btn btn-success btn-sm'>Editar</a>";
                $botones .= "<button class='btn btn-danger btn-sm' onclick='eliminar(".$value->id.");'>Eliminar</button>";
                $botones .= "<a href='".route('prestacion.servicios.imprimir', $value->id)."' target='_blank' class='btn btn-dark btn-sm'>Imprimir</a>";
                $botones .= '</div>';

                $datos[] = array(
                    $value->id,
                    $value->numero_documento_usuario,
                    $value->nombre_usuario,
                    $value->fecha_emision,
                    '$'.number_format($value->valor, 0, ",", "."),
                    $botones
                );

            }
        }

        echo json_encode([
            'data' => $datos,
        ]);
    }

    public function delete($id)
    {
        $error = false;
        $mensaje = '';

        if(PagosPrestacionServicios::findOrFail($id)->delete()){
            $error = false;
        } else {
            $error = true;
            $mensaje = 'Error! Se presento un problema al eliminar el registro, intenta de nuevo.';
        }

        echo json_encode(array('error' => $error, 'mensaje' => $mensaje));
    }

    public function edit($id)
    {
        $roles = Role::all();
        $pago = PagosPrestacionServicios::findOrFail($id);
        $usuario = User::findOrFail($pago->usuario_id);
        $rol = $usuario->getRoleNames()[0];
        $usuarios = User::where('estado', 1)->whereHas('roles', function ($query) use ($rol) {
            $query->where('name', $rol);
        })->get();
        return view('pages.prestacion_servicios.edit')->with([
            'roles' => $roles,
            'pago' => $pago,
            'usuario' => $usuario,
            'usuarios' => $usuarios
        ]);
    }

    public function update(Request $request)
    {
        $error = false;
        $mensaje = '';

        $usuario = User::find($request->usuario);
        if($usuario){

            $formatterES = new NumberFormatter("es", NumberFormatter::SPELLOUT);
            $valor_texto = $formatterES->format($request->valor);

            $data = array(
                'usuario_id' => $usuario->id,
                'fecha_emision' => $request->fecha_emision,
                'nombre_usuario' => $usuario->nombres,
                'numero_documento_usuario' => $usuario->numero_documento,
                'domicilio_usuario' => $request->direccion,
                'valor' => $request->valor,
                'valor_texto' => $valor_texto,
                'conceptos' => $request->conceptos,
                'observaciones' => $request->observaciones,
            );

            if(PagosPrestacionServicios::findOrFail($request->id)->update($data)){
                $error = false;
            } else {
                $error = true;
                $mensaje = 'Error, se presento un problema al actualizar el registro!';
            }

        } else {
            $error = true;
            $mensaje = 'Error, no pudimos encontrar el usuario seleccionado, intenta de nuevo!';
        }

        echo json_encode(array('error' => $error, 'mensaje' => $mensaje));
    }

    public function imprimir($id)
    {
        $pago = PagosPrestacionServicios::findOrFail($id);
        $pdf = Pdf::loadView('pdf.prestacion_servicios', compact('pago'));
        return $pdf->stream("prestacion_servicios_JA_$pago->id.pdf");
    }

}
