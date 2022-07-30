<?php

namespace App\View\Components\TipoServicios;

use App\Helper\Helper;
use Illuminate\View\Component;

class CrearTipoServicios extends Component
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
        return view('components.tipo-servicios.crear-tipo-servicios', compact('estados'));
    }
}
