<div class="modal inmodal fade" id="modalCrearMail" tabindex="-1" role="dialog" aria-hidden="true">
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
                <div id="alertError" class="alert alert-danger alert-dismissable d-none">
                    <span id="alertErrorText"></span>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Código del Cliente</label>
                    <div class="col-lg-9">
                        <div class="input-group">
                            <input type="text" class="form-control" id="dniCustomer" placeholder="Ingrese el DNI o Código del cliente">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary ladda-button-client-new-deposit" data-style="zoom-in" onclick="searchClient({ inputDni: '#dniCustomer', inputName: '#nameCustomer', alertError: '#alertErrorNuevoDeposito', alertErrorText: '#alertErrorTextNuevoDeposito', btnLadda: '.ladda-button-client-new-deposit' })"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Nombre del Cliente</label>
                    <div class="col-lg-9">
                        <input type="text" placeholder="Nombre del Cliente" class="form-control" id='nameCustomer' readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Asunto</label>
                    <div class="col-lg-9">
                        <input type="text" class="form-control-sm form-control"  id="subjectMail"/>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="ibox-content no-padding col-lg-12">
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
                    onclick="enviarCorreoMail({ modal: '#modalCrearMail', cliente: '#dniCustomer', email: '#imputMail', mensaje: '#subjectMail', asunto: '#summernote' })"><i
                        class="fa fa-save"></i> Enviar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i>
                    Cancelar</button>
            </div>
        </div>
    </div>
</div>
