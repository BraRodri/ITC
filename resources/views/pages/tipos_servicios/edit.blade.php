<x-app-layout>

    @section('pagina')Actualizar Tipo de Servicio @endsection

    <div class="container-fluid">

        <div class="mb-4 mt-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
                  <li class="breadcrumb-item"><a href="{{ route('panel') }}">Configuración</a></li>
                  <li class="breadcrumb-item"><a href="{{ route('servicios.tipos.index') }}">Tipos de Servicios</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Actualizar Tipo de Servicio</li>
                </ol>
            </nav>
        </div>

        <!-- Page Heading -->
        <div class="row mb-3">
            <div class="col-lg-12">
                <h1 class="h3 text-gray-800 flex-grow-1">Actualizar Tipo de Servicio</h1>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-gray-600">
                <i class="fas fa-table me-1"></i>
                Actualizar
            </div>
            <div class="card-body">
                <form id="form_editar" class="row g-3 needs-validation" method="POST" novalidate enctype="multipart/form-data">
                    @csrf

                    <div class="col-md-6">
                        <label for="" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $servicio->nombre }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="inputState" class="form-label">Estado</label>
                        <select id="estado" class="form-select" name="estado" required>
                            <option value="" selected>- Seleccione -</option>
                            @if (count($estados) > 0)
                                @foreach ($estados as $key => $value)
                                    @php
                                        $selected = ($servicio->estado == $key) ? 'selected' : '';
                                    @endphp
                                    <option value="{{ $key }}" {{ $selected }}>{{ $value }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <input type="hidden" name="id" id="editar_id" value="{{ $servicio->id }}">

                    <div class="col-12 pt-3">
                        <a href="{{ route('servicios.tipos.index') }}" class="btn btn-dark btn-sm">Regresar</a>
                        <button type="submit" class="btn btn-primary rounded btn-sm">Actualizar Información</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <x-slot name="js">
        <script>

            $('#form_editar').on('submit', function(e) {
                event.preventDefault();
                if ($('#form_editar')[0].checkValidity() === false) {
                    event.stopPropagation();
                } else {

                    var url = route('servicios.tipos.update');

                    //agregar data
                    var $thisForm = $('#form_editar');
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

                            location.href = route('servicios.tipos.index');
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
                $('#form_editar').addClass('was-validated');
            });

        </script>
    </x-slot>

</x-app-layout>
