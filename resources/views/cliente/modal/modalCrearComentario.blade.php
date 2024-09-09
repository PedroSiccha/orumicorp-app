<!-- Modal para crear comentario -->
<div class="modal inmodal fade" id="modalCrearComentario" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title">Registre su comentario</h4>
                <input type="text" placeholder="idComunication" class="form-control" id='idComunication' readonly
                    hidden>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Comentario</label>
                    <div class="col-lg-9">
                        <textarea style='font-size: large;' type='text' class='form-control text-success'
                            placeholder="Ingrese un comentario" id='txtComentario'></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label>Estado</label>
                    <select name="statusCustomerComent" id="statusCustomerComent" class="form-control m-b">
                        <option>¿Desea cambiar el estado?</option>
                        @foreach ($statusCustomers as $statusCustomer)
                        <option value="{{ $statusCustomer->id }}">{{ $statusCustomer->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info " type="button"
                    onclick="guardarComentario({inputComunication: '#idComunication', modal: '#modalCrearComentario', inputComentario: '#txtComentario', customerStatusId: '#statusCustomerComent', table: '#tabClient'})"><i
                        class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i>
                    Cancelar</button>
            </div>
        </div>
    </div>
</div>
