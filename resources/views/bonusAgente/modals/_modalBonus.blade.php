<div class="modal inmodal fade" id="modalBonus" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title">Registrar Bonus</h4>
            </div>
            <div class="modal-body">
                <div id="alertErrorCreateBonus" class="alert alert-danger alert-dismissable d-none">
                    <span id="alertErrorTextCreateBonus"></span>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Agente</label>
                    <div class="input-group col-lg-9">
                        <input type="text" class="form-control" id="dniAgent" placeholder="Ingrese el DNI o Código del cliente">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary ladda-button-agent-create-bonus" data-style="zoom-in"
                                    onclick="searchAgentV2({ 
                                        inputcodeVoiso: '#dniAgent', 
                                        inputName: '#nameAgent', 
                                        alertError: '#alertErrorCreateBonus', 
                                        alertErrorText: '#alertErrorTextCreateBonus', 
                                        btnLadda: '.ladda-button-agent-create-bonus' 
                                    })">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Datos del Agente</label>
                    <div class="col-lg-9">
                        <input type="text" placeholder="Nombre del agente" class="form-control" id="nameAgent" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Bono</label>
                    <div class="col-lg-9">
                        <input type="number" placeholder="Ingrese el bono" class="form-control" id="commission">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Comentario</label>
                    <div class="col-lg-9">
                        <textarea class="form-control" placeholder="Ingrese su comentario" id="observation"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info" type="button"
                    onclick="createBonus({
                        dniAgent: '#dniAgent',
                        commission: '#commission',
                        inputObservation: '#observation',
                        inputName: '#nameAgent',
                        alertError: '#alertErrorCreateBonus',
                        alertErrorText: '#alertErrorTextCreateBonus',
                        modal: '#modalBonus',
                        table: '#tabBonus',
                        typeSales: '2'
                    })">
                    <i class="fa fa-save"></i> Guardar
                </button>

                <button class="btn btn-default" data-dismiss="modal" type="button">
                    <i class="fa fa-trash"></i> Cancelar
                </button>
            </div>
        </div>
    </div>
</div>
