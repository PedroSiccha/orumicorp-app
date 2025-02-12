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
                @can('Nuevo Deposito')
                <button class="btn btn-info" type="button" onclick="mostrarNuevoModal('#modalNuevoDeposito')"><i class="fa fa-plus"></i> Registrar</button>
                @endcan
            </div>
            <div class="inbox-content" id="tabDeposit">
                @include('deposit.table.tableDeposit')
            </div>
        </div>
    </div>
</div>

@include('deposit.modal.modalCrear')

@endsection
@section('script')
<script>
    var token = '{{ csrf_token() }}';
    var saveDepositRoute = '{{ route("saveDeposit") }}';
    var searchAgentRoute = '{{ route("searchAgent") }}';
    var searchClientRoute = '{{ Route("searchCustomer") }}';
</script>

<script src="{{ asset('js/utils/mostrarNuevoModal.js') }}"></script>
<script src="{{ asset('js/utils/mostrarMensaje.js') }}"></script>
<script src="{{ asset('js/deposit/saveDeposit.js') }}"></script>
<script src="{{asset('js/agent/searchAgent.js')}}"></script>
<script src="{{ asset('js/customer/searchClient.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        markNotificationsAsSeen('deposit');
    });
</script>
@endsection
