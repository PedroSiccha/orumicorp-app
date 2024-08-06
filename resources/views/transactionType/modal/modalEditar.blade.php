<!-- Modal para editar Tipo de Transacción -->
<div class="modal inmodal fade" id="modalEditarTransactionType" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Editar Tipo de Transacción</h4>
                <input type="text" placeholder="idEditarTransactionType" class="form-control" id='idEditarTransactionType' readonly hidden>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Nombre</label>
                    <div class="col-lg-9">
                        <input type="text" placeholder="Nombre de tipo de transacción" class="form-control" id='nameTransactionTypeEdit'>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Descripción</label>
                    <div class="col-lg-9">
                        <input type="text" placeholder="Descripción" class="form-control" id='descriptionTransactionTypeEdit'>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info " type="button" onclick="updateTransactionType({idTransactionType: '#idEditarTransactionType', nameTransactionType: '#nameTransactionTypeEdit', descriptionTransactionType: '#descriptionTransactionTypeEdit', modal: '#modalEditarTransactionType', tableName: '#tabTransactionType'})"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>
