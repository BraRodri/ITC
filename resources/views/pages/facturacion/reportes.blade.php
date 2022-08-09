<x-app-layout>

    @section('pagina')Generación de Reportes @endsection

    <div class="container-fluid">

        <div class="mb-4 mt-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
                  <li class="breadcrumb-item"><a href="{{ route('panel') }}">Facturación</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Generación de Reportes</li>
                </ol>
            </nav>
        </div>

        <!-- Page Heading -->
        <div class="row mb-3">
            <div class="col-lg-12">
                <h1 class="h3 text-gray-800 flex-grow-1">Generación de Reportes</h1>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-gray-600">
                <i class="fas fa-table me-1"></i>
                Filtros
            </div>
            <div class="card-body">
                <form class="row" action="{{ route('facturacion.generarReportes') }}" method="POST" target="_blank">
                    @csrf
                    <div class="col-lg-12 col-12 mb-4">
                        <label for="" class="form-label">Factura</label>
                        <select id="factura" class="form-select select2" name="factura">
                            <option value="" selected>- Seleccione -</option>
                            @if (count($facturas) > 0)
                                @foreach ($facturas as $key => $value)
                                    <option value="{{ $value->id }}">#{{ substr(str_repeat(0, 5).$value->id, - 5) }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-lg-4 col-12">
                        <label for="" class="form-label">Estudiante</label>
                        <select id="usuario" class="form-select select2" name="usuario">
                            <option value="" selected>- Seleccione -</option>
                            @if (count($usuarios) > 0)
                                @foreach ($usuarios as $key => $value)
                                    <option value="{{ $value->id }}">{{ $value->numero_documento }} - {{ $value->nombres }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-lg-4 col-12">
                        <label for="" class="form-label">Tipo de Servicio</label>
                        <select id="tipo_servicio" class="form-select" name="tipo_servicio">
                            <option value="" selected>- Seleccione -</option>
                            @if (count($tipos_servicios) > 0)
                                @foreach ($tipos_servicios as $key => $value)
                                    <option value="{{ $value->nombre }}">{{ $value->nombre }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-lg-4 col-12">
                        <label for="" class="form-label">Servicio</label>
                        <select id="servicio" class="form-select" name="servicio">
                            <option value="" selected>- Seleccione -</option>
                            @if (count($servicios) > 0)
                                @foreach ($servicios as $key => $value)
                                    <option value="{{ $value->nombre }}">{{ $value->nombre }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-lg-3 col-12 mt-4">
                        <label for="" class="form-label">Estado</label>
                        <select id="estado" class="form-select" name="estado">
                            <option value="" selected>- Seleccione -</option>
                            @if (count($estados) > 0)
                                @foreach ($estados as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-lg-3 col-12 mt-4">
                        <label for="" class="form-label">Fecha desde</label>
                        <input type="date" name="fecha_desde" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="col-lg-3 col-12 mt-4">
                        <label for="" class="form-label">Fecha hasta</label>
                        <input type="date" name="fecha_hasta" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="col-lg-3 col-12 mt-4">
                        <label for="" class="form-label">Acción</label> <br>
                        <button type="submit" class="btn btn-primary btn-sm btn-block">Generar Reporte</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <x-slot name="js">
        <script>
            $('.select2').select2({
                minimumInputLength: 4,
                allowClear: true,
            });
        </script>
    </x-slot>

</x-app-layout>
