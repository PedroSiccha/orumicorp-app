<div class="modal inmodal fade" id="modalAsignFolder" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title">Asignar a Folder</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Folder</label>
                    <div class="col-lg-12">
                        <select name="folders" id="folder_id" class="form-control m-b">
                            <option>Seleccione un folder</option>
                            @foreach ($folders as $folder)
                            <option value="{{ $folder->id }}">{{ $folder->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info " type="button"
                    onclick="addGroupClientFolder({ idGroupClientes: '#idGroupClientes', folderId: '#folder_id', modal: '#modalAsignFolder', tableName: '#tabClient'})"><i
                        class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i>
                    Cancelar</button>
            </div>
        </div>
    </div>
</div>
