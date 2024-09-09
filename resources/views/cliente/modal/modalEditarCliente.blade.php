<div class="modal inmodal fade" id="modalEditarCliente" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title">Editar Cliente</h4>
                <input style='font-size: large;' type='text' class='form-control text-success' placeholder="Id Cliente"
                    id='eId' hidden>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6 b-r">
                        <h3 class="m-t-none m-b">Datos Personales</h3>
                        <div class="form-group">
                            <label>Código</label>
                            <input type="text" placeholder="Ingrese Código" class="form-control" id='eCode'>
                        </div>
                        <div class="form-group">
                            <label>Nombres</label>
                            <input type="text" placeholder="Ingrese Nombre" class="form-control" id='eName'>
                        </div>
                        <div class="form-group">
                            <label>Apellidos</label>
                            <input type="text" placeholder="Ingrese Apellido" class="form-control" id='eLastname'>
                        </div>
                        <div class="form-group">
                            <label>Teléfono</label>
                            <input type="text" placeholder="Ingrese Teléfono" class="form-control" id='ePhone'>
                        </div>
                        <div class="form-group">
                            <label>Teléfono Opcional</label>
                            <input type="text" placeholder="Ingrese Teléfono Opcional" class="form-control" id='eOptionalPhone'>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Correo</label>
                            <input type="email" placeholder="Ingrese Correo" class="form-control" id='eEmail'>
                        </div>
                        <div class="form-group">
                            <label>Ciudad</label>
                            <input type="text" placeholder="Ingrese Ciudad" class="form-control" id='eCity'>
                        </div>
                        <div class="form-group">
                            <label>País</label>
                            <input type="text" placeholder="Ingrese País" class="form-control" id='eCountry'>
                        </div>
                        <div class="form-group">
                            <label>Proveedor</label>
                            <select name="provider" id="eProvide_id" class="form-control m-b">
                                <option>Seleccione un proveedor</option>
                                @foreach ($providers as $provider)
                                <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Platform</label>
                            <select name="platform" id="ePlatform_id" class="form-control m-b">
                                <option>Seleccione su platform</option>
                                @foreach ($platforms as $platform)
                                <option value="{{ $platform->id }}">{{ $platform->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Traiding</label>
                            <select name="traiding" id="eTraiding_id" class="form-control m-b">
                                <option>Seleccione su Traiding</option>
                                @foreach ($traidings as $traiding)
                                <option value="{{ $traiding->id }}">{{ $traiding->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Estado</label>
                            <select name="status" id="eStatus_id" class="form-control m-b">
                                <option>Seleccione su Estado</option>
                                @foreach ($statusCustomers as $statusCustomer)
                                <option value="{{ $statusCustomer->id }}">{{ $statusCustomer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-info " type="button" onclick="updateClient(
                    '#eId',
                    '#eCode',
                    '#eName',
                    '#eLastname',
                    '#ePhone',
                    '#eOptionalPhone',
                    '#eEmail',
                    '#eCity',
                    '#eCountry',
                    '#eComment',
                    '#eRol_id',
                    '#modalEditarCliente',
                    '#tabClient')"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i>
                    Cancelar</button>
            </div>
        </div>
    </div>
</div>
