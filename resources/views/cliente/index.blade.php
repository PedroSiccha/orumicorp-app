@extends('layouts.app')

@section('title')
Clientes
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Filtros</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="input-group m-b">
                            <div class="input-group-prepend">
                                <button id="filterButton" data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button">Filtrar Por: </button>
                                <ul class="dropdown-menu">
                                    <li><a href="#" class="dropdown-item">Cod. Cliente</a></li>
                                    <li><a href="#" class="dropdown-item">Asignado Por</a></li>
                                    <li><a href="#" class="dropdown-item">Proveedor</a></li>
                                    {{-- <li class="dropdown-divider"></li> --}}
                                    <li><a href="#" class="dropdown-item">Nombre Cliente</a></li>
                                    <li><a href="#" class="dropdown-item">Correo</a></li>
                                    <li><a href="#" class="dropdown-item">Teléfono</a></li>
                                    <li><a href="#" class="dropdown-item">Teléfono Opcional</a></li>
                                    <li><a href="#" class="dropdown-item">Ciudad</a></li>
                                    <li><a href="#" class="dropdown-item">País</a></li>
                                    <li><a href="#" class="dropdown-item">Agente</a></li>
                                    <li><a href="#" class="dropdown-item">Comentario</a></li>
                                    <li><a href="#" class="dropdown-item">última Visita</a></li>
                                    <li><a href="#" class="dropdown-item">N° Depósito</a></li>
                                    <li><a href="#" class="dropdown-item">Total Depósito</a></li>
                                    <li><a href="#" class="dropdown-item">Folder</a></li>
                                </ul>
                            </div>
                            <input id="inputFilterAdvance" type="text" class="form-control" oninput="filterAdvanced({ buttonFilter: '#filterButton', inputFilter: '#inputFilterAdvance', selectStatus: '#statusCustomerId', selectTypeRange: '#typeRange', dateInit: '#dateInitSearchGeneral', dateEnd: '#dateEndSearchGeneral', tableName: '#tabClient' })">
                        </div>
                    </div>
                    <div class="col-sm-3 m-b-xs">
                        <select class="form-control-sm form-control input-s-sm inline" id="statusCustomerId" onchange="filterAdvanced({ buttonFilter: '#filterButton', inputFilter: '#inputFilterAdvance', selectStatus: '#statusCustomerId', selectTypeRange: '#typeRange', dateInit: '#dateInitSearchGeneral', dateEnd: '#dateEndSearchGeneral', tableName: '#tabClient' })">
                            <option>Seleccione un estado</option>
                            @foreach ($statusCustomers as $statusCustomer)
                                <option value="{{ $statusCustomer->id }}">{{ $statusCustomer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-2 m-b-xs">
                        <select class="form-control m-b" name="typeRange" id="typeRange">
                            <option>Seleccione Rango:</option>
                            <option>Última Llamada</option>
                            <option>Fecha de Ingreso</option>
                            <option>Fecha de Última Llamada</option>
                            <option>Fecha de Última Asignación</option>
                        </select>
                    </div>

                    <div class="col-sm-4 m-b-xs">
                        <div class="form-group" id="data_5">
                            <div class="input-daterange input-group" id="datepicker">
                                <input type="text" class="form-control-sm form-control"  id="dateInitSearchGeneral" autocomplete="off"/>
                                <span class="input-group-addon"> hasta </span>
                                <input type="text" class="form-control-sm form-control"  id="dateEndSearchGeneral" onchange="filterAdvanced({ buttonFilter: '#filterButton', inputFilter: '#inputFilterAdvance', selectStatus: '#statusCustomerId', selectTypeRange: '#typeRange', dateInit: '#dateInitSearchGeneral', dateEnd: '#dateEndSearchGeneral', tableName: '#tabClient' })" autocomplete="off"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title d-flex justify-content-between align-items-center">
                <h5>Tabla Clientes </h5>
                <div>
                    <button id="changeFolderBtn" type="button" class="btn btn-primary" type="button" onclick="mostrarNuevoModal('#modalChangeGroupFolder')" style="display: none;">
                        <i class="fa fa-refresh"></i> Mover de Folder
                    </button>
                    @can('Asignar Folder')
                    <button id="asignarFolderBtn" type="button" class="btn btn-default" type="button" onclick="mostrarNuevoModal('#modalAsignFolder')" style="display: none;">
                        <i class="fa fa-folder-open"></i> Asignar Folder
                    </button>
                    @endcan
                    @can('Liberar Cliente')
                    <button id="liberarClienteBtn" type="button" class="btn btn-danger" type="button" onclick="liberarCliente({ tableName: '#tabClient' })" style="display: none;">
                        <i class="fa fa-minus-square"></i> Liberar Cliente
                    </button>
                    @endcan
                    @can('Asignar Agente')
                    <button id="asignarBtn" type="button" class="btn btn-info" type="button" onclick="mostrarNuevoModal('#modalAsignAgent')" style="display: none;">
                        <i class="fa fa-group"></i> Asignar Agente
                    </button>
                    @endcan
                    @can('Cambiar Estado Cliente')
                    <button id="changeStatusBtn" type="button" class="btn btn-warning" type="button" onclick="mostrarNuevoModal('#modalChangeStatus')" style="display: none;">
                        <i class="fa fa-retweet"></i> Cambiar Estado
                    </button>
                    @endcan
                    @can('Crear Cliente')
                    <button type="button" class="btn btn-default" type="button" onclick="mostrarNuevoModal('#modalCliente')">
                        <i class="fa fa-plus"></i> Nuevo Cliente
                    </button>
                    @endcan
                    @can('Carga Masiva de Cliente')
                    <button type="button" class="btn btn-success" type="button" onclick="mostrarNuevoModal('#modalChargeGroup')">
                        <i class="fa fa-upload"></i> Carga Masiva
                    </button>
                    @endcan
                </div>
                <div class="ibox-tools">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wrench"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li>
                            <a href="#" class="dropdown-item"
                                onclick="mostrarNuevoModal('#modalConfigTableLocal')">Configurar Tabla</a>
                            <!-- <a href="#" class="dropdown-item" onclick="mostrarNuevoModal('#modalConfigTable')">Configurar Tabla</a> -->
                        </li>
                    </ul>
                </div>
            </div>
            {{-- <a href="#" class="dropdown-item" onclick="mostrarNuevoModal('#modalAsignar')">Asignar</a> --}}
            <div class="ibox-content">
                <div class="row">

                    {{-- <div class="col-sm-4 m-b-xs">
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-sm btn-white ">
                                <input type="radio" name="options" id="option1" autocomplete="off" checked> Day
                            </label>
                            <label class="btn btn-sm btn-white active">
                                <input type="radio" name="options" id="option2" autocomplete="off"> Week
                            </label>
                            <label class="btn btn-sm btn-white">
                                <input type="radio" name="options" id="option3" autocomplete="off"> Month
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="input-group"><input placeholder="Search" type="text" class="form-control form-control-sm"> <span class="input-group-append"> <button type="button" class="btn btn-sm btn-primary">Go!
                        </button> </span></div>
 
                    </div> --}}
                </div>
                <div class="table-responsive" id="tabClient">
                    @include('cliente.list.listCustomer')
                </div>
            </div>

        </div>
    </div>
</div>

@include('cliente.modal.modalChargeGroup')
@include('cliente.modal.modalAsignAgent')
@include('cliente.modal.modalGuardarNuevoCliente')
@include('cliente.modal.modalEditarCliente')
@include('cliente.modal.modalAsignarAgente')
@include('cliente.modal.callModal')
@include('cliente.modal.modalConfigTable')
@include('cliente.modal.modalConfigTableLocal')
@include('cliente.modal.modalCrearComentario')
@include('cliente.modal.modalChangeStatus')
@include('cliente.modal.modalAsignFolder')
@include('cliente.modal.modalSendMail')
@include('cliente.modal.modalChangeFolder') 
@include('cliente.modal.modalChangeGroupFolder')

@endsection
@section('script')
<script>
    var saveCustomerRoute = '{{ route("saveCustomer") }}';
    var searchAgentRoute = '{{ route("searchAgent") }}';
    var updateClientRoute = '{{ route("updateClient") }}';
    var deleteClientRoute = '{{ Route("deleteClient") }}';
    var changeStatusClienteRoute = '{{ Route("changeStatusClient") }}';
    var asignAgentRoute = '{{ route("asignAgent") }}';
    var assignGroupAgentRoute = '{{ route("assignGroupAgent") }}';
    var changeStatusGroupRoute = '{{ route("changeStatusGroup") }}';
    var token = '{{ csrf_token() }}';
    var initiateCallRoute = '{{ route("initiateCall") }}';
    var uploadExcelRoute = '{{ route("uploadExcel") }}';
    var saveConfigTableRoute = '{{ route("saveConfigTable") }}';
    var saveComentarioRoute = '{{ route("saveComentario") }}';
    var searchStatusRoute = '{{ route("searchStatus") }}';

    var asignFolderGroupRoute = '{{ route("addGroupClientFolder") }}';

    var filterOrderRoute = '{{ route("filterOrder") }}';
    var filterByAttrRoute = '{{ route("filterByAttr") }}';
    var filterByDateRoute = '{{ route("filterByDate") }}';

    var searchGeneralRoute = '{{ route("searchGeneralClient") }}';
    var sendMailRoute = '{{ route("sendMailClient") }}';
    var changeFolderRoute = '{{ route("changeFolderClient") }}';
    var liberarClienteRoute = '{{ route("liberarCliente") }}';
    var saveViewsRoute = '{{ route("saveViews") }}';
    var filterAdvancedRoute = '{{ route("filterAdvanced") }}';
    const folders = @json($folders);
</script>

<script src="{{asset('js/agent/assignAgent.js')}}"></script>
<script src="{{asset('js/agent/searchAgent.js')}}"></script>
<script src="{{ asset('js/customer/createClient.js') }}"></script>
<script src="{{ asset('js/customer/editClient.js') }}"></script>
<script src="{{ asset('js/customer/changeStatusClient.js') }}"></script>
<script src="{{ asset('js/customer/deleteClient.js') }}"></script>
<script src="{{ asset('js/customer/changeStatusGroup.js') }}"></script>
<script src="{{ asset('js/utils/mostrarNuevoModal.js') }}"></script>
<script src="{{ asset('js/utils/getIp.js') }}"></script>
<script src="{{ asset('js/agent/assignGroupAgent.js') }}"></script>
<script src="{{ asset('js/utils/mostrarMensaje.js') }}"></script>
<script src="{{ asset('js/voiso/initiateCall.js') }}"></script>
<script src="{{ asset('js/customer/uploadExcel.js') }}"></script>
<script src="{{ asset('js/customer/saveConfigTable.js') }}"></script>
<script src="{{ asset('js/customer/saveConfigTableLocal.js') }}"></script>
<script src="{{ asset('js/comentario/guardarComentario.js') }}"></script>
<script src="{{ asset('js/customer/searchStatus.js') }}"></script>
<script src="{{ asset('js/customer/freeClient.js') }}"></script>
<script src="{{ asset('js/views/vistas.js') }}"></script>
<script src="{{ asset('js/filter/filter.js') }}"></script>
{{-- <script src="{{ asset('js/folder/asignFolderGroup.js') }}"></script> --}}

<script src="{{ asset('js/folder/addGroupClientFolder.js') }}"></script>

<script src="{{ asset('js/customer/filterAdvance.js') }}"></script>

<script src="{{ asset('js/customer/client.js') }}"></script>
<script src="{{ asset('js/mail/mail.js') }}"></script>
<script src="{{ asset('js/folder/folder.js') }}"></script>

<!-- SUMMERNOTE -->
<script src="{{ asset('js/plugins/summernote/summernote-bs4.js') }}"></script>

<script>
    $(document).on('click', '.dropdown-item', function(e) {
        e.preventDefault();
        $('#filterButton').text($(this).text());
    });
</script>

<script>
    $(document).ready(function() {

        $('.summernote').summernote();
        // Cargar datos iniciales con el limit actual
        let initialLimit = $('#limit').val();
        fetch_data(1, initialLimit);

        // Cambiar cantidad de registros por página
        $(document).on('change', '#limit', function() {
            let limit = $(this).val();
            fetch_data(1, limit); // Cargar la primera página cuando cambia el límite
        });

        // Paginación
        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            let limit = $('#limit').val();
            fetch_data(page, limit);
        });

        function fetch_data(page, limit) {
            $.ajax({
                url: "/clientsPagination?page=" + page + "&limit=" + limit,
                success: function(data) {
                    $('#tabClient').html(data);
                }
            });
        }


        $('.dataTables-example').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                { extend: 'copy'},
                {extend: 'csv'},
                {extend: 'excel', title: 'ExampleFile'},
                {extend: 'pdf', title: 'ExampleFile'},

                {extend: 'print',
                 customize: function (win){
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');

                        $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                }
                }
            ]

        });

    });

</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        markNotificationsAsSeen('clients');
    });
</script>
<script src="{{ asset('js/utils/viewCheck.js') }}"></script>
@endsection
