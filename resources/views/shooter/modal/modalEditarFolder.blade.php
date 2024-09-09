<div class="modal inmodal fade" id="modalEditarFolder" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Cambiar Nombre</h4>
                <input type="text" class="form-control" id='idFolderEdit' hidden>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Nombre</label>
                    <div class="col-lg-9">
                        <input type="text" placeholder="Nombre de carpeta" class="form-control" id='nameFolderEdit'>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info " type="button" onclick="editNameFolder({nameFolder: '#nameFolderEdit', folderId: '#idFolderEdit', modal: '#modalEditarFolder', tableName: '#folders'})"><i class="fa fa-save"></i> Crear</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>
