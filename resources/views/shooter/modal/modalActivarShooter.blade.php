<!-- Modal para activar -->
<div class="modal inmodal fade" id="modalActivarShooter" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Activar Shooter</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Asociar una carpeta</label>
                    <div class="col-lg-9">
                        <select name="folder" id="folder_id" class="form-control m-b">
                            <option>Seleccione un folder</option>
                            @foreach ($folders as $folder)
                            <option value="{{ $folder->id }}">{{ $folder->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info " type="button" onclick="activeShooter({folder_id: '#folder_id', modal: '#modalActivarShooter', tableName: '#btnActiveAdmin', secondTableName: '#tabShooter'})"><i class="fa fa-save"></i> Activar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>
