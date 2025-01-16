<div class="modal inmodal fade" id="modalChangeFolder" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                    class="sr-only">Close</span></button>
                <h4 class="modal-title">Cambiar Folder</h4>
                <input type="text" placeholder="Folder Actual" class="form-control" id='idCustomerChangeFolder' hidden>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Folder Actual</label>
                    <div class="col-lg-12">
                        <select name="folders" id="oldFolderChangeId" class="form-control m-b" disabled>
                            @foreach ($folders as $folder)
                            <option value="{{ $folder->id }}">{{ $folder->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Folder</label>
                    <div class="col-lg-12">
                        <select name="folders" id="newFolderChangeId" class="form-control m-b">
                            <option>Seleccione nuevo folder</option>
                            @foreach ($folders as $folder)
                            <option value="{{ $folder->id }}">{{ $folder->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {{-- <button class="btn btn-info " type="button"
                    onclick="asignFolderGroup('#idGroupClientes', '#folder_id', '#modalAsignFolder', '#tabClient')"><i
                        class="fa fa-save"></i> Guardar</button> --}}
                <button class="btn btn-info " type="button"
                    onclick="assignNewFolder({ clienteId: '#idCustomerChangeFolder', folderId: '#newFolderChangeId', modal: '#modalChangeFolder', tableName: '#tabClient'})"><i
                        class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i>
                    Cancelar</button>
            </div>
        </div>
    </div>
</div>
