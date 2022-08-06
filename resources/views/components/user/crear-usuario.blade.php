<!-- Modal -->
<div class="modal fade" id="registrar_usuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">

                <form id="form_registro_usuario" class="row g-3 needs-validation" method="POST" novalidate enctype="multipart/form-data">
                    @csrf

                    <div class="col-md-12">
                        <label for="inputState" class="form-label">Primero, por favor selecciona un rol:</label>
                        <select id="rol" class="form-select" name="rol" required>
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
                        <select id="tipo_documento" class="form-select" name="tipo_documento" required>
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
                        <input type="text" class="form-control" id="numero_documento" name="numero_documento" autocomplete="off" required>
                    </div>
                    <div class="col-md-6">
                        <label for="" class="form-label">Nombres</label>
                        <input type="text" class="form-control" id="nombres" name="nombres" required>
                    </div>
                    <div class="col-md-6">
                        <label for="" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" required>
                    </div>
                    <div class="col-md-6">
                        <label for="" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" autocomplete="off" required>
                    </div>
                    <div class="col-md-6">
                        <label for="inputPassword4" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="passsword" value="" autocomplete="off" @if($tipo == 2) disabled @endif>
                    </div>
                    <div class="col-md-6">
                        <label for="inputPassword4" class="form-label">Telefono/Celular</label>
                        <input type="text" class="form-control" id="celular" name="celular" autocomplete="off" required>
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
                    <div class="col-md-12">
                        <label for="inputPassword4" class="form-label">Por ultimo, por favor sube una copia del documento de identidad</label>
                        <input type="file" class="form-control" id="archivo" name="archivo" accept=".pdf" required>
                    </div>

                    <div class="col-12 pt-3" style="text-align: right">
                        <button type="submit" class="btn btn-primary rounded btn-sm">Registrar Usuario</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
