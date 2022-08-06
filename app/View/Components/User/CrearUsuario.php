<?php

namespace App\View\Components\User;

use App\Helper\Helper;
use Illuminate\View\Component;
use Spatie\Permission\Models\Role;

class CrearUsuario extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $tipo;
    public function __construct($tipo)
    {
        $this->tipo = $tipo;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        if($this->tipo == 1){
            $roles = Role::where('name', '!=', 'Estudiante')->get();
        } else {
            $roles = Role::where('name', '=', 'Estudiante')->get();
        }
        $tipo = $this->tipo;
        $estados = Helper::getDataEstado();
        $tipos_documentos = Helper::getDataTiposDocumentos();
        return view('components.user.crear-usuario', compact('roles', 'estados', 'tipos_documentos', 'tipo'));
    }
}
