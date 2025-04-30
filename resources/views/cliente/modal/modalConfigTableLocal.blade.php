<!-- Modal para configurar la tabla -->
<div class="modal inmodal fade" id="modalConfigTableLocal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title">Configurar la Tabla</h4>
                <small class="font-bold">Seleccione las columnas que desea mostrar</small>
            </div>
            <div class="modal-body">
                <form id="configTableForm">
                    <div class="form-group">
                        <!-- Selector para guardar configuración -->
                        <label>Guardar configuración para:</label>
                        <select id="configScope" class="form-control">
                            <option value="user">Guardar para Usuario</option>
                            @can('Gestionar Tabla Por Roles') <!-- Solo si el usuario tiene permiso -->
                                <option value="role">Guardar para Rol</option>
                            @endcan
                        </select>
                    </div>
                    <div class="form-group" id="roleSelector" style="display: none;"> 
                        <label>Seleccionar Rol:</label>
                        <select id="roleSelectorId" class="form-control">
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>                    
                    <div class="form-group">
                        <div>
                            <label>
                                <input type="checkbox" class="column-toggle" data-column="1" checked>
                                Última llamada
                            </label>
                        </div>
                        <div>
                            <label>
                                <input type="checkbox" class="column-toggle" data-column="2" checked>
                                COD. de Cliente
                            </label>
                        </div>
                        <div>
                            <label>
                                <input type="checkbox" class="column-toggle" data-column="3" checked>
                                Fecha de Ingreso
                            </label>
                        </div>
                        <div>
                            <label>
                                <input type="checkbox" class="column-toggle" data-column="4" checked>
                                Fecha de Última Llamada
                            </label>
                        </div>
                        <div>
                            <label>
                                <input type="checkbox" class="column-toggle" data-column="5" checked>
                                Fecha de última Asignación
                            </label>
                        </div>
                        <div>
                            <label>
                                <input type="checkbox" class="column-toggle" data-column="6" checked>
                                Asignado Por
                            </label>
                        </div>
                        <div>
                            <label>
                                <input type="checkbox" class="column-toggle" data-column="7" checked>
                                Proveedor
                            </label>
                        </div>
                        {{-- <div>
                            <label>
                                <input type="checkbox" class="column-toggle" data-column="7" checked>
                                Campaña
                            </label>
                        </div> --}}
                        <div>
                            <label>
                                <input type="checkbox" class="column-toggle" data-column="8" checked>
                                Nombre del Cliente
                            </label>
                        </div>
                        <div>
                            <label>
                                <input type="checkbox" class="column-toggle" data-column="9" checked>
                                Correo
                            </label>
                        </div>
                        <div>
                            <label>
                                <input type="checkbox" class="column-toggle" data-column="10" checked>
                                Teléfono
                            </label>
                        </div>
                        <div>
                            <label>
                                <input type="checkbox" class="column-toggle" data-column="11" checked>
                                Teléfono Opcional
                            </label>
                        </div>
                        {{-- <div>
                            <label>
                                <input type="checkbox" class="column-toggle" data-column="12" checked>
                                Ciudad
                            </label>
                        </div> --}}
                        <div>
                            <label>
                                <input type="checkbox" class="column-toggle" data-column="12" checked>
                                País
                            </label>
                        </div>
                        <div>
                            <label>
                                <input type="checkbox" class="column-toggle" data-column="13" checked>
                                Estado
                            </label>
                        </div>
                        <div>
                            <label>
                                <input type="checkbox" class="column-toggle" data-column="14" checked>
                                Agente
                            </label>
                        </div>
                        <div>
                            <label>
                                <input type="checkbox" class="column-toggle" data-column="15" checked>
                                Comentario
                            </label>
                        </div>
                        <div>
                            <label>
                                <input type="checkbox" class="column-toggle" data-column="16" checked>
                                Última Visita
                            </label>
                        </div>
                        <div>
                            <label>
                                <input type="checkbox" class="column-toggle" data-column="17" checked>
                                FTD Date
                            </label>
                        </div>
                        <div>
                            <label>
                                <input type="checkbox" class="column-toggle" data-column="18" checked>
                                Método
                            </label>
                        </div>
                        <div>
                            <label>
                                <input type="checkbox" class="column-toggle" data-column="19" checked>
                                N° de Depósito
                            </label>
                        </div>
                        <div>
                            <label>
                                <input type="checkbox" class="column-toggle" data-column="20" checked>
                                Total Depósito
                            </label>
                        </div>
                        <div>
                            <label>
                                <input type="checkbox" class="column-toggle" data-column="21" checked>
                                Folder
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="button" id="saveConfigBtn">Guardar</button> 
                <button class="btn btn-warning" type="button" id="resetConfigBtn">Restablecer Configuración</button>
                <button class="btn btn-default" type="button" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
 