<div class="modal inmodal fade" id="modalRegistrarEvento" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Registrar Evento</h4>
            </div>
            <div class="modal-body">
                <div id="alertErrorNuevoDeposito" class="alert alert-danger alert-dismissable d-none">
                    <span id="alertErrorTextNuevoDeposito"></span>
                </div>
                <div class="form-group row" hidden>
                    <label class="col-lg-3 col-form-label">ID</label>
                    <div class="col-lg-9">
                        <input type="text" placeholder="Nombre del evento" class="form-control" id='id' name='id'>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Fecha</label>
                    <div class="col-lg-9">
                        <input type="date" placeholder="Nombre del evento" class="form-control" id='dateEvent' name='dateEvent' readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Nombre del Evento</label>
                    <div class="col-lg-9">
                        <input type="text" placeholder="Nombre del evento" class="form-control" id='nombreEvento'>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Descripción</label>
                    <div class="input-group col-lg-9">
                        <textarea type="text" placeholder="Descripción del evento" class="form-control" id='descripcionEvento'></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Código del Cliente</label>
                    <div class="col-lg-9">
                        <div class="input-group">
                            <input type="text" class="form-control" id="dniCustomer" placeholder="Ingrese el DNI o Código del cliente">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary ladda-button-client-new-deposit" data-style="zoom-in" onclick="searchClient({ inputDni: '#dniCustomer', inputName: '#nameCustomer', alertError: '#alertErrorNuevoDeposito', alertErrorText: '#alertErrorTextNuevoDeposito', btnLadda: '.ladda-button-client-new-deposit' })"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Nombre del Cliente</label>
                    <div class="col-lg-9">
                        <input type="text" placeholder="Nombre del Cliente" class="form-control" id='nameCustomer' readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Desde</label>
                    <div class="col-lg-9">
                        <input type="time" placeholder="Desde" class="form-control" id='horaInicio'>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Hasta</label>
                    <div class="col-lg-9">
                        <input type="time" placeholder="Nombre del agenteHasta" class="form-control" id='horaFin'>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Prioridad</label>
                    <div class="col-lg-9">
                        <select class="form-control m-b" name="priority_id" id="priority_id">
                            <option>Nivel de Prioridad</option>
                            @foreach ($priorities as $priority)
                                <option value="{{ $priority->id }}" class="{{ $priority->color }}">{{ $priority->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success " type="button" onclick="saveEvent('#id', '#dateEvent', '#nombreEvento', '#descripcionEvento', '#dniCustomer', '#horaInicio', '#horaFin', '#priority_id', '#modalRegistrarEvento', '#tabClient')"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-warning " type="button" onclick="editEvent('#id', '#dateEvent', '#nombreEvento', '#descripcionEvento', '#dniCustomer', '#horaInicio', '#horaFin', '#priority_id', '#modalRegistrarEvento')"><i class="fa fa-pencil"></i> Modificar</button>
                <button class="btn btn-danger " type="button" onclick="deleteEvent('#id', '#modalRegistrarEvento')"><i class="fa fa-trash"></i> Eliminar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-close"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>
