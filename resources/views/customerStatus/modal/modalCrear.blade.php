<!-- Modal para crear Estado de Cliente -->
<div class="modal inmodal fade" id="modalEstado" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Crear Nuevo Estado</h4>
                <input type="text" placeholder="idComunication" class="form-control" id='idComunication' readonly hidden>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Estado</label>
                    <div class="col-lg-9">
                        <input type="text" placeholder="Nombre del estado" class="form-control" id='nameStatus'>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info " type="button" onclick="createCustomerStatus({nameCustomerStatus: '#nameStatus', modal: '#modalEstado', tableName: '#tabStatus'})"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>
