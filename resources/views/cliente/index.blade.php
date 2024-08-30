@extends('layouts.app')

@section('title')
Clientes
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title d-flex justify-content-between align-items-center">
                <h5>Tabla Clientes </h5>
                <div>
                    {{-- @can('Asignar Cliente Masivo') --}}


                    <button id="asignarFolderBtn" type="button" class="btn btn-default" type="button"
                        onclick="mostrarNuevoModal('#modalAsignFolder')" style="display: none;"><i
                            class="fa fa-folder-open"></i> Asignar Folder</button>
                    <button id="liberarClienteBtn" type="button" class="btn btn-danger" type="button"
                        onclick="liberarCliente()" style="display: none;"><i
                            class="fa fa-minus-square"></i> Liberar Cliente</button>
                    <button id="asignarBtn" type="button" class="btn btn-info" type="button"
                        onclick="mostrarNuevoModal('#modalAsignAgent')" style="display: none;"><i
                            class="fa fa-group"></i> Asignar Agente</button>
                    <button id="changeStatusBtn" type="button" class="btn btn-warning" type="button"
                        onclick="mostrarNuevoModal('#modalChangeStatus')" style="display: none;"><i
                            class="fa fa-retweet"></i> Cambiar Estado</button>
                    {{-- @endcan --}}
                    {{-- @can('Crear Cliente') --}}
                    <button type="button" class="btn btn-default" type="button"
                        onclick="mostrarNuevoModal('#modalCliente')"><i class="fa fa-plus"></i> Nuevo Cliente</button>
                    {{-- @endcan
                    @can('Carga Masiva de Cliente') --}}
                    <button type="button" class="btn btn-success" type="button"
                        onclick="mostrarNuevoModal('#modalChargeGroup')"><i class="fa fa-upload"></i> Carga
                        Masiva</button>
                    {{-- @endcan --}}
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
                    <div class="col-sm-5 m-b-xs">
                        <select class="form-control-sm form-control input-s-sm inline" id="statusCustomerId" onchange="searchStatus({ customerStatusId: '#statusCustomerId', tableName: '#tabClient' })">
                            <option>Seleccione un estado</option>
                            @foreach ($statusCustomers as $statusCustomer)
                                <option value="{{ $statusCustomer->id }}">{{ $statusCustomer->name }}</option>
                            @endforeach
                        </select>
                    </div>
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
<script src="{{ asset('js/folder/asignFolderGroup.js') }}"></script>


<script>
    $(document).ready(function() {
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
<script src="{{ asset('js/utils/viewCheck.js') }}"></script>
@endsection
