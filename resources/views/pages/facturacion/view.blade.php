<x-app-layout>

    @section('pagina')Ver Factura #{{ substr(str_repeat(0, 5).$factura->id, - 5) }} @endsection

    <div class="container-fluid">

        <div class="mb-4 mt-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
                  <li class="breadcrumb-item"><a href="{{ route('facturacion.index') }}">Facturas</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Factura #{{ substr(str_repeat(0, 5).$factura->id, - 5) }}</li>
                </ol>
            </nav>
        </div>

        <!-- Page Heading -->
        <div class="row mb-3">
            <div class="col-lg-6 col-12">
                <h1 class="h3 text-gray-800 flex-grow-1">Factura #{{ substr(str_repeat(0, 5).$factura->id, - 5) }}</h1>
            </div>
            <div class="col-lg-6 col-12 text-end">
                <a href="{{ route('facturacion.download', $factura->id) }}" target="_blank" class="btn btn-primary btn-sm"><i class="fa-solid fa-download"></i> Descargar</a>
            </div>

            <div class="col-lg-6 col-12">
                <div class="card mt-4">
                    <div class="card-header bg-gray-600">
                        <i class="fas fa-table me-1"></i>
                        Información Principal
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-condensed">
                            <tbody>
                                <tr>
                                    <td width="40%" class="bg-gray-600 font-weight-bold">N° Factura</td>
                                    <td width="60%">{{ substr(str_repeat(0, 5).$factura->id, - 5) }}</td>
                                </tr>
                                <tr>
                                    <td width="40%" class="bg-gray-600 font-weight-bold">Fecha</td>
                                    <td width="60%">{{ $factura->fecha }}</td>
                                </tr>
                                <tr>
                                    <td width="40%" class="bg-gray-600 font-weight-bold">Tipo Servicio</td>
                                    <td width="60%">{{ $factura->registroServicio->tipo_servicio }}</td>
                                </tr>
                                <tr>
                                    <td width="40%" class="bg-gray-600 font-weight-bold">Servicio</td>
                                    <td width="60%">{{ $factura->registroServicio->servicio }}</td>
                                </tr>
                                <tr>
                                    <td width="40%" class="bg-gray-600 font-weight-bold">Estado</td>
                                    <td width="60%"><span class='badge bg-{{ App\Helper\Helper::getColorEstadoFacturas($factura->estado) }}'>{{ App\Helper\Helper::getEstadoFacturas($factura->estado) }}</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-12">
                <div class="card mt-4">
                    <div class="card-header bg-gray-600">
                        <i class="fas fa-table me-1"></i>
                        Información del Estudiante
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-condensed">
                            <tbody>
                                <tr>
                                    <td width="40%" class="bg-gray-600 font-weight-bold">Nombres</td>
                                    <td width="60%">{{ $factura->registroServicio->estudiante->nombres }}</td>
                                </tr>
                                <tr>
                                    <td width="40%" class="bg-gray-600 font-weight-bold">Tipo Documento</td>
                                    <td width="60%">{{ $factura->registroServicio->estudiante->tipo_documento }}</td>
                                </tr>
                                <tr>
                                    <td width="40%" class="bg-gray-600 font-weight-bold">Numero Documento</td>
                                    <td width="60%">{{ $factura->registroServicio->estudiante->numero_documento }}</td>
                                </tr>
                                <tr>
                                    <td width="40%" class="bg-gray-600 font-weight-bold">Email</td>
                                    <td width="60%">{{ $factura->registroServicio->estudiante->email }}</td>
                                </tr>
                                <tr>
                                    <td width="40%" class="bg-gray-600 font-weight-bold">Celular</td>
                                    <td width="60%">{{ $factura->registroServicio->estudiante->celular }}</td>
                                </tr>
                                <tr>
                                    <td width="40%" class="bg-gray-600 font-weight-bold">PDF Documento</td>
                                    <td width="60%"><a href="{{ asset($factura->registroServicio->estudiante->archivo_cedula) }}" target="_blank">Ver documento</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 col-12">
                <div class="card mt-4">
                    <div class="card-header bg-gray-600">
                        <i class="fas fa-table me-1"></i>
                        Información Pagos
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-condensed">
                            <tbody>
                                <tr>
                                    <td width="20%" class="bg-gray-600 font-weight-bold">Valor</td>
                                    <td width="30%">${{ number_format($factura->valor, 0, ",", ".") }}</td>
                                    <td width="20%" class="bg-gray-600 font-weight-bold">Saldo restante</td>
                                    <td width="30%">${{ number_format($factura->saldo, 0, ",", ".") }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <nav class="mt-4">
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                              <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">
                                Movimientos
                            </button>
                            </div>
                        </nav>
                        <div class="tab-content border" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="w-100 text-end mb-4">
                                            <button class="btn btn-primary rounded btn-sm" onclick="realizarPago({{ $factura->id }});">
                                                Agregar Nuevo Pago
                                            </button>
                                        </div>
                                        <table class="table" id="datatable_pagos" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Tipo Pago</th>
                                                    <th>Fecha</th>
                                                    <th>Descripción</th>
                                                    <th>Valor</th>
                                                    <th>Estado</th>
                                                    <th width="50">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Tipo Pago</th>
                                                    <th>Fecha</th>
                                                    <th>Descripción</th>
                                                    <th>Valor</th>
                                                    <th>Estado</th>
                                                    <th width="50">Acciones</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 col-12 mb-4">
                <div class="card mt-4">
                    <div class="card-header bg-gray-600">
                        <i class="fas fa-table me-1"></i>
                        Acciones
                    </div>
                    <div class="card-body">
                        <form action="{{ route('facturacion.update') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6 col-12">
                                    <label for="staticEmail2" class="">1. Actualizar Estado</label>
                                    <select class="form-select" name="estado_factura" id="estado_factura" required>
                                        @foreach ($estados as $key => $item)
                                            @php
                                                $selected = ($key == $factura->estado) ? 'selected' : '';
                                            @endphp
                                            <option value="{{ $key }}" {{ $selected }}>{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" id="btn_actualizar" class="btn btn-primary mb-3">Actualizar Datos</button>
                                </div>
                            </div>

                            <input name="factura_id" id="factura_id" value="{{ $factura->id }}" hidden>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <x-facturacion.modal-pagos/>
    <x-facturacion.modal-editar-pago/>

    <x-slot name="js">
        <script>

            var tabla_pagos = $('#datatable_pagos').DataTable({
                "processing": true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.11.4/i18n/es_es.json"
                },
                "order": [[ 0, "desc" ]],
                "pageLength" : 10,
                "ajax": route('facturacion.pagos.all', "{{ $factura->id }}"),
                "responsive": true,
                "dom": 'Bfrtip',
                "buttons": [
                    'csv', 'excel'
                ],
            });

            $('#btn_actualizar').on('click', function(){
                Swal.fire({
                    title: "¡Guardando!",
                    text: "Procesando la información, espere...",
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                });
            });

            function realizarPago(id){
                let timerInterval;
                Swal.fire({
                    title: "Espera!",
                    text: "Cargando información...",
                    timerProgressBar: true,
                    timer: 1500,
                    didOpen: () => {
                        Swal.showLoading();
                        const b = Swal.getHtmlContainer().querySelector('b');
                        timerInterval = setInterval(() => {
                            b.textContent = Swal.getTimerLeft()
                        }, 100);
                    },
                    willClose: () => {
                        clearInterval(timerInterval);
                    }
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        $('#modal_pagos_factura_id').val(id);
                        $('#modal_nuevo_pago').modal('show');
                    }
                });
            }

            $('#form_nuevo_pago').on('submit', function(e) {
                event.preventDefault();
                if ($('#form_nuevo_pago')[0].checkValidity() === false) {
                    event.stopPropagation();
                } else {

                    var url = route('facturacion.pagos.create');

                    //agregar data
                    var $thisForm = $('#form_nuevo_pago');
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
                                text: "Guardando el pago...",
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
                                text: "Pago guardado",
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 3000
                            });
                            $('#form_nuevo_pago')[0].reset();
                            $('#form_nuevo_pago').removeClass('was-validated');
                            //tabla_pagos.ajax.reload();
                            $("#modal_nuevo_pago").modal('hide');
                            location.reload();
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
                $('#form_nuevo_pago').addClass('was-validated');
            });

            function editarPago(id){

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    type: "GET",
                    encoding:"UTF-8",
                    url: route('facturacion.pagos.get', id),
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

                    $('#modal_editar_pago_id').val(id);
                    $("#modal_editar_pago_tipo option[value='"+respuesta.data.tipo+"']").attr("selected", true);
                    $("#modal_editar_pago_estado option[value='"+respuesta.data.estado+"']").attr("selected", true);
                    $('#modal_editar_pago').modal('show');

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


                // let timerInterval;
                // Swal.fire({
                //     title: "Espera!",
                //     text: "Cargando información...",
                //     timerProgressBar: true,
                //     timer: 1500,
                //     didOpen: () => {
                //         Swal.showLoading();
                //         const b = Swal.getHtmlContainer().querySelector('b');
                //         timerInterval = setInterval(() => {
                //             b.textContent = Swal.getTimerLeft()
                //         }, 100);
                //     },
                //     willClose: () => {
                //         clearInterval(timerInterval);
                //     }
                // }).then((result) => {
                //     if (result.dismiss === Swal.DismissReason.timer) {
                //         $('#modal_editar_pago_id').val(id);
                //         $('#modal_editar_pago_tipo option[value="no"]').attr("selected", "selected");
                //         $('#modal_editar_pago').modal('show');
                //     }
                // });
            }

            $('#form_editar_pago').on('submit', function(e) {
                event.preventDefault();
                if ($('#form_editar_pago')[0].checkValidity() === false) {
                    event.stopPropagation();
                } else {

                    var url = route('facturacion.pagos.update');

                    //agregar data
                    var $thisForm = $('#form_editar_pago');
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
                                text: "Actualizando el pago...",
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
                                text: "Pago Actualizado",
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 3000
                            });
                            $('#form_editar_pago')[0].reset();
                            $('#form_editar_pago').removeClass('was-validated');
                            //tabla_pagos.ajax.reload();
                            $("#modal_editar_pago").modal('hide');
                            location.reload();
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
                $('#form_editar_pago').addClass('was-validated');
            });

        </script>
    </x-slot>

</x-app-layout>
