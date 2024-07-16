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
                                        </ul>
                                    </div>
                                </div>

                                <div class="panel-body">

                                    <div class="tab-content">
                                        <div class="tab-pane active show" id="tab-status">
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
                                                            <table class="table table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th>ID</th>
                                                                        <th>Nombre</th>
                                                                        <th>Color</th>
                                                                        <th>Acción</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($customersStatus as $customerStatus)
                                                                    <tr>
                                                                        <td>{{ $customerStatus->id }}</td>
                                                                        <td>{{ $customerStatus->name }}</td>
                                                                        <td>{{ $customerStatus->color }}</td>
                                                                        <td>
                                                                            <div class="d-flex align-items-center">
                                                                                <button class="btn btn-warning " type="button" onclick="editarStatus({id: '{{ $customerStatus->id }}', nombre: '{{ $customerStatus->name }}', color: '{{ $customerStatus->color }}', modal: '#modalEstado', inputId: '#idComunication', inputName: '#nameStatus', inputColor: '#colorStatus', tableName: '#tabStatus'})"><i class="fa fa-pencil"></i></button>
                                                                                <button class="btn btn-danger " type="button" onclick="eliminarStatus({id: '{{ $customerStatus->id }}', tableName: '#tabStatus'})"><i class="fa fa-trash"></i></button>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
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
                                                            <button type="button" class="btn btn-default" onclick="mostrarNuevoModal('#modalCampaign')"><i class="fa fa-plus"></i> Nueva Campaña</button>
                                                        </div>
                                                    </div>
                                                    <div class="ibox-content" id="tabCampaing">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th>ID</th>
                                                                        <th>Nombre</th>
                                                                        <th>Descripción</th>
                                                                        <th>Inicio</th>
                                                                        <th>Fin</th>
                                                                        <th>Acción</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($campaigns as $campaign)
                                                                        <tr>
                                                                            <td>{{ $campaign->id }}</td>
                                                                            <td>{{ $campaign->name }}</td>
                                                                            <td>{{ $campaign->description }}</td>
                                                                            <td>{{ $campaign->start_date }}</td>
                                                                            <td>{{ $campaign->end_date }}</td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <button class="btn btn-warning " type="button" onclick="editarCampaign({idCampaign: '{{ $campaign->id }}', name: '{{ $campaign->name }}', description: '{{ $campaign->description }}', startDate: '{{ $campaign->start_date }}', endDate: '{{ $campaign->end_date }}', modal: '#modalCampaign', inputId: '#idCampaign', inputName: '#nameCampaign', inputDescription: '#descriptionCampign', inputStartDate: '#startDateCampign', inputEndCampaign: '#endDateCampaign', tableName: '#tabCampaign'})"><i class="fa fa-pencil"></i></button>
                                                                                    <button class="btn btn-danger " type="button" onclick="eliminarCampaign({idCampaign: '{{ $campaign->id }}', tableName: '#tabClient'})"><i class="fa fa-trash"></i></button>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
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
                                                            <button type="button" class="btn btn-default" onclick="mostrarNuevoModal('#modalProveedor')"><i class="fa fa-plus"></i> Nuevo Proveedor</button>
                                                        </div>
                                                    </div>
                                                    <div class="ibox-content" id="tabProvider">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th>ID</th>
                                                                        <th>Nombre</th>
                                                                        <th>Teléfono</th>
                                                                        <th>Correo</th>
                                                                        <th>Acción</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($suppliers as $supplier)
                                                                        <tr>
                                                                            <td>{{ $supplier->id }}</td>
                                                                            <td>{{ $supplier->name }}</td>
                                                                            <td>{{ $supplier->phone }}</td>
                                                                            <td>{{ $supplier->email }}</td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <button class="btn btn-warning " type="button" onclick="editarProveedor({id: '{{ $supplier->id }}', name: '{{ $supplier->name }}', phone: '{{ $supplier->phone }}', email: '{{ $supplier->email }}', modal: '#modalProveedor', inputId: '#idProveedor', inputName: '#nameProveedor', inputPhone: '#phoneProveedor', inputEmail: '#emailProveedor', tableName: '#tabProvider'})"><i class="fa fa-pencil"></i></button>
                                                                                    <button class="btn btn-danger " type="button" onclick="eliminarProveedor({id: '{{ $supplier->id }}', tableName: '#tabProvider'})"><i class="fa fa-trash"></i></button>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
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
@endsection
@push('scripts')
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
@endpush

