<x-app-layout>

    @section('pagina')Actualizar Usuario @endsection

    <div class="container-fluid">

        <div class="mb-4 mt-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
                  <li class="breadcrumb-item"><a href="{{ route('usuarios.index') }}">Usuarios</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Actualizar Usuario</li>
                </ol>
            </nav>
        </div>

        <!-- Page Heading -->
        <div class="row mb-3">
            <div class="col-lg-12">
                <h1 class="h3 text-gray-800 flex-grow-1">Actualizar Usuario</h1>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-gray-600">
                <i class="fas fa-table me-1"></i>
                Actualizar
            </div>
            <div class="card-body">
                <form id="form_editar_usuario" class="row g-3 needs-validation" method="POST" novalidate enctype="multipart/form-data">
                    @csrf

                    <div class="col-md-12">
                        <label for="inputState" class="form-label">Primero, por favor selecciona un rol:</label>
                        <select id="editar_rol" class="form-select" name="rol" required>
                            <option value="" selected>- Seleccione -</option>
                            @if (count($roles) > 0)
                                @foreach ($roles as $item)
                                    @php
                                        $roles = $usuario->getRoleNames();
                                        $selected = ($roles[0] == $item->name) ? 'selected' : '';
                                    @endphp
                                    <option value="{{ $item->name }}" {{ $selected }}>{{ $item->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="" class="form-label">Tipo de Documento</label>
                        <select id="editar_tipo_documento" class="form-select" name="tipo_documento" required>
                            <option value="" selected>- Seleccione -</option>
                            @if (count($tipos_documentos) > 0)
                                @foreach ($tipos_documentos as $key => $value)
                                    @php
                                        $selected = ($usuario->tipo_documento == $value) ? 'selected' : '';
                                    @endphp
                                    <option value="{{ $value }}" {{ $selected }}>{{ $value }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="" class="form-label">Numero de Documento</label>
                        <input type="text" class="form-control" id="editar_numero_documento" name="numero_documento" value="{{ $usuario->numero_documento }}" autocomplete="off" required>
                    </div>
                    <div class="col-md-6">
                        <label for="" class="form-label">Nombres</label>
                        <input type="text" class="form-control" id="editar_nombres" name="nombres" value="{{ $usuario->nombres }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="editar_direccion" name="direccion" value="{{ $usuario->direccion }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editar_email" name="email" value="{{ $usuario->email }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="inputPassword4" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="passsword" autocomplete="off">
                    </div>
                    <div class="col-md-6">
                        <label for="inputPassword4" class="form-label">Telefono/Celular</label>
                        <input type="text" class="form-control" id="editar_celular" name="celular" value="{{ $usuario->celular }}" autocomplete="off" required>
                    </div>
                    <div class="col-md-6">
                        <label for="inputState" class="form-label">Estado</label>
                        <select id="editar_estado" class="form-select" name="estado" required>
                            <option value="" selected>- Seleccione -</option>
                            @if (count($estados) > 0)
                                @foreach ($estados as $key => $value)
                                    @php
                                        $selected = ($usuario->estado == $key) ? 'selected' : '';
                                    @endphp
                                    <option value="{{ $key }}" {{ $selected }}>{{ $value }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="inputPassword4" class="form-label">(No es obligatorio en la actualización). Por ultimo, por favor sube una copia del documento de identidad</label>
                        <input type="file" class="form-control" id="archivo" name="archivo" accept=".pdf">

                        <label class="mt-2"><strong>Importante:</strong> El usuario ya cuenta con una copia de su documento.</label>
                        <a href="{{ asset($usuario->archivo_cedula) }}" id="editar_ver_documento" target="_blank">Ver documento cargado</a>
                    </div>

                    <input type="hidden" name="id" id="editar_id" value="{{ $usuario->id }}">

                    <div class="col-12 pt-3">
                        <a href="{{ route('usuarios.index') }}" class="btn btn-dark btn-sm">Regresar</a>
                        <button type="submit" class="btn btn-primary rounded btn-sm">Actualizar Usuario</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <x-slot name="js">
        <script>

            $('#form_editar_usuario').on('submit', function(e) {
                event.preventDefault();
                if ($('#form_editar_usuario')[0].checkValidity() === false) {
                    event.stopPropagation();
                } else {

                    var url = route('usuarios.update');

                    //agregar data
                    var $thisForm = $('#form_editar_usuario');
                    var formData = new FormData(this);

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        type: "POST",
                        encoding:"UTF-8",
                        url: url,
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType:'json',
                        beforeSend:function(){
                            let timerInterval;
                            Swal.fire({
                                title: "Espera!",
                                text: "Actualizando la información...",
                                timerProgressBar: true,
                                didOpen: () => {
                                    Swal.showLoading();
                                },
                            });
                        }
                    }).done(function(respuesta){
                        //console.log(respuesta);
                        if (!respuesta.error) {
                            Swal.fire({
                                text: "Información Actualizada",
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 3000
                            });

                            location.href = route('usuarios.index');
                        } else {
                            setTimeout(function(){
                                Swal.fire({
                                    title: "Se presento un error!",
                                    html: respuesta.mensaje,
                                    icon: 'error',
                                });
                            },2000);
                        }
                    }).fail(function(resp){
                        console.log(resp);
                        Swal.fire({
                            title: "Se presento un error!",
                            text: 'Intenta otra vez, si persiste el error, comunicate con el area encargada, gracias.',
                            icon: 'error',
                        });
                    });

                }
                $('#form_editar_usuario').addClass('was-validated');
            });

        </script>
    </x-slot>

</x-app-layout>
