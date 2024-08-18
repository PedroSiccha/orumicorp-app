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
                <table class="table m-b-xs">
                    <tbody>
                        <tr>
                            <td>
                                <strong>Código</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='text' class='form-control text-success'
                                    placeholder="Ingrese su código" id='eCode'>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Nombre</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='text' class='form-control text-success'
                                    placeholder="Ingrese su nombre" id='eName'>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Apellidos</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='text' class='form-control text-success'
                                    placeholder="Ingrese su apellido" id='eLastname'>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <strong>Teléfono</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='text' class='form-control text-success'
                                    placeholder="Ingrese su teléfono" id='ePhone'>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Teléfono Opcional</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='text' class='form-control text-success'
                                    placeholder="Ingrese un teléfono opcional" id='eOptionalPhone'>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Correo</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='email' class='form-control text-success'
                                    placeholder="Ingrese su correo" id='eEmail'>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Ciudad</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='text' class='form-control text-success'
                                    placeholder="Ingrese su Ciudad" id='eCity'>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Pais</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='text' class='form-control text-success'
                                    placeholder="Ingrese su país" id='eCountry'>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Comentario</strong>
                            </td>
                            <td>
                                <textarea style='font-size: large;' type='text' class='form-control text-success'
                                    placeholder="Ingrese un comentario" id='eComment'></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Asignar un Rol</strong>
                            </td>
                            <td>
                                <select class="form-control m-b" name="account" id="eRol_id">
                                    <option>Seleccione su Rol</option>
                                    @foreach($roles as $rol)
                                    <option value="{{ $rol->id }}">{{ $rol->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
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
