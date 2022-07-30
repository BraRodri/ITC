<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function index()
    {
        return view('pages.usuarios.index');
    }

    public function all()
    {
        $datos = array();

        $usuarios = User::where('id', '<>', Auth::user()->id)->get();
        if(count($usuarios) > 0){
            foreach ($usuarios as $key => $value) {

                $botones = '';
                // if(Auth::user()->can('editar_usuario')){
                //     $botones .= "<button class='btn btn-success' onclick='editarUsuario(".$value->id.");'>Editar</button>";
                // }
                // if(Auth::user()->can('eliminar_usuario')){
                //     $botones .= "<button class='btn btn-danger' onclick='eliminarUsuario(".$value->id.");'>Eliminar</button>";
                // }

                $botones .= '<div class="btn-group" role="group">';
                $botones .= "<a href='".route('usuarios.edit', $value->id)."' class='btn btn-success btn-sm'>Editar</a>";
                $botones .= "<button class='btn btn-danger btn-sm' onclick='eliminarUsuario(".$value->id.");'>Eliminar</button>";
                $botones .= '</div>';

                $datos[] = array(
                    $value->id,
                    $value->numero_documento,
                    $value->nombres,
                    $value->email,
                    $value->getRoleNames(),
                    "<span class='badge bg-" . Helper::getColorEstado($value->estado) . "'>" . Helper::getEstado($value->estado) . "</span>",
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

        $validar = User::where('email', $request->email)->get();
        if(count($validar) > 0){
            $error = true;
            $mensaje = 'Error! Ya existe un usuario con el correo electronico registrado, intente con otro.';
        } else {

            $validar_2 = User::where('numero_documento', $request->numero_documento)->get();
            if(count($validar_2) > 0){
                $error = true;
                $mensaje = 'Error! Ya existe un usuario con el numero documento registrado, intente con otro.';
            } else {

                $registro = array(
                    'tipo_documento' => $request->tipo_documento,
                    'numero_documento' => $request->numero_documento,
                    'nombres' => $request->nombres,
                    'direccion' => $request->direccion,
                    'celular' => $request->celular,
                    'email' => $request->email,
                    'estado' => $request->estado,
                    'archivo_cedula'
                );

                if($request->password){
                    $registro["password"] = Hash::make($request->password);
                }

                if ($request->file('archivo')) {
                    $archivo = $request->file('archivo')->store('public/documentos');
                    $registro["archivo_cedula"] = Storage::url($archivo);
                }

                if($result = User::create($registro)->assignRole($request->rol)){
                    $error = false;
                } else {
                    $error = true;
                    $mensaje = 'Error! Se presento un problema al registrar al usuario, intenta de nuevo.';
                }

            }

        }

        echo json_encode(array('error' => $error, 'mensaje' => $mensaje));
    }

    public function delete($id)
    {
        $error = false;
        $mensaje = '';

        if(User::findOrFail($id)->delete()){
            $error = false;
        } else {
            $error = true;
            $mensaje = 'Error! Se presento un problema al eliminar al usuario, intenta de nuevo.';
        }

        echo json_encode(array('error' => $error, 'mensaje' => $mensaje));
    }

    public function get($id)
    {
        $error = false;
        $mensaje = '';
        $info = null;

        $data = User::findOrFail($id);
        if(!$data){
            $error = true;
            $mensaje = 'Error! No es posible traer la información del usuario!';
        } else {

            $info = array(
                'id' => $data->id,
                'nombres' => $data->nombres,
                'tipo_documento' => $data->tipo_documento,
                'numero_documento' => $data->numero_documento,
                'email' => $data->email,
                'direccion' => $data->direccion,
                'celular' => $data->celular,
                'estado' => $data->estado,
                'rol' => $data->getRoleNames(),
                'archivo' => asset($data->archivo_cedula)
            );
        }

        echo json_encode(array('error' => $error, 'mensaje' => $mensaje, 'data' => $info));
    }

    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        $roles = Role::all();
        $estados = Helper::getDataEstado();
        $tipos_documentos = Helper::getDataTiposDocumentos();
        return view('pages.usuarios.edit')->with([
            'usuario' => $usuario,
            'roles' => $roles,
            'estados' => $estados,
            'tipos_documentos' => $tipos_documentos
        ]);
    }

    public function update(Request $request)
    {
        $error = false;
        $mensaje = '';

        $id_usuario = $request->id;

        $validar = User::where('email', $request->email)->where('id', '<>', $id_usuario)->get();
        if(count($validar) > 0){
            $error = true;
            $mensaje = 'Error! Ya existe un usuario con el correo electronico registrado, intente con otro.';
        } else {

            $validar_2 = User::where('numero_documento', $request->numero_documento)->where('id', '<>', $id_usuario)->get();
            if(count($validar_2) > 0){
                $error = true;
                $mensaje = 'Error! Ya existe un usuario con el numero documento registrado, intente con otro.';
            } else {

                $actualizar = array(
                    'tipo_documento' => $request->tipo_documento,
                    'numero_documento' => $request->numero_documento,
                    'nombres' => $request->nombres,
                    'direccion' => $request->direccion,
                    'celular' => $request->celular,
                    'email' => $request->email,
                    'estado' => $request->estado,
                    'archivo_cedula'
                );

                if($request->password){
                    $actualizar["password"] = Hash::make($request->password);
                }

                if ($request->file('archivo')) {
                    $archivo = $request->file('archivo')->store('public/documentos');
                    $actualizar["archivo_cedula"] = Storage::url($archivo);
                }

                if($result = User::findOrFail($id_usuario)->update($actualizar)){

                    //asignar rol nuevo
                    $usuario_nuevo = User::findOrFail($id_usuario);
                    $usuario_nuevo->syncRoles([$request->rol]);
                    $error = false;

                } else {
                    $error = true;
                    $mensaje = 'Error! Se presento un problema al registrar al usuario, intenta de nuevo.';
                }

            }

        }

        echo json_encode(array('error' => $error, 'mensaje' => $mensaje));
    }

}
