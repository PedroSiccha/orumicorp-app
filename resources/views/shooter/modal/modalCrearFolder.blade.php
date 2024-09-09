<div class="modal inmodal fade" id="modalCrearFolder" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Crear Folder</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Elegir una categoría</label>
                    <div class="col-lg-9">
                        <select name="category" id="category_id" class="form-control m-b">
                            <option>Seleccione una categoría</option>
                            @foreach ($categoryFolders as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Nombre</label>
                    <div class="col-lg-9">
                        <input type="text" placeholder="Nombre de carpeta" class="form-control" id='nameFolder'>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info " type="button" onclick="saveFolder({nameFolder: '#nameFolder', categoryId: '#category_id', modal: '#modalCrearFolder', tableName: '#folders'})"><i class="fa fa-save"></i> Crear</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>
