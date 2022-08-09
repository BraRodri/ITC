<x-app-layout>

    @section('pagina')Identificación @endsection

    <div class="container-fluid">

        <div class="mb-4 mt-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
                  <li class="breadcrumb-item"><a href="{{ route('panel') }}">Usuarios</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Identificación</li>
                </ol>
            </nav>
        </div>

        <!-- Page Heading -->
        <div class="row mb-3">
            <div class="col-lg-12">
                <h1 class="h3 text-gray-800 flex-grow-1">Identificación</h1>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-gray-600">
                <i class="fas fa-table me-1"></i>
                Filtros
            </div>
            <div class="card-body">
                <form class="row" id="form_buscar" method="POST" target="_blank">
                    @csrf
                    <div class="col-lg-10 col-12 mt-4">
                        <label for="" class="form-label">Cedula de Usuario</label>
                        <input type="text" name="cedula" class="form-control" placeholder="Digite el número de cedula a buscar..." required>
                    </div>
                    <div class="col-lg-2 col-12 mt-4">
                        <label for="" class="form-label">Acción</label> <br>
                        <button type="submit" class="btn btn-primary btn-sm btn-block">Buscar</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mb-4" id="div_resultados">
            <div class="card-header bg-gray-600">
                <i class="fas fa-table me-1"></i>
                Resultados
            </div>
            <div class="card-body">
                <table class="table" id="datatable" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tipo Documento</th>
                            <th>Numero Documento</th>
                            <th>Nombres</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Tipo Documento</th>
                            <th>Numero Documento</th>
                            <th>Nombres</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>

    <x-slot name="js">
        <script>

            $('#div_resultados').hide();

            var tabla = $('#datatable').DataTable({
                //"processing": true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.11.4/i18n/es_es.json"
                },
                "order": [[ 0, "desc" ]],
                "pageLength" : 25,
                "responsive": true,
                "columns": [
                    { "data": "id" },
                    { "data": "tipo_documento" },
                    { "data": "numero_documento" },
                    { "data": "nombres" },
                    { "data": "estado" },
                    { "data": "boton" },
                ]
            });

            $('#form_buscar').on('submit', function(e) {
                event.preventDefault();
                if ($('#form_buscar')[0].checkValidity() === false) {
                    event.stopPropagation();
                } else {

                    var url = route('usuarios.getIdentificacion');

                    //agregar data
                    var $thisForm = $('#form_buscar');
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
                                text: "Consultado información...",
                                timerProgressBar: true,
                                didOpen: () => {
                                    Swal.showLoading();
                                },
                            });
                        }
                    }).done(function(respuesta){
                        console.log(respuesta);
                        if (!respuesta.error) {

                            $('#div_resultados').show();
                            //limpia la tabla
                            tabla.clear().draw();

                            if (respuesta.data.length > 0) {
                                respuesta.data.forEach(element => {

                                    tabla.row.add({
                                            "id": element["id"],
                                            "tipo_documento": element["tipo_documento"],
                                            "numero_documento": element["numero_documento"],
                                            "nombres": element["nombres"],
                                            "estado": element["estado"],
                                            "boton": element["boton"],
                                    }).draw(false);

                                });
                            }

                            Swal.fire({
                                text: "Información Cargada",
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 3000
                            });
                            $('#form_buscar')[0].reset();
                            $('#form_buscar').removeClass('was-validated');

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
                $('#form_buscar').addClass('was-validated');
            });
        </script>
    </x-slot>

</x-app-layout>
