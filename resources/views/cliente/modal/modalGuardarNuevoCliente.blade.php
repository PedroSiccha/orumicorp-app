<div class="modal inmodal fade" id="modalCliente" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title">Nuevo Cliente</h4>
                <small class="font-bold">Registre su nuevo cliente</small>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6 b-r">
                        <h3 class="m-t-none m-b">Datos Personales</h3>
                        <div class="form-group">
                            <label>Código</label>
                            <input id="code" type="text" placeholder="Ingrese Código" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Nombres</label>
                            <input id="name" type="text" placeholder="Ingrese Nombre" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Apellidos</label>
                            <input id="lastname" type="text" placeholder="Ingrese Apellido" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Teléfono</label>
                            <input id="phone" type="text" placeholder="Ingrese Teléfono" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Teléfono Opcional</label>
                            <input id="optionalPhone" type="text" placeholder="Ingrese Teléfono Opcional"
                                class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Correo</label>
                            <input id="email" type="email" placeholder="Ingrese Correo" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Ciudad</label>
                            <input id="city" type="text" placeholder="Ingrese Ciudad" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>País</label>
                            <input id="country" type="text" placeholder="Ingrese País" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Proveedor</label>
                            <select name="provider" id="provide_id" class="form-control m-b">
                                <option>Seleccione un proveedor</option>
                                @foreach ($providers as $provider)
                                <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Platform</label>
                            <select name="platform" id="platform_id" class="form-control m-b">
                                <option>Seleccione su platform</option>
                                @foreach ($platforms as $platform)
                                <option value="{{ $platform->id }}">{{ $platform->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Traiding</label>
                            <select name="traiding" id="traiding_id" class="form-control m-b">
                                <option>Seleccione su Traiding</option>
                                @foreach ($traidings as $traiding)
                                <option value="{{ $traiding->id }}">{{ $traiding->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-info" type="button"
                        onclick="guardarNuevoCliente('#code', '#name', '#lastname', '#phone', '#optionalPhone', '#email', '#city', '#country', '#provide_id', '#traiding_id', '#platform_id', '#modalCliente', '#tabClient')"><i
                            class="fa fa-save"></i> Guardar</button>
                    <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i>
                        Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>
