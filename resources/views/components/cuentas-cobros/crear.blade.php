<!-- Modal -->
<div class="modal fade" id="modal_registrar_cuentas_cobros" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo Documento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">

                <form id="form_crear_cuentas_cobro" class="row g-3 needs-validation" method="POST" novalidate enctype="multipart/form-data">
                    @csrf

                    <div class="col-md-4">
                        <label for="" class="form-label">Tipo de Usuario</label>
                        <select class="form-select" name="tipo_usuario" id="tipo_usuario" required>
                            <option value="">- Seleccione -</option>
                            @if (count($roles) > 0)
                                @foreach ($roles as $item)
                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="col-md-8">
                        <label for="" class="form-label">Usuario</label>
                        <select class="form-select" name="usuario" id="usuario" style="width: 100%" required>
                            <option value="">- Seleccione -</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="" class="form-label">N° Cuenta Cobro</label>
                        <input type="text" class="form-control" name="numero_cuenta" id="numero_cuenta" required>
                    </div>

                    <div class="col-md-4">
                        <label for="" class="form-label">Fecha Inicio</label>
                        <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" required>
                    </div>

                    <div class="col-md-4">
                        <label for="" class="form-label">Fecha Terminación</label>
                        <input type="date" class="form-control" name="fecha_terminacion" id="fecha_terminacion" required>
                    </div>

                    <div class="col-md-12">
                        <label for="" class="form-label">Valor</label>
                        <input type="number" class="form-control" name="valor" id="valor" min="1" placeholder="0" required>
                    </div>

                    <div class="col-md-12">
                        <label for="" class="form-label">Por concepto de</label>
                        <textarea class="form-control" name="conceptos" id="conceptos" rows="4" required></textarea>
                    </div>

                    <div class="col-12 pt-3" style="text-align: right">
                        <button type="submit" class="btn btn-primary rounded btn-sm">Registrar Documento</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
