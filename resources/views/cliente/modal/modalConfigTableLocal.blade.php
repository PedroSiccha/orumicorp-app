<!-- Modal para configurar la tabla -->
<div class="modal fade" id="modalConfigTableLocal" tabindex="-1" role="dialog" aria-hidden="true">
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
                        <div class="checkbox">
                            <label><input type="checkbox" class="column-toggle" data-column="0" checked> Ultima
                                llamada</label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" class="column-toggle" data-column="1" checked> ID de
                                Cliente</label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" class="column-toggle" data-column="2" checked> Fecha de
                                Ingreso</label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" class="column-toggle" data-column="3" checked> Fecha de
                                Ultima Llamada</label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" class="column-toggle" data-column="4" checked> Fecha de
                                Última Asignación</label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" class="column-toggle" data-column="5" checked> Asignado
                                Por</label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" class="column-toggle" data-column="6" checked>
                                Proveedor</label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" class="column-toggle" data-column="7" checked>
                                Campaña</label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" class="column-toggle" data-column="8" checked> Nombre del
                                Cliente</label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" class="column-toggle" data-column="9" checked>
                                Correo</label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" class="column-toggle" data-column="10" checked>
                                Teléfono</label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" class="column-toggle" data-column="11" checked> Teléfono
                                Opcional</label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" class="column-toggle" data-column="12" checked>
                                Ciudad</label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" class="column-toggle" data-column="13" checked>
                                País</label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" class="column-toggle" data-column="14" checked>
                                Estado</label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" class="column-toggle" data-column="15" checked>
                                Agente</label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" class="column-toggle" data-column="16" checked>
                                Comentario</label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" class="column-toggle" data-column="17" checked> Última
                                Visita</label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" class="column-toggle" data-column="18" checked> FTD
                                Date</label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" class="column-toggle" data-column="19" checked>
                                Método</label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" class="column-toggle" data-column="20" checked> N° de
                                Depósito</label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" class="column-toggle" data-column="21" checked> Total de
                                Depósito</label>
                        </div>
                        <!-- Añadir más checkboxes para cada columna -->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="button" data-dismiss="modal"
                    onclick="saveTableConfigLocal()">Guardar</button>
                <button class="btn btn-default" type="button" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
