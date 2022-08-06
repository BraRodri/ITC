<x-app-layout>

    @section('pagina')Facturas @endsection

    <div class="container-fluid">

        <div class="mb-4 mt-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Facturas</li>
                </ol>
            </nav>
        </div>

        <!-- Page Heading -->
        <div class="row mb-3">
            <div class="col-lg-12">
                <h1 class="h3 text-gray-800 flex-grow-1">Facturas</h1>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-gray-600">
                <i class="fas fa-table me-1"></i>
                Listado de Facturas
            </div>
            <div class="card-body">
                <table class="table" id="datatable" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Estudiante</th>
                            <th>Fecha</th>
                            <th>Servicio</th>
                            <th>Tipo Servicio</th>
                            <th>Valor</th>
                            <th>Saldo</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Estudiante</th>
                            <th>Fecha</th>
                            <th>Servicio</th>
                            <th>Tipo Servicio</th>
                            <th>Valor</th>
                            <th>Saldo</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>

    <x-facturacion.modal-pagos/>

    <x-slot name="js">
        <script>

            var tabla = $('#datatable').DataTable({
                "processing": true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.11.4/i18n/es_es.json"
                },
                "order": [[ 0, "desc" ]],
                "pageLength" : 25,
                "ajax": route('facturacion.all'),
                "responsive": true
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
                            tabla.ajax.reload();
                            $("#modal_nuevo_pago").modal('hide');
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

        </script>
    </x-slot>

</x-app-layout>
