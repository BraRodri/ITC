<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\Servicios;
use App\Models\TiposServicios;
use Illuminate\Http\Request;

class ServicioController extends Controller
{

    public function index()
    {
        return view('pages.servicios.index');
    }

    public function all()
    {
        $datos = array();

        $data = Servicios::all();
        if(count($data) > 0){
            foreach ($data as $key => $value) {

                $botones = '';
                $botones .= '<div class="btn-group" role="group">';
                $botones .= "<a href='".route('servicios.edit', $value->id)."' class='btn btn-success btn-sm'>Editar</a>";
                $botones .= "<button class='btn btn-danger btn-sm' onclick='eliminarUsuario(".$value->id.");'>Eliminar</button>";
                $botones .= '</div>';

                $datos[] = array(
                    $value->id,
                    $value->codigo,
                    $value->nombre,
                    $value->tipoServicio->nombre,
                    '$'.number_format($value->precio, 0, ",", "."),
                    $value->ciudad,
                    "<span class='badge bg-" . Helper::getColorEstadoNormal($value->estado) . "'>" . Helper::getEstadoNormal($value->estado) . "</span>",
                    $botones
                );

            }
        }

        echo json_encode([
            'data' => $datos,
        ]);
    }

    public function create(Request $request)
    {
        $error = false;
        $mensaje = '';

        $validar = Servicios::where('codigo', $request->codigo)->get();
        if(count($validar) > 0){
            $error = true;
            $mensaje = 'Error! Ya existe un servicio con el CODIGO registrado, intente con otro.';
        } else {

            $validar_2 = Servicios::where('nombre', $request->nombre)->get();
            if(count($validar_2) > 0){
                $error = true;
                $mensaje = 'Error! Ya existe un servicio con el nombre registrado, intente con otro.';
            } else {

                $registro = array(
                    'codigo' => $request->codigo,
                    'nombre' => $request->nombre,
                    'tipo_servicio_id' => $request->tipo_servicio,
                    'ciudad' => $request->ciudad,
                    'precio' => $request->precio,
                    'estado' => $request->estado
                );

                if($result = Servicios::create($registro)){
                    $error = false;
                } else {
                    $error = true;
                    $mensaje = 'Error! Se presento un problema al crear el servicio, intenta de nuevo.';
                }

            }

        }

        echo json_encode(array('error' => $error, 'mensaje' => $mensaje));
    }

    public function delete($id)
    {
        $error = false;
        $mensaje = '';

        if(Servicios::findOrFail($id)->delete()){
            $error = false;
        } else {
            $error = true;
            $mensaje = 'Error! Se presento un problema al eliminar el servicio, intenta de nuevo.';
        }

        echo json_encode(array('error' => $error, 'mensaje' => $mensaje));
    }

    public function edit($id)
    {
        $servicio = Servicios::findOrFail($id);
        $estados = Helper::getDataEstadoNormales();
        $tipos = TiposServicios::where('estado', 1)->get();
        return view('pages.servicios.edit')->with([
            'servicio' => $servicio,
            'estados' => $estados,
            'tipos' => $tipos
        ]);
    }

    public function update(Request $request)
    {
        $error = false;
        $mensaje = '';

        $id = $request->id;

        $validar = Servicios::where('codigo', $request->codigo)->where('id', '<>', $id)->get();
        if(count($validar) > 0){
            $error = true;
            $mensaje = 'Error! Ya existe un servicio con el CODIGO registrado, intente con otro.';
        } else {

            $validar_2 = Servicios::where('nombre', $request->nombre)->where('id', '<>', $id)->get();
            if(count($validar_2) > 0){
                $error = true;
                $mensaje = 'Error! Ya existe un servicio con el nombre registrado, intente con otro.';
            } else {

                $actualizacion = array(
                    'codigo' => $request->codigo,
                    'nombre' => $request->nombre,
                    'tipo_servicio_id' => $request->tipo_servicio,
                    'ciudad' => $request->ciudad,
                    'precio' => $request->precio,
                    'estado' => $request->estado
                );

                if($result = Servicios::findOrFail($id)->update($actualizacion)){
                    $error = false;
                } else {
                    $error = true;
                    $mensaje = 'Error! Se presento un problema al actualizar el servicio, intenta de nuevo.';
                }

            }

        }

        echo json_encode(array('error' => $error, 'mensaje' => $mensaje));
    }

    public function indexTipos()
    {
        return view('pages.tipos_servicios.index');
    }

    public function allTipos()
    {
        $datos = array();

        $data = TiposServicios::all();
        if(count($data) > 0){
            foreach ($data as $key => $value) {

                $botones = '';
                $botones .= '<div class="btn-group" role="group">';
                $botones .= "<a href='".route('servicios.tipos.edit', $value->id)."' class='btn btn-success btn-sm'>Editar</a>";
                $botones .= "<button class='btn btn-danger btn-sm' onclick='eliminarUsuario(".$value->id.");'>Eliminar</button>";
                $botones .= '</div>';

                $datos[] = array(
                    $value->id,
                    $value->nombre,
                    "<span class='badge bg-" . Helper::getColorEstadoNormal($value->estado) . "'>" . Helper::getEstadoNormal($value->estado) . "</span>",
                    $botones
                );

            }
        }

        echo json_encode([
            'data' => $datos,
        ]);
    }

    public function createTipos(Request $request)
    {
        $error = false;
        $mensaje = '';

        $validar_2 = TiposServicios::where('nombre', $request->nombre)->get();
        if(count($validar_2) > 0){
            $error = true;
            $mensaje = 'Error! Ya existe un tipo de servicio con el nombre registrado, intente con otro.';
        } else {

            $registro = array(
                'nombre' => $request->nombre,
                'estado' => $request->estado
            );

            if($result = TiposServicios::create($registro)){
                $error = false;
            } else {
                $error = true;
                $mensaje = 'Error! Se presento un problema al crear el tipo de servicio, intenta de nuevo.';
            }

        }

        echo json_encode(array('error' => $error, 'mensaje' => $mensaje));
    }

    public function deleteTipos($id)
    {
        $error = false;
        $mensaje = '';

        if(TiposServicios::findOrFail($id)->delete()){
            $error = false;
        } else {
            $error = true;
            $mensaje = 'Error! Se presento un problema al eliminar el tipo de servicio, intenta de nuevo.';
        }

        echo json_encode(array('error' => $error, 'mensaje' => $mensaje));
    }

    public function editTipos($id)
    {
        $servicio = TiposServicios::findOrFail($id);
        $estados = Helper::getDataEstadoNormales();
        return view('pages.tipos_servicios.edit')->with([
            'servicio' => $servicio,
            'estados' => $estados
        ]);
    }

    public function updateTipos(Request $request)
    {
        $error = false;
        $mensaje = '';

        $id = $request->id;

        $validar_2 = TiposServicios::where('nombre', $request->nombre)->where('id', '<>', $id)->get();
        if(count($validar_2) > 0){
            $error = true;
            $mensaje = 'Error! Ya existe un tipo de servicio con el nombre registrado, intente con otro.';
        } else {

            $actualizacion = array(
                'nombre' => $request->nombre,
                'estado' => $request->estado
            );

            if($result = TiposServicios::findOrFail($id)->update($actualizacion)){
                $error = false;
            } else {
                $error = true;
                $mensaje = 'Error! Se presento un problema al actualizar el tipo de servicio, intenta de nuevo.';
            }

        }

        echo json_encode(array('error' => $error, 'mensaje' => $mensaje));
    }

}
