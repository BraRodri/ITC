<!-- Modal -->
<div class="modal fade" id="editar_usuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Actualizar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">

                <form id="form_editar_usuario" class="row g-3 needs-validation" method="POST" novalidate enctype="multipart/form-data">
                    @csrf

                    <div class="col-md-12">
                        <label for="inputState" class="form-label">Primero, por favor selecciona un rol:</label>
                        <select id="editar_rol" class="form-select" name="rol" required>
                            <option value="" selected>- Seleccione -</option>
                            @if (count($roles) > 0)
                                @foreach ($roles as $item)
                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="" class="form-label">Tipo de Documento</label>
                        <select id="editar_tipo_documento" class="form-select" name="tipo_documento" required>
                            <option value="" selected>- Seleccione -</option>
                            @if (count($tipos_documentos) > 0)
                                @foreach ($tipos_documentos as $key => $value)
                                    <option value="{{ $value }}">{{ $value }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="" class="form-label">Numero de Documento</label>
                        <input type="text" class="form-control" id="editar_numero_documento" name="numero_documento" autocomplete="off" required>
                    </div>
                    <div class="col-md-6">
                        <label for="" class="form-label">Nombres</label>
                        <input type="text" class="form-control" id="editar_nombres" name="nombres" required>
                    </div>
                    <div class="col-md-6">
                        <label for="" class="form-label">Direcci??n</label>
                        <input type="text" class="form-control" id="editar_direccion" name="direccion" required>
                    </div>
                    <div class="col-md-6">
                        <label for="" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editar_email" name="email" autocomplete="off" required>
                    </div>
                    <div class="col-md-6">
                        <label for="inputPassword4" class="form-label">Contrase??a</label>
                        <input type="password" class="form-control" id="password" name="passsword" autocomplete="off">
                    </div>
                    <div class="col-md-6">
                        <label for="inputPassword4" class="form-label">Telefono/Celular</label>
                        <input type="text" class="form-control" id="editar_celular" name="celular" autocomplete="off" required>
                    </div>
                    <div class="col-md-6">
                        <label for="inputState" class="form-label">Estado</label>
                        <select id="editar_estado" class="form-select" name="estado" required>
                            <option value="" selected>- Seleccione -</option>
                            @if (count($estados) > 0)
                                @foreach ($estados as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="inputPassword4" class="form-label">(No es obligatorio en la actualizaci??n). Por ultimo, por favor sube una copia del documento de identidad</label>
                        <input type="file" class="form-control" id="archivo" name="archivo" accept=".pdf">

                        <label class="mt-2"><strong>Importante:</strong> El usuario ya cuenta con una copia de su documento.</label>
                        <a href="#" id="editar_ver_documento" target="_blank">Ver documento cargado</a>
                    </div>

                    <input type="hidden" name="id" id="editar_id">

                    <div class="col-12 pt-3" style="text-align: right">
                        <button type="submit" class="btn btn-primary rounded btn-sm">Actualizar Usuario</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
