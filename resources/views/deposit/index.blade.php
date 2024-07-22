@extends('layouts.app')
@section('title')
Depósito
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="inbox">
            <div class="inbox-title d-flex justify-content-between align-items-center">
                <h5>
                    Tabla Depositos
                </h5>
                <button class="btn btn-info" type="button" onclick="mostrarNuevoModal('#modalNuevoDeposito')"><i class="fa fa-plus"></i> Registrar</button>
            </div>
            <div class="inbox-content" id="tabDeposit">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Fecha Registro</th>
                                <th>Id Cliente</th>
                                <th>Cliente</th>
                                <th>Platform</th>
                                <th>Trading Account Id</th>
                                <th>Monto</th>
                                <th>Monto ($)</th>
                                <th>Transacción</th>
                                <th>Agente</th>
                                <th>Desk</th>
                                <th>Campaña</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($deposits as $deposit)
                                <tr>
                                    <th>{{ $deposit->date }}</th>
                                    <th>{{ $deposit->customer->id }}</th>
                                    <th>{{ $deposit->customer->name }} {{ $deposit->customer->lastname }}</th>
                                    <th></th>
                                    <th>{{ $deposit->id }}</th>
                                    <th>{{ $deposit->amount }}</th>
                                    <th>{{ number_format($deposit->amount / 3.5, 2) }}</th>
                                    <th>{{ $deposit->tipo }}</th>
                                    <th>{{ $deposit->agent->name }} {{ $deposit->agent->lastname }}</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="modalNuevoDeposito" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Nuevo Depósito</h4>
                <input type="text" placeholder="Nombre del cliente" class="form-control" id='aId' readonly hidden>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Cliente</label>
                    <div class="input-group col-lg-9">
                        <input type="text" class="form-control" id="dniAgent" placeholder="Ingrese el DNI o Código del agente">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary" onclick="searchAgent('#dniAgent', '#nameAgent')"><i class="fa fa-search"></i></button>
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
                        <input type="text" class="form-control" id="dniAgent" placeholder="Ingrese el DNI o Código del agente">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary" onclick="searchAgent('#dniAgent', '#nameAgent')"><i class="fa fa-search"></i></button>
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
                    <label class="col-lg-3 col-form-label">Datos del Agente</label>
                    <div class="col-lg-9">
                        <input type="text" placeholder="Nombre del agente" class="form-control" id='nameAgent' readonly>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info " type="button" onclick="guardarAsignacionAgente('#aId', '#dniAgent', '#modalAsignarAgente', '#tabClient')"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    var token = '{{ csrf_token() }}';
    var saveDepositRoute = '{{ route("saveDeposit") }}';
</script>

<script src="{{ asset('js/utils/mostrarNuevoModal.js') }}"></script>
<script src="{{ asset('js/utils/mostrarMensaje.js') }}"></script>
<script src="{{ asset('js/deposit/saveDeposit.js') }}"></script>
@endsection
