<?php

namespace App\View\Components\CuentasCobros;

use Illuminate\View\Component;
use Spatie\Permission\Models\Role;

class CrearCuentaCobro extends Component
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
        return view('components.cuentas-cobros.crear-cuenta-cobro')->with([
            'roles' => $roles
        ]);
    }
}
