<div class="modal inmodal fade" id="modalDescuento" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title">Registrar Descuento</h4>
            </div>

            <div class="modal-body">
                <div id="alertErrorCreateDescuento" class="alert alert-danger alert-dismissable d-none">
                    <span id="alertErrorTextCreateDescuento"></span>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Agente</label>
                    <div class="input-group col-lg-9">
                        <input type="text" class="form-control" id="dniDiscountAgent" placeholder="Ingrese el DNI o Código del agente">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary ladda-button-agent-create-descuento" data-style="zoom-in" onclick="searchAgentV2({
                                inputcodeVoiso: '#dniDiscountAgent',
                                inputName: '#nameDiscountAgent',
                                alertError: '#alertErrorCreateDescuento',
                                alertErrorText: '#alertErrorTextCreateDescuento',
                                btnLadda: '.ladda-button-agent-create-descuento'
                            })">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Datos del Agente</label>
                    <div class="col-lg-9">
                        <input type="text" class="form-control" id="nameDiscountAgent" placeholder="Nombre del agente" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Monto</label>
                    <div class="col-lg-9">
                        <input type="number" class="form-control" id="amountDiscount" placeholder="Ingrese un monto">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Comentario</label>
                    <div class="col-lg-9">
                        <textarea class="form-control" id="observationDiscount" placeholder="Ingrese su comentario"></textarea>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-info" type="button" onclick="createDiscount({
                    dniAgent: '#dniDiscountAgent',
                    commission: '#amountDiscount',
                    inputObservation: '#observationDiscount',
                    modal: '#modalDescuento',
                    table: '#tabBonus',
                    typeSales: '3'
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
