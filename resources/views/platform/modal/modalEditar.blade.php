<!-- Modal para editar Platform -->
<div class="modal inmodal fade" id="modalEditarPlatform" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Editar Platform</h4>
                <input type="text" placeholder="idEditarPlatform" class="form-control" id='idEditarPlatform' readonly hidden>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Nombre</label>
                    <div class="col-lg-9">
                        <input type="text" placeholder="Nombre de platform" class="form-control" id='namePlatformEdit'>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Descripción</label>
                    <div class="col-lg-9">
                        <input type="text" placeholder="Descripción" class="form-control" id='descriptionPlatformEdit'>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info " type="button" onclick="updatePlatform({idPlatform: '#idEditarPlatform', namePlatform: '#namePlatformEdit', descriptionPlatform: '#descriptionPlatformEdit', modal: '#modalEditarPlatform', tableName: '#tabPlatform'})"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>
