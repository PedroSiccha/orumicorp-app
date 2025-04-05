<div class="modal inmodal fade" id="modalRegistrarRetiro" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Registrar Retiro</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="alertErrorRegistrarRetiro" class="alert alert-danger alert-dismissable d-none">
                    <span id="alertErrorTextRegistrarRetiro"></span>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Agente</label>
                    <div class="input-group col-lg-9">
                        <input type="text" class="form-control" id="dniAgentRetiro" placeholder="Ingrese el DNI o Código del agente">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary ladda-button-agent-registrar-retiro" data-style="zoom-in"
                                onclick="searchAgent({
                                    inputcodeVoiso: '#dniAgentRetiro',
                                    inputName: '#nameAgentRetiro',
                                    alertError: '#alertErrorRegistrarRetiro',
                                    alertErrorText: '#alertErrorTextRegistrarRetiro',
                                    btnLadda: '.ladda-button-agent-registrar-retiro'
                                })">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Datos del Agente</label>
                    <div class="col-lg-9">
                        <input type="text" placeholder="Nombre del agente" class="form-control" id="nameAgentRetiro" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Monto</label>
                    <div class="col-lg-9">
                        <input type="number" class="form-control" id="amountRetiro" placeholder="Ingrese un monto">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Tipo de Pago</label>
                    <div class="col-lg-9">
                        <select class="form-control m-b" name="percent_id" id="percent_id">
                            <option>Seleccione un porcentaje</option>
                            @foreach($percents as $percent)
                                <option value="{{ $percent->id }}">{{ $percent->description }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-info" type="button"
                    onclick="createRetirement('#dniAgentRetiro', '#amountRetiro', '#modalRegistrarRetiro', '#tabRetiroEfectivo')">
                    <i class="fa fa-save"></i> Guardar
                </button>
                <button class="btn btn-default" data-dismiss="modal" type="button">
                    <i class="fa fa-trash"></i> Cancelar
                </button>
            </div>
        </div>
    </div>
</div>
