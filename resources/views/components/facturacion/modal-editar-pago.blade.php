<!-- Modal -->
<div class="modal" id="modal_editar_pago" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Actualizar Pago</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">

                <form id="form_editar_pago" class="row g-3 needs-validation" method="POST" novalidate enctype="multipart/form-data">
                    @csrf

                    <div class="col-md-6">
                        <label for="inputState" class="form-label">Primero, por favor selecciona un tipo de pago:</label>
                        <select id="modal_editar_pago_tipo" class="form-select" name="tipo" required>
                            <option value="" selected>- Seleccione -</option>
                            <option value="Abono">Abono</option>
                            <option value="Pago Completo">Pago Completo</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="inputState" class="form-label">Estado</label>
                        <select id="modal_editar_pago_estado" class="form-select" name="estado" required>
                            <option value="" selected>- Seleccione -</option>
                            @if (count($estados) > 0)
                                @foreach ($estados as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <input type="hidden" name="pago_id" id="modal_editar_pago_id">

                    <div class="col-12 pt-3" style="text-align: right">
                        <button type="submit" class="btn btn-primary rounded btn-sm">Actualizar Pago</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
