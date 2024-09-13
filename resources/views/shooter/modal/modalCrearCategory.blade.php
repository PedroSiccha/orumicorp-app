<div class="modal inmodal fade" id="modalCrearCategory" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Crear Categoría de Folder</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Categoría de Folder</label>
                    <div class="col-lg-9">
                        <input type="text" placeholder="Nombre de la categoría" class="form-control" id='nameCategoryFolder'>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info " type="button" onclick="saveCategoryFolder({nameCategoryFolder: '#nameCategoryFolder', modal: '#modalCrearCategory', tableName: '#folders'})"><i class="fa fa-save"></i> Crear</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>
