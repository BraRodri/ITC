<?php

namespace App\View\Components\User;

use App\Helper\Helper;
use Illuminate\View\Component;
use Spatie\Permission\Models\Role;

class EditarUsuario extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $roles = Role::all();
        $estados = Helper::getDataEstado();
        $tipos_documentos = Helper::getDataTiposDocumentos();
        return view('components.user.editar-usuario', compact('roles', 'estados', 'tipos_documentos'));
    }
}
