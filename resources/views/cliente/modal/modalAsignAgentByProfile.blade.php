<div class="modal inmodal fade" id="modalAsignAgentByProfile" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title">Asignar Agente</h4>
                <input type="text" id="idClientesAsignacion" hidden>
            </div>
            <div class="modal-body">
                <div id="alertError" class="alert alert-danger alert-dismissable d-none">
                    <span id="alertErrorText"></span>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Agente</label>
                    <div class="input-group col-lg-9">
                        <input type="text" class="form-control" id="dniGroupAgent"
                            placeholder="Ingrese el DNI o Código del agente">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary ladda-button-agent" data-style="zoom-in"
                                onclick="searchAgent({ inputcodeVoiso: '#dniGroupAgent', inputName: '#nameGroupAgent', alertError: '#alertError', alertErrorText: '#alertErrorText', btnLadda: '.ladda-button-agent'})"><i
                                    class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Datos del Agente</label>
                    <div class="col-lg-9">
                        <input type="text" placeholder="Nombre del agente" class="form-control" id='nameGroupAgent'
                            readonly>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="ladda-button ladda-button-demo btn btn-info" data-style="zoom-in" type="button"
                    onclick="guardarAsignacionAgentePorPerfil('#idClientesAsignacion', '#dniGroupAgent', '#modalAsignAgentByProfile', '#agentAssignament')"><i
                        class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i>
                    Cancelar</button>
            </div>
        </div>
    </div>
</div>
