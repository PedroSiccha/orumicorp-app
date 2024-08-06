@extends('layouts.app')
@section('title')
Mantenimiento
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Mantenimiento</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Inicio</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Mantenimiento</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="wrapper wrapper-content animated fadeInUp">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="row m-t-sm">
                        <div class="col-lg-12">
                            <div class="panel blank-panel">
                                <div class="panel-heading">
                                    <div class="panel-options">
                                        <ul class="nav nav-tabs">
                                            <li><a class="nav-link active show" href="#tab-customer-status" data-toggle="tab">Estados de Clientes</a></li>
                                            <li><a class="nav-link" href="#tab-campaign" data-toggle="tab">Campañas</a></li>
                                            <li><a class="nav-link" href="#tab-provider" data-toggle="tab">Proveedores</a></li>
                                            <li><a class="nav-link" href="#tab-platform" data-toggle="tab">Platform</a></li>
                                            <li><a class="nav-link" href="#tab-traiding" data-toggle="tab">Traiding</a></li>
                                            <li><a class="nav-link" href="#tab-transaction-type" data-toggle="tab">Tipo de Transacción</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="panel-body">

                                    <div class="tab-content">
                                        <div class="tab-pane active show" id="tab-customer-status">
                                            <div class="col-lg-12">
                                                <div class="ibox ">
                                                    <div class="ibox-title d-flex justify-content-between align-items-center">
                                                        <h5>Tabla Estado </h5>
                                                        <div>
                                                            <button type="button" class="btn btn-default" onclick="mostrarNuevoModal('#modalEstado')"><i class="fa fa-plus"></i> Nuevo Estado</button>
                                                        </div>
                                                    </div>
                                                    <div class="ibox-content" id="tabStatus">
                                                        <div class="table-responsive">
                                                            @if ($customersStatus->isEmpty())
                                                                <p>No hay datos disponibles.</p>
                                                            @else
                                                                @include('customerStatus.table.tableCustomerStatus')
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab-campaign">
                                            <div class="col-lg-12">
                                                <div class="ibox ">
                                                    <div class="ibox-title d-flex justify-content-between align-items-center">
                                                        <h5>Tabla Campañas </h5>
                                                        <div>
                                                            <button type="button" class="btn btn-default" onclick="mostrarNuevoModal('#modalCrearCampaign')"><i class="fa fa-plus"></i> Nueva Campaña</button>
                                                        </div>
                                                    </div>
                                                    <div class="ibox-content" id="tabCampaing">
                                                        <div class="table-responsive">
                                                            @if ($campaigns->isEmpty())
                                                                <p>No hay datos disponibles.</p>
                                                            @else
                                                                @include('campaign.table.tableCampaign')
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="tab-provider">
                                            <div class="col-lg-12">
                                                <div class="ibox ">
                                                    <div class="ibox-title d-flex justify-content-between align-items-center">
                                                        <h5>Tabla Proveedores </h5>
                                                        <div>
                                                            <button type="button" class="btn btn-default" onclick="mostrarNuevoModal('#modalCrearProvider')"><i class="fa fa-plus"></i> Nuevo Proveedor</button>
                                                        </div>
                                                    </div>
                                                    <div class="ibox-content" id="tabProvider">
                                                        <div class="table-responsive">
                                                            @if ($suppliers->isEmpty())
                                                                <p>No hay datos disponibles.</p>
                                                            @else
                                                                @include('provider.table.tableProvider')
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="tab-platform">
                                            <div class="col-lg-12">
                                                <div class="ibox ">
                                                    <div class="ibox-title d-flex justify-content-between align-items-center">
                                                        <h5>Tabla Platform </h5>
                                                        <div>
                                                            <button type="button" class="btn btn-default" onclick="mostrarNuevoModal('#modalCrearPlatform')"><i class="fa fa-plus"></i> Nueva Platform</button>
                                                        </div>
                                                    </div>
                                                    <div class="ibox-content" id="tabPlatform">
                                                        <div class="table-responsive">
                                                            @if ($platforms->isEmpty())
                                                                <p>No hay datos disponibles.</p>
                                                            @else
                                                                @include('platform.table.tablePlatform')
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="tab-traiding">
                                            <div class="col-lg-12">
                                                <div class="ibox ">
                                                    <div class="ibox-title d-flex justify-content-between align-items-center">
                                                        <h5>Tabla Traiding </h5>
                                                        <div>
                                                            <button type="button" class="btn btn-default" onclick="mostrarNuevoModal('#modalCrearTraiding')"><i class="fa fa-plus"></i> Nuevo Traiding</button>
                                                        </div>
                                                    </div>
                                                    <div class="ibox-content" id="tabTraiding">
                                                        <div class="table-responsive">
                                                            @if ($traidings->isEmpty())
                                                                <p>No hay datos disponibles.</p>
                                                            @else
                                                                @include('traiding.table.tableTraiding')
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="tab-transaction-type">
                                            <div class="col-lg-12">
                                                <div class="ibox ">
                                                    <div class="ibox-title d-flex justify-content-between align-items-center">
                                                        <h5>Tabla Tipo de Transacción </h5>
                                                        <div>
                                                            <button type="button" class="btn btn-default" onclick="mostrarNuevoModal('#modalCrearTransactionType')"><i class="fa fa-plus"></i> Nuevo Tipo de Transacción</button>
                                                        </div>
                                                    </div>
                                                    <div class="ibox-content" id="tabTransactionType">
                                                        <div class="table-responsive">
                                                            @if ($transactionsType->isEmpty())
                                                                <p>No hay datos disponibles.</p>
                                                            @else
                                                                @include('transactionType.table.tableTransactionType')
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('customerStatus.modal.modalCrear')
@include('customerStatus.modal.modalEditar')

@include('campaign.modal.modalCrear')
@include('campaign.modal.modalEditar')

@include('provider.modal.modalCrear')
@include('provider.modal.modalEditar')

@include('platform.modal.modalCrear')
@include('platform.modal.modalEditar')

@include('traiding.modal.modalCrear')
@include('traiding.modal.modalEditar')

@include('transactionType.modal.modalCrear')
@include('transactionType.modal.modalEditar')

@endsection
@section('script')
    <script>
        var saveCustomerStatusRoute = '{{ route("saveCustomerStatus") }}';
        var updateCustomerStatusRoute = '{{ route("updateCustomerStatus") }}';
        var deleteCustomerStatusRoute = '{{ route("deleteCustomerStatus") }}';
        var saveCampaignRoute = '{{ route("saveCampaign") }}';
        var updateCampaignRoute = '{{ route("updateCampaign") }}';
        var deleteCampaignRoute = '{{ route("deleteCampaign") }}';
        var saveProviderRoute = '{{ route("saveProvider") }}';
        var updateProviderRoute = '{{ route("updateProvider") }}';
        var deleteProviderRoute = '{{ route("deleteProvider") }}';
        var savePlatformRoute = '{{ route("savePlatform") }}';
        var updatePlatformRoute = '{{ route("updatePlatform") }}';
        var deletePlatformRoute = '{{ route("deletePlatform") }}';
        var saveTraidingRoute = '{{ route("saveTraiding") }}';
        var updateTraidingRoute = '{{ route("updateTraiding") }}';
        var deleteTraidingRoute = '{{ route("deleteTraiding") }}';
        var saveTransactionTypeRoute = '{{ route("saveTransactionType") }}';
        var updateTransactionTypeRoute = '{{ route("updateTransactionType") }}';
        var deleteTransactionTypeRoute = '{{ route("deleteTransactionType") }}';
        var token = '{{ csrf_token() }}';
    </script>

    <script src="{{ asset('js/utils/mostrarNuevoModal.js') }}"></script>
    <script src="{{ asset('js/utils/mostrarMensaje.js') }}"></script>

    <script src="{{ asset('js/customerStatus/createCustomerStatus.js') }}"></script>
    <script src="{{ asset('js/customerStatus/editCustomerStatus.js') }}"></script>
    <script src="{{ asset('js/customerStatus/deleteCustomerStatus.js') }}"></script>

    <script src="{{ asset('js/campaign/createCampaign.js') }}"></script>
    <script src="{{ asset('js/campaign/editCampaign.js') }}"></script>
    <script src="{{ asset('js/campaign/deleteCampaign.js') }}"></script>

    <script src="{{ asset('js/provider/createProvider.js') }}"></script>
    <script src="{{ asset('js/provider/editProvider.js') }}"></script>
    <script src="{{ asset('js/provider/deleteProvider.js') }}"></script>

    <script src="{{ asset('js/platform/createPlatform.js') }}"></script>
    <script src="{{ asset('js/platform/editPlatform.js') }}"></script>
    <script src="{{ asset('js/platform/deletePlatform.js') }}"></script>

    <script src="{{ asset('js/traiding/createTraiding.js') }}"></script>
    <script src="{{ asset('js/traiding/editTraiding.js') }}"></script>
    <script src="{{ asset('js/traiding/deleteTraiding.js') }}"></script>

    <script src="{{ asset('js/transactionType/createTransactionType.js') }}"></script>
    <script src="{{ asset('js/transactionType/editTransactionType.js') }}"></script>
    <script src="{{ asset('js/transactionType/deleteTransactionType.js') }}"></script>
@endsection

