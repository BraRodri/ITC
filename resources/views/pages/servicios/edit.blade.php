<x-app-layout>

    @section('pagina')Actualizar Servicio @endsection

    <div class="container-fluid">

        <div class="mb-4 mt-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
                  <li class="breadcrumb-item"><a href="{{ route('panel') }}">Configuración</a></li>
                  <li class="breadcrumb-item"><a href="{{ route('servicios.index') }}">Servicios</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Actualizar Servicio</li>
                </ol>
            </nav>
        </div>

        <!-- Page Heading -->
        <div class="row mb-3">
            <div class="col-lg-12">
                <h1 class="h3 text-gray-800 flex-grow-1">Actualizar Servicio</h1>
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
                        <label for="" class="form-label">Nombre del Servicio</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $servicio->nombre }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="" class="form-label">Codigo</label>
                        <input type="text" class="form-control" id="codigo" name="codigo" value="{{ $servicio->codigo }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="" class="form-label">Tipo</label>
                        <select class="form-select" name="tipo_servicio" id="tipo_servicio" required>
                            <option value="">- Seleccione -</option>
                            @if (count($tipos) > 0)
                                @foreach ($tipos as $item)
                                    @php
                                        $selected = ($servicio->tipoServicio->nombre == $item->nombre) ? 'selected' : '';
                                    @endphp
                                    <option value="{{ $item->id }}" {{ $selected }}>{{ $item->nombre }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="inputPassword4" class="form-label">Ciudad</label>
                        <select class="form-select" name="ciudad" id="ciudad" required>
                            <option value="">- Seleccione -</option>
                            <option value="Cúcuta" {{ ($servicio->ciudad == 'Cúcuta') ? 'selected' : '' }}>Cúcuta</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="" class="form-label">Precio</label>
                        <input type="number" class="form-control" id="precio" name="precio" value="{{ $servicio->precio }}" min="1" required>
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
                        <a href="{{ route('servicios.index') }}" class="btn btn-dark btn-sm">Regresar</a>
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

                    var url = route('servicios.update');

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

                            location.href = route('servicios.index');
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
