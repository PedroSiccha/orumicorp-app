<div class="modal inmodal fade" id="modalSendMail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title">Enviar Correo</h4>
                <input type="text" placeholder="Folder Actual" class="form-control" id='idCustomerSendMail' hidden>
                <input type="text" placeholder="Folder Actual" class="form-control" id='imputMail' hidden>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Asunto</label>
                    <div class="col-lg-12">
                        <input type="text" class="form-control-sm form-control"  id="subjectMail"/>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="ibox-content no-padding">
                        <div class="summernote">
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {{-- <button class="btn btn-info " type="button"
                    onclick="asignFolderGroup('#idGroupClientes', '#folder_id', '#modalAsignFolder', '#tabClient')"><i
                        class="fa fa-save"></i> Guardar</button> --}}
                <button class="btn btn-info " type="button"
                    onclick="enviarCorreo({ modal: '#modalSendMail', clienteId: '#idCustomerSendMail', email: '#imputMail', mensaje: '#subjectMail', asunto: '#summernote' })"><i
                        class="fa fa-save"></i> Enviar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i>
                    Cancelar</button>
            </div>
        </div>
    </div>
</div>
