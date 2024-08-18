<div class="modal inmodal fade" id="modalAsignAgent" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title">Asignar Clientes</h4>
            </div>
            <div class="modal-body">

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Agente</label>
                    <div class="input-group col-lg-9">
                        <input type="text" class="form-control" id="dniGroupAgent"
                            placeholder="Ingrese el DNI o Código del agente">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary"
                                onclick="searchAgent('#dniGroupAgent', '#nameGroupAgent')"><i
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
                    onclick="assignGroupAgent('#idGroupClientes', '#dniGroupAgent', '#modalAsignAgent', '#tabClient')"><i
                        class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i>
                    Cancelar</button>
            </div>
        </div>
    </div>
</div>
