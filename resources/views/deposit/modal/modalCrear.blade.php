<div class="modal inmodal fade" id="modalNuevoDeposito" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Nuevo Depósito</h4>
            </div>
            <div class="modal-body">
                <div id="alertErrorNuevoDeposito" class="alert alert-danger alert-dismissable d-none">
                    <span id="alertErrorTextNuevoDeposito"></span>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Cliente</label>
                    <div class="input-group col-lg-9">
                        <input type="text" class="form-control" id="dniCli" placeholder="Ingrese el DNI o Código del agente">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary ladda-button-client-new-deposit" data-style="zoom-in" onclick="searchClient({ inputDni: '#dniCli', inputName: '#nameClient', alertError: '#alertErrorNuevoDeposito', alertErrorText: '#alertErrorTextNuevoDeposito', btnLadda: '.ladda-button-client-new-deposit' })"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Cliente</label>
                    <div class="col-lg-9">
                        <input type="text" placeholder="Nombre del agente" class="form-control" id='nameClient' readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Agente</label>
                    <div class="input-group col-lg-9">
                        <input type="text" class="form-control" id="codeAgent" placeholder="Ingrese el DNI o Código del agente">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary ladda-button-agent-new-deposit" data-style="zoom-in" onclick="searchAgent({ inputcodeVoiso: '#codeAgent', inputName: '#nameAgent', alertError: '#alertErrorNuevoDeposito', alertErrorText: '#alertErrorTextNuevoDeposito', btnLadda: '.ladda-button-agent-new-deposit' })"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Datos del Agente</label>
                    <div class="col-lg-9">
                        <input type="text" placeholder="Nombre del agente" class="form-control" id='nameAgent' readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Típo de Pago</label>
                    <div class="col-lg-9">
                        <select name="transaction_type" id="transaction_type_id" class="form-control m-b">
                            <option>Seleccione el tipo de transacción</option>
                            @foreach ($transactionsType as $transactionType)
                                <option value="{{ $transactionType->id }}">{{ $transactionType->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Código de Recibo</label>
                    <div class="col-lg-9">
                        <input type="text" placeholder="Ingresar recibo" class="form-control" id='codeReceipt'>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Monto</label>
                    <div class="col-lg-9 input-group m-b">
                        <div class="input-group-append">
                            <a type="button" class="btn btn-default">S/.</a>
                        </div>
                        <input type="number" placeholder="Ingrese monto" class="form-control" id="amount">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Lista de Ventas</label>
                    <div class="col-lg-9">
                        <select name="transaction_type" id="transaction_type_id" class="form-control m-b">
                            <option>Seleccione la venta asociada</option>
                            @foreach ($sales as $sale)
                                <option value="{{ $sale->id }}">MONTO: $ {{ number_format($sale->amount, 2) }} CLIENTE: {{ $sale->customer->name }} {{ $sale->customer->lastname }} AGENTE: {{ $sale->customer->name }} {{ $sale->customer->lastname }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info " type="button" onclick="saveDeposit({ codeClient: '#dniCli', codeAgent: '#codeAgent', transaction_type_id: '#transaction_type_id', codeReceipt: '#codeReceipt', amount: '#amount', modal: '#modalNuevoDeposito', tableName: '#tabDeposit'})"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>
