<!-- Modal -->
<div class="modal fade" id="modal_crear_servicio" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo Servicio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">

                <form id="form_crear_servicio" class="row g-3 needs-validation" method="POST" novalidate enctype="multipart/form-data">
                    @csrf

                    <div class="col-md-6">
                        <label for="" class="form-label">Nombre del Servicio</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="col-md-6">
                        <label for="" class="form-label">Codigo</label>
                        <input type="text" class="form-control" id="codigo" name="codigo" required>
                    </div>
                    <div class="col-md-6">
                        <label for="" class="form-label">Tipo</label>
                        <select class="form-select" name="tipo_servicio" id="tipo_servicio" required>
                            <option value="">- Seleccione -</option>
                            @if (count($tipos) > 0)
                                @foreach ($tipos as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="inputPassword4" class="form-label">Ciudad</label>
                        <select class="form-select" name="ciudad" id="ciudad" required>
                            <option value="">- Seleccione -</option>
                            <option value="Cúcuta">Cúcuta</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="" class="form-label">Precio</label>
                        <input type="number" class="form-control" id="precio" name="precio" placeholder="0" min="1" required>
                    </div>
                    <div class="col-md-6">
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
                        <button type="submit" class="btn btn-primary rounded btn-sm">Crear Servicio</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
