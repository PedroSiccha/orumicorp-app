<div class="modal inmodal fade" id="modalCargaMasivaShooter" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title">Cargar Clientes de Manera Masiva</h4>
            </div>
            <div class="modal-body">
                <input id="inputFolderId" hidden/>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Formato</label>
                    <div class="input-group col-lg-9">
                        <a href="{{ route('descargarArchivo') }}" class="btn btn-primary"><i class="fa fa-download"></i>
                            Descargar archivo</a>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Subir Archivo</label>
                    <div class="col-lg-9">
                        <input type="file" placeholder="Nombre del agente" id="fileExcel" class="form-control">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="ladda-button ladda-button-demo btn btn-info" data-style="zoom-in" type="button"
                    onclick="uploadExcelbyFolder('fileExcel', '#inputFolderId')"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i>
                    Cancelar</button>
            </div>
        </div>
    </div>
</div>
