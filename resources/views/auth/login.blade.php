<x-login-layout>

    <!-- title -->
    @section('pagina')Login @endsection

    <div class="row no-gutter">
        <!-- The image half -->
        <div class="col-md-6 d-none d-md-flex bg-image"></div>


        <!-- The content half -->
        <div class="col-md-6 bg-light">
            <div class="login d-flex align-items-center py-5">

                <!-- Demo content-->
                <div class="container">
                    <div class="row">
                        <div class="col-lg-10 col-xl-7 mx-auto">
                            <h3 class="display-4">ITC</h3>
                            <p class="text-muted mb-4">
                                Instituto Técnico de Colombia <br>
                                Auxiliar de Enfermeria
                            </p>
                            <form id="formulario_login" class="needs-validation" method="POST" novalidate>
                                @csrf
                                <div class="form-group mb-3">
                                    <input id="email" name="email" type="email" placeholder="Correo Electronico" required="" autofocus="" class="form-control rounded-pill border-0 shadow-sm px-4">
                                </div>
                                <div class="form-group mb-3">
                                    <input id="password" name="password" type="password" placeholder="Contraseña" required="" class="form-control rounded-pill border-0 shadow-sm px-4 text-primary">
                                </div>
                                <div class="custom-control custom-checkbox mb-3">
                                    <input id="customCheck1" type="checkbox" checked class="custom-control-input">
                                    <label for="customCheck1" class="custom-control-label">Recordar contraseña</label>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block mb-2 rounded-pill shadow-sm">Iniciar Sesión</button>
                                <div class="text-center d-flex justify-content-between mt-4">
                                    <p>
                                        Desarrollado por <a href="#" class="font-italic text-muted">
                                        <u>Desarrolladores</u></a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!-- End -->

            </div>
        </div><!-- End -->

    </div>

</x-login-layout>
