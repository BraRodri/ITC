<x-app-layout>

    @section('pagina')Pagos Cuentas Cobros @endsection

    <div class="container-fluid">

        <div class="mb-4 mt-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Pagos Cuentas Cobros</li>
                </ol>
            </nav>
        </div>

        <!-- Page Heading -->
        <div class="row mb-3">
            <div class="col-lg-6">
                <h1 class="h3 text-gray-800 flex-grow-1">Pagos Cuentas Cobros</h1>
            </div>
            <div class="col-lg-6 text-end">
                <button class="btn btn-primary rounded btn-sm" data-bs-toggle="modal" data-bs-target="#modal_registrar_cuentas_cobros">
                    Registrar nuevo Pago
                </button>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-gray-600">
                <i class="fas fa-table me-1"></i>
                Listado de Pagos
            </div>
            <div class="card-body">
                <table class="table" id="datatable" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>N° Cuenta Cobro</th>
                            <th># Documento</th>
                            <th>Usuario</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Terminación</th>
                            <th>Valor</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>N° Cuenta Cobro</th>
                            <th># Documento</th>
                            <th>Usuario</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Terminación</th>
                            <th>Valor</th>
                            <th>Acciones</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>

    <x-cuentas-cobros.crear-cuenta-cobro/>

    <x-slot name="js">
        <script>

            var tabla = $('#datatable').DataTable({
                "processing": true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.11.4/i18n/es_es.json"
                },
                "order": [[ 0, "desc" ]],
                "pageLength" : 25,
                "ajax": route('cuentas.cobros.all'),
                "responsive": true
            });

            $('#usuario').select2({
                dropdownParent: $('#modal_registrar_cuentas_cobros'),
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

            $('#form_crear_cuentas_cobro').on('submit', function(e) {
                event.preventDefault();
                if ($('#form_crear_cuentas_cobro')[0].checkValidity() === false) {
                    event.stopPropagation();
                } else {

                    var url = route('cuentas.cobros.guardar');

                    //agregar data
                    var $thisForm = $('#form_crear_cuentas_cobro');
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
                                text: "Guardando el nuevo pago...",
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
                            $('#form_crear_cuentas_cobro')[0].reset();
                            $('#form_crear_cuentas_cobro').removeClass('was-validated');
                            tabla.ajax.reload();
                            $("#modal_registrar_cuentas_cobros").modal('hide');
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
                $('#form_crear_cuentas_cobro').addClass('was-validated');
            });

            function eliminar(id){
                Swal.fire({
                    title: 'Eliminar',
                    text: "¿Estás seguro de eliminar el registro?",
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, eliminar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            type: "GET",
                            encoding:"UTF-8",
                            url: route('cuentas.cobros.delete', id),
                            dataType:'json',
                            beforeSend:function(){
                                Swal.fire({
                                    title: "Espera!",
                                    text: "Eliminando el registro...",
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
                                    text: "Registro Eliminado",
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 3000
                                });

                                tabla.ajax.reload();
                            } else {
                                Swal.fire({
                                    title: "Se presento un error!",
                                    html: respuesta.mensaje,
                                    icon: 'error',
                                });
                            }
                        }).fail(function(resp){
                            console.log(resp);
                        });
                    }
                });
            }

        </script>
    </x-slot>

</x-app-layout>
