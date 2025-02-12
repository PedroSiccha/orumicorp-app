<div class="modal inmodal fade" id="modalChangeStatus" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title">Elegir estado</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Estados</label>
                    <div class="col-lg-12">
                        <select name="statusClients" id="status_clients_id" class="form-control m-b">
                            <option>Seleccione el nuevo estado</option>
                            @foreach ($statusCustomers as $statusCustomer)
                            <option value="{{ $statusCustomer->id }}">{{ $statusCustomer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info " type="button"
                    onclick="changeStatusGroup('#idGroupClientes', '#status_clients_id', '#modalChangeStatus', '#tabClient')"><i
                        class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i>
                    Cancelar</button>
            </div>
        </div>
    </div>
</div>
