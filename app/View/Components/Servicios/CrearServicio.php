<?php

namespace App\View\Components\Servicios;

use App\Helper\Helper;
use App\Models\TiposServicios;
use Illuminate\View\Component;

class CrearServicio extends Component
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
        $estados = Helper::getDataEstadoNormales();
        $tipos = TiposServicios::where('estado', 1)->get();
        return view('components.servicios.crear-servicio', compact('estados', 'tipos'));
    }
}
