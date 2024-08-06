<!-- Modal para crear Proveedores -->
<div class="modal inmodal fade" id="modalCrearProvider" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Crear Nuevo Proveedor</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Nombre</label>
                    <div class="col-lg-9">
                        <input type="text" placeholder="Nombre del proveedor" class="form-control" id='nameProvider'>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Teléfono</label>
                    <div class="col-lg-9">
                        <input type="text" placeholder="Número del teléfono" class="form-control" id='phoneProvider'>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Corréo</label>
                    <div class="col-lg-9">
                        <input type="email" placeholder="Corréo electrónico" class="form-control" id='emailProvider'>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info " type="button" onclick="createProvider({nameProvider: '#nameProvider', phoneProvider: '#phoneProvider', emailProvider: '#emailProvider', modal: '#modalCrearProvider', tableName: '#tabProvider'})"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>
