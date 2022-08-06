<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand align-items-center justify-content-center" href="{{ route('panel') }}">
        <img src="{{ asset('images/logotipo.png') }}" class="img-fluid" width="70%"> <p></p>
        <div class="sidebar-brand-text pt-5">PANEL DE CONTROL</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Inicio -->
    <li class="nav-item {{ ! Route::is('panel') ?: 'active' }}">
        <a class="nav-link" href="{{ route('panel') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Inicio</span>
        </a>
    </li>

    <!-- Usuarios -->
    <li class="nav-item {{ ! Route::is('usuarios.administrativos.index') ?: 'active' }} {{ ! Route::is('usuarios.estudiantes.index') ?: 'active' }}">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUsuarios"
            aria-expanded="true" aria-controls="collapseUsuarios">
            <i class="fa-solid fa-users"></i>
            <span>Gestión de Usuarios</span>
        </a>
        <div id="collapseUsuarios" class="collapse {{ ! Route::is('usuarios.administrativos.index') ?: 'show' }} {{ ! Route::is('usuarios.estudiantes.index') ?: 'show' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Opciones:</h6>
                <a class="collapse-item {{ ! Route::is('usuarios.administrativos.index') ?: 'active' }}" href="{{ route('usuarios.administrativos.index') }}">
                    Administrativos
                </a>
                <a class="collapse-item {{ ! Route::is('usuarios.estudiantes.index') ?: 'active' }}" href="{{ route('usuarios.estudiantes.index') }}">
                    Estudiantes
                </a>
            </div>
        </div>
    </li>

    <!-- Registros -->
    <li class="nav-item {{ ! Route::is('registro.servicios.index') ?: 'active' }}">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseRegistro"
            aria-expanded="true" aria-controls="collapseRegistro">
            <i class="fa-solid fa-book"></i>
            <span>Registro</span>
        </a>
        <div id="collapseRegistro" class="collapse {{ ! Route::is('registro.servicios.index') ?: 'show' }} {{ ! Route::is('servicios.tipos.index') ?: 'show' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Opciones:</h6>
                <a class="collapse-item {{ ! Route::is('registro.servicios.index') ?: 'active' }}" href="{{ route('registro.servicios.index') }}">
                    Servicios
                </a>
            </div>
        </div>
    </li>

    <!-- Registros -->
    <li class="nav-item {{ ! Route::is('facturacion.index') ?: 'active' }}">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseFacturacion"
            aria-expanded="true" aria-controls="collapseFacturacion">
            <i class="fa-solid fa-money-check-dollar"></i>
            <span>Facturación</span>
        </a>
        <div id="collapseFacturacion" class="collapse {{ ! Route::is('facturacion.index') ?: 'show' }} {{ ! Route::is('facturacion.index') ?: 'show' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Opciones:</h6>
                <a class="collapse-item {{ ! Route::is('facturacion.index') ?: 'active' }}" href="{{ route('facturacion.index') }}">
                    Facturas
                </a>
            </div>
        </div>
    </li>

    <!-- Configuración -->
    <li class="nav-item {{ ! Route::is('servicios.index') ?: 'active' }} {{ ! Route::is('servicios.tipos.index') ?: 'active' }}">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fa-solid fa-gear"></i>
            <span>Configuración</span>
        </a>
        <div id="collapseTwo" class="collapse {{ ! Route::is('servicios.index') ?: 'show' }} {{ ! Route::is('servicios.tipos.index') ?: 'show' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Opciones:</h6>
                <a class="collapse-item {{ ! Route::is('servicios.index') ?: 'active' }}" href="{{ route('servicios.index') }}">
                    Servicios
                </a>
                <a class="collapse-item {{ ! Route::is('servicios.tipos.index') ?: 'active' }}" href="{{ route('servicios.tipos.index') }}">
                    Tipos de Servicios
                </a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
