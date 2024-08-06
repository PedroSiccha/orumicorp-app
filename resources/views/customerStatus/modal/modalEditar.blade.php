<!-- Modal para crear Estado de Cliente -->
<div class="modal inmodal fade" id="modalEditarEstado" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Editar Estado</h4>
                <input type="text" placeholder="idEditarEstado" class="form-control" id='idEditarEstado' readonly hidden>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Estado</label>
                    <div class="col-lg-9">
                        <input type="text" placeholder="Nombre del estado" class="form-control" id='editaNameStatus'>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info " type="button" onclick="updateCustomerStatus({idCustomerStatus: '#idEditarEstado', editNameCustomerStatus: '#editaNameStatus', modal: '#modalEditarEstado', tableName: '#tabStatus'})"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>
