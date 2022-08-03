<?php

namespace App\View\Components\Registro;

use App\Helper\Helper;
use App\Models\Servicios;
use App\Models\User;
use Illuminate\View\Component;

class RegistrarServicios extends Component
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
        $estados = Helper::getDataEstadoServicios();
        $servicios = Servicios::where('estado', 1)->get();
        $estudiantes = User::where('estado', 1)->whereHas('roles', function ($query) {
            $query->where('name', 'Estudiante');
        })->get();
        return view('components.registro.registrar-servicios', compact('estados', 'servicios', 'estudiantes'));
    }
}
