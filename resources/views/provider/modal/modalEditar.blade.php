<!-- Modal para editar Proveedores -->
<div class="modal inmodal fade" id="modalEditarProvider" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Editar Proveedor</h4>
                <input type="text" placeholder="idEditarProvider" class="form-control" id='idEditarProvider' readonly hidden>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Nombre</label>
                    <div class="col-lg-9">
                        <input type="text" placeholder="Nombre del proveedor" class="form-control" id='nameProviderEdit'>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Teléfono</label>
                    <div class="col-lg-9">
                        <input type="text" placeholder="Número del teléfono" class="form-control" id='phoneProviderEdit'>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Correo</label>
                    <div class="col-lg-9">
                        <input type="email" placeholder="Corréo electrónico" class="form-control" id='emailProviderEdit'>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info " type="button" onclick="updateProvider({idProvider: '#idEditarProvider', nameProvider: '#nameProviderEdit', phoneProvider: '#phoneProviderEdit', emailProvider: '#emailProviderEdit', modal: '#modalEditarProvider', tableName: '#tabProvider'})"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>
