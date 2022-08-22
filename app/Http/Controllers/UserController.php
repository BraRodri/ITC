<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Rap2hpoutre\FastExcel\FastExcel;

class UserController extends Controller
{

    //datos
    public $rol;

    public function index()
    {
        return view('pages.usuarios.index');
    }

    public function all()
    {
        $datos = array();

        $usuarios = User::where('id', '<>', Auth::user()->id)->whereHas('roles', function ($query) {
            $query->where('name', '!=', 'Estudiante');
        })->get();
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
                $botones .= "<a href='".route('usuarios.edit', [$value->id, 1])."' class='btn btn-success btn-sm'>Editar</a>";
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

    public function indexEstudiantes()
    {
        return view('pages.usuarios.estudiantes');
    }

    public function allEstudiantes()
    {
        $datos = array();

        $usuarios = User::where('id', '<>', Auth::user()->id)->whereHas('roles', function ($query) {
            $query->where('name', 'Estudiante');
        })->get();
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
                $botones .= "<a href='".route('usuarios.edit', [$value->id, 2])."' class='btn btn-success btn-sm'>Editar</a>";
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

    public function edit($id, $tipo)
    {
        $usuario = User::findOrFail($id);
        $roles = Role::all();
        $estados = Helper::getDataEstado();
        $tipos_documentos = Helper::getDataTiposDocumentos();
        return view('pages.usuarios.edit')->with([
            'usuario' => $usuario,
            'roles' => $roles,
            'estados' => $estados,
            'tipos_documentos' => $tipos_documentos,
            'tipo' => $tipo
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

    public function reportes()
    {
        $roles = Role::all();
        $estados = Helper::getDataEstado();
        $tipos_documentos = Helper::getDataTiposDocumentos();
        $usuarios = User::all();
        return view('pages.usuarios.reportes')->with([
            'roles' => $roles,
            'estados' => $estados,
            'tipos_documentos' => $tipos_documentos,
            'usuarios' => $usuarios
        ]);
    }

    public function generarReportes(Request $request)
    {
        //dd($request);
        //datos
        $this->rol = $request->rol;
        $fecha_i = $request->fecha_desde;
        $fecha_n = $request->fecha_hasta;

        $usuarios = User::where('id', '<>', '');

        if($request->rol != null){
            $usuarios = $usuarios->whereHas('roles', function ($query) {
                $query->where('name', $this->rol);
            });
        }

        if($request->usuario != null){
            $usuarios = $usuarios->where('id', $request->usuario);
        }

        if($request->tipo_documento != null){
            $usuarios = $usuarios->where('tipo_documento', $request->tipo_documento);
        }

        if($request->estado != null){
            $usuarios = $usuarios->where('estado', $request->estado);
        }

        if($request->fecha_desde != null && $request->fecha_hasta != null){
            $usuarios = $usuarios->whereBetween(DB::raw('DATE(created_at)'), [$fecha_i, $fecha_n]);
        }

        $usuarios = $usuarios->get();

        return (new FastExcel($usuarios))->download('reporte_usuarios_'.date('YmdHms').'.xlsx', function ($user) {
            return [
                "#" => $user->id,
                "Rol" => $user->getRoleNames()[0],
                "Tipo Documento" => $user->tipo_documento,
                "Numero de Documento" => $user->numero_documento,
                "Nombres" => $user->nombres,
                "Correo Electronico" => $user->email,
                "Dirección" => $user->direccion,
                "Celular" => $user->celular,
                "Estado" => Helper::getEstado($user->estado),
                "Fecha Creación" => date("Y-m-d h:i:s a", strtotime($user->created_at))
            ];
        });
    }

    public function identificacion()
    {
        return view('pages.usuarios.identificacion');
    }

    public function getIdentificacion(Request $request)
    {
        $error = false;
        $mensaje = '';
        $data = array();

        $usuario = User::where('numero_documento', 'LIKE', '%'.$request->cedula.'%')->get();
        if(count($usuario) > 0){
            foreach ($usuario as $key => $value) {

                if($value->archivo_cedula){
                    $boton = "<a href='". asset($value->archivo_cedula) ."' target='_blank' class='btn btn-primary btn-sm'>Ver Documento</a>";
                } else {
                    $boton = "<a class='btn btn-danger btn-sm'>No tiene documento</a>";
                }

                $data[] = array(
                    'id' => $value->id,
                    'tipo_documento' => $value->tipo_documento,
                    'numero_documento' => $value->numero_documento,
                    'nombres' => $value->nombres,
                    'estado' => "<span class='badge bg-" . Helper::getColorEstado($value->estado) . "'>" . Helper::getEstado($value->estado) . "</span>",
                    'boton' => $boton
                );

            }
        }

        echo json_encode(array('error' => $error, 'mensaje' => $mensaje, 'data' => $data));
    }

    public function allUsersRoles($rol)
    {
        $usuarios = User::where('estado', 1)->whereHas('roles', function ($query) use ($rol) {
            $query->where('name', $rol);
        })->get();

        echo json_encode([
            'data' => $usuarios,
        ]);
    }

}
