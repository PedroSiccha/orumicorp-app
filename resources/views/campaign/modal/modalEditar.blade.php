<!-- Modal para crear Estado de Cliente -->
<div class="modal inmodal fade" id="modalEditarCampaign" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Editar Campaña</h4>
                <input type="text" placeholder="idEditarCampaign" class="form-control" id='idEditarCampaign' readonly hidden>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Nombre</label>
                    <div class="col-lg-9">
                        <input type="text" placeholder="Nombre de la campaña" class="form-control" id='nameCampaignEdit'>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Descripción</label>
                    <div class="col-lg-9">
                        <input type="text" placeholder="Descripción" class="form-control" id='descriptionCampaignEdit'>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Inicio</label>
                    <div class="col-lg-9">
                        <input type="date" placeholder="Fecha de Inicio" class="form-control" id='initDateCampaignEdit'>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Fin</label>
                    <div class="col-lg-9">
                        <input type="date" placeholder="Fecha de Fin" class="form-control" id='endDateCampaignEdit'>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info " type="button" onclick="updateCampaign({editCampaignId: '#idEditarCampaign', nameCampaign: '#nameCampaignEdit', descriptionCampaign: '#descriptionCampaignEdit', initDateCampaign: '#initDateCampaignEdit', endDateCampaign: '#endDateCampaignEdit', modal: '#modalEditarCampaign', tableName: '#tabCampaing'})"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>
