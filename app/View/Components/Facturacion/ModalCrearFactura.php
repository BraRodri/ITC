<?php

namespace App\View\Components\Facturacion;

use App\Helper\Helper;
use Illuminate\View\Component;

class ModalCrearFactura extends Component
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
        $estados = Helper::getDataEstadoFacturas();
        return view('components.facturacion.modal-crear-factura', compact('estados'));
    }
}
