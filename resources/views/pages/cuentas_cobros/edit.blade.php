<x-app-layout>

    @section('pagina')Actualizar Servicio @endsection

    <div class="container-fluid">

        <div class="mb-4 mt-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
                  <li class="breadcrumb-item"><a href="{{ route('panel') }}">Facturación</a></li>
                  <li class="breadcrumb-item"><a href="{{ route('cuentas.cobros.index') }}">Pagos Cuentas Cobros</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Actualizar Registro</li>
                </ol>
            </nav>
        </div>

        <!-- Page Heading -->
        <div class="row mb-3">
            <div class="col-lg-12">
                <h1 class="h3 text-gray-800 flex-grow-1">Actualizar Registro</h1>
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

                    <div class="col-md-4">
                        <label for="" class="form-label">Tipo de Usuario</label>
                        <select class="form-select" name="tipo_usuario" id="tipo_usuario" required>
                            <option value="">- Seleccione -</option>
                            @if (count($roles) > 0)
                                @foreach ($roles as $item)
                                    @php
                                        $select = ($item->name == $usuario->getRoleNames()[0]) ? 'selected' : '';
                                    @endphp
                                    <option value="{{ $item->name }}" {{ $select }}>{{ $item->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="col-md-8">
                        <label for="" class="form-label">Usuario</label>
                        <select class="form-select" name="usuario" id="usuario" style="width: 100%" required>
                            <option value="">- Seleccione -</option>
                            @if (count($usuarios) > 0)
                                @foreach ($usuarios as $item)
                                    @php
                                        $select = ($item->id == $usuario->id) ? 'selected' : '';
                                    @endphp
                                    <option value="{{ $item->id }}" {{ $select }}>{{ $item->numero_documento }} - {{ $item->nombres }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="" class="form-label">N° Cuenta Cobro</label>
                        <input type="text" class="form-control" name="numero_cuenta" id="numero_cuenta" value="{{ $pago->numero_cuenta_cobro }}" required>
                    </div>

                    <div class="col-md-4">
                        <label for="" class="form-label">Fecha Inicio</label>
                        <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" value="{{ $pago->fecha_inicio }}" required>
                    </div>

                    <div class="col-md-4">
                        <label for="" class="form-label">Fecha Terminación</label>
                        <input type="date" class="form-control" name="fecha_terminacion" id="fecha_terminacion" value="{{ $pago->fecha_terminacion }}" required>
                    </div>

                    <div class="col-md-12">
                        <label for="" class="form-label">Valor</label>
                        <input type="number" class="form-control" name="valor" id="valor" min="1" value="{{ $pago->valor }}" required>
                    </div>

                    <div class="col-md-12">
                        <label for="" class="form-label">Por concepto de</label>
                        <textarea class="form-control" name="conceptos" id="conceptos" rows="4" required>{{ $pago->conceptos }}</textarea>
                    </div>

                    <input type="hidden" name="id" id="editar_id" value="{{ $pago->id }}">

                    <div class="col-12 pt-3">
                        <a href="{{ route('cuentas.cobros.index') }}" class="btn btn-dark btn-sm">Regresar</a>
                        <button type="submit" class="btn btn-primary rounded btn-sm">Actualizar Información</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <x-slot name="js">
        <script>

            $('#usuario').select2({
                minimumInputLength: 4,
                allowClear: true,
            });

            $('#tipo_usuario').on('change', function(){
                var dato = this.value;
                if(dato !== ''){

                    $('#usuario option').remove();

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                        },
                        type: "GET",
                        encoding:"UTF-8",
                        url: route('usuarios.all.roles', dato),
                        dataType:'json',
                        beforeSend:function(){
                            //mensaje de alerta
                            let timerInterval;
                            Swal.fire({
                                title: "Cargando",
                                text: "Procesando la información, espere...",
                                timerProgressBar: true,
                                didOpen: () => {
                                    Swal.showLoading();
                                },
                            });
                        }
                    }).done(function(respuesta){

                        $('#usuario').append(new Option('- Seleccione -', ''));

                        if(respuesta.data.length > 0){
                            respuesta.data.forEach(element => {
                                $('#usuario').append(new Option(element.numero_documento + ' - ' + element.nombres, element.id));
                            });
                        }

                        Swal.fire({
                            text: "Información Cargada",
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500
                        });

                    }).fail(function(resp){
                        console.log(resp);
                        Swal.fire({
                            title: "Se presento un error!",
                            text: 'Intenta otra vez, si persiste el error, comunicate con el area encargada, gracias.',
                            icon: 'error',
                        });
                    });
                }
            });

            $('#form_editar').on('submit', function(e) {
                event.preventDefault();
                if ($('#form_editar')[0].checkValidity() === false) {
                    event.stopPropagation();
                } else {

                    var url = route('cuentas.cobros.update');

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

                            location.href = route('cuentas.cobros.index');
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
