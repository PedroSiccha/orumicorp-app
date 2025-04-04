<div class="modal inmodal fade" id="modalRegistrarTarget" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
          </button>
          <h4 class="modal-title">Registrar Target</h4>
          <small>{{ date("F") }}</small>
        </div>
        <div class="modal-body">
          <div id="alertErrorRegistrarTarget" class="alert alert-danger alert-dismissable d-none">
            <span id="alertErrorTextRegistrarTarget"></span>
          </div>
  
          <div class="form-group row">
            <label class="col-lg-3 col-form-label">Agente</label>
            <div class="input-group col-lg-9">
              <input type="text" class="form-control" id="dniTargetAgent" placeholder="Ingrese el DNI o Código del agente">
              <div class="input-group-append">
                <button type="button" class="btn btn-primary ladda-button-agent-registrar-target" data-style="zoom-in"
                  onclick="searchAgent({ inputcodeVoiso: '#dniTargetAgent', inputName: '#nameTargetAgent', alertError: '#alertErrorRegistrarTarget', alertErrorText: '#alertErrorTextRegistrarTarget', btnLadda: '.ladda-button-agent-registrar-target' })">
                  <i class="fa fa-search"></i>
                </button>
              </div>
            </div>
          </div>
  
          <div class="form-group row">
            <label class="col-lg-3 col-form-label">Datos del Agente</label>
            <div class="col-lg-9">
              <input type="text" placeholder="Nombre del agente" class="form-control" id="nameTargetAgent" readonly>
            </div>
          </div>
  
          <div class="form-group row">
            <label class="col-lg-3 col-form-label">Monto</label>
            <div class="col-lg-9">
              <input type="number" placeholder="Ingrese un monto" class="form-control" id="amountTarget">
            </div>
          </div>
        </div>
  
        <div class="modal-footer">
          <button class="btn btn-info" type="button"
            onclick="createTarget('#amountTarget', '#dniTargetAgent', '#modalRegistrarTarget', '#tabTarget')">
            <i class="fa fa-save"></i> Guardar
          </button>
          <button class="btn btn-default" data-dismiss="modal" type="button">
            <i class="fa fa-trash"></i> Cancelar
          </button>
        </div>
      </div>
    </div>
  </div>
  