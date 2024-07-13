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
                <button class="btn btn-info" type="button"><i class="fa fa-plus"></i> Registrar</button>
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
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
