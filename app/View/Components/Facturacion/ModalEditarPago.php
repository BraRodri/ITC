<?php

namespace App\View\Components\Facturacion;

use App\Helper\Helper;
use Illuminate\View\Component;

class ModalEditarPago extends Component
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
        $estados = Helper::getDataEstadoPagos();
        return view('components.facturacion.modal-editar-pago', compact('estados'));
    }
}
