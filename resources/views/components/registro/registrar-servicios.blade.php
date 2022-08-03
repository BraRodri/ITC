<!-- Modal -->
<div class="modal fade" id="modal_registrar_servicio" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registrar Servicio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">

                <form id="form_registrar_servicio" class="row g-3 needs-validation" method="POST" novalidate enctype="multipart/form-data">
                    @csrf

                    <div class="col-md-8">
                        <label for="" class="form-label">Seleccione un estudiante (Activo)</label>
                        <select class="form-control select2_modal" name="estudiante" id="estudiante" required style="width: 100%;">
                            <option>- Seleccione -</option>
                            @if (count($estudiantes) > 0)
                                @foreach ($estudiantes as $item)
                                    <option value="{{ $item->id }}">{{ $item->numero_documento }} - {{ $item->nombres }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="" class="form-label">Fecha</label>
                        <input type="date" class="form-control" id="fecha" name="fecha" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="col-md-12">
                        <label for="inputPassword4" class="form-label">Servicio</label>
                        <select class="form-select select2_modal" name="servicio" id="servicio" required style="width: 100%;">
                            <option value="">- Seleccione -</option>
                            @if (count($servicios) > 0)
                                @foreach ($servicios as $item)
                                    <option value="{{ $item->id }}" data-servicio="{{ $item->nombre }}" data-tiposervicio="{{ $item->tipoServicio->nombre }}" data-valorservicio="{{ $item->precio }}">{{ $item->nombre }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="" class="form-label">Tipo de servicio</label>
                        <input type="text" class="form-control" id="tipo_servicio" name="tipo_servicio" required readonly>
                    </div>
                    <div class="col-md-4">
                        <label for="" class="form-label">Valor del Servicio</label>
                        <input type="text" class="form-control" id="valor_servicio" required readonly>
                        <input type="text" class="form-control" id="valor_servicio_normal" name="valor_servicio" required hidden>
                        <input type="text" class="form-control" id="nombre_servicio" name="nombre_servicio" required hidden>
                    </div>
                    <div class="col-md-4">
                        <label for="inputState" class="form-label">Estado</label>
                        <select id="estado" class="form-select" name="estado" required>
                            <option value="" selected>- Seleccione -</option>
                            @if (count($estados) > 0)
                                @foreach ($estados as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="col-12 pt-3" style="text-align: right">
                        <button type="submit" class="btn btn-primary rounded btn-sm">Registrar Servicio</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
