<!-- Modal para crear Traiding -->
<div class="modal inmodal fade" id="modalCrearTraiding" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Crear Traiding</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Código</label>
                    <div class="col-lg-9">
                        <input type="text" placeholder="Código de traiding" class="form-control" id='codeTraiding'>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Descripción</label>
                    <div class="col-lg-9">
                        <input type="text" placeholder="Descripción" class="form-control" id='descriptionTraiding'>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info " type="button" onclick="createTraiding({codeTraiding: '#codeTraiding', descriptionTraiding: '#descriptionTraiding', modal: '#modalCrearTraiding', tableName: '#tabTraiding'})"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>
