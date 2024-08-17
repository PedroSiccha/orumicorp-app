@extends('layouts.app')
@section('title')
    Administrar Shoter
@endsection
@section('content')
<div class="row">
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-content">
                <div class="file-manager">
                    <h5>Ver Carpetas:</h5>
                    @foreach ($categoryFolders as $categoryFolder)
                        <a onclick="viewFolder({categoryId: '{{ $categoryFolder->id }}', tableName: '#folders'})" class="file-control active">{{ $categoryFolder->name }}</a>
                    @endforeach
                    <div class="hr-line-dashed"></div>
                    <button class="btn btn-primary btn-block" onclick="mostrarNuevoModal('#modalCrearFolder')">Crear Carpeta</button>
                    <div class="hr-line-dashed"></div>
                    <h5>Carpetas</h5>
                    <ul class="folder-list" style="padding: 0" id="folders">
                        @include('shooter.components.listFolder')
                    </ul>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-5">
        <div class="ibox">
            <div class="ibox-content" id="listClientFolder">
                <div class="widget  p-lg text-center">
                    <div class="m-b-md">
                        <i class="fa fa-files-o fa-4x"></i>
                        <h1 class="m-xs">0</h1>
                        <h3 class="font-bold no-margins">
                            No Data
                        </h3>
                        {{-- <small>amount</small> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="ibox selected">

            <div class="ibox-content" id="detailClientData">
                <div class="tab-content">

                    <div class="widget  p-lg text-center">
                        <div class="m-b-md">
                            <i class="fa fa-file-o fa-4x"></i>
                            <h1 class="m-xs">0</h1>
                            <h3 class="font-bold no-margins">
                                No Data
                            </h3>
                            {{-- <small>amount</small> --}}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@include('shooter.modal.modalCrearFolder')
@include('shooter.modal.modalEditarFolder')
@include('shooter.modal.modalAddClient')

@endsection
@section('script')
<script>
    var viewFolderRoute = '{{ route("viewFolder") }}';
    var viewListClientsRoute = '{{ route("viewListClients") }}';
    var deleteFolderRoute = '{{ route("deleteFolder") }}';
    var addGroupClientFolderRoute = '{{ route("addGroupClientFolder") }}';
    var saveFolderRoute = '{{ route("saveFolder") }}';
    var editFolderRoute = '{{ route("editFolder") }}';
    var addClientFolderRoute = '{{ route("addClientFolder") }}';
    var searchClientRoute = '{{ Route("searchCustomer") }}';
    var viewResumClientRoute = '{{ Route("viewResumClient") }}';
    var token = '{{ csrf_token() }}';
</script>

<script src="{{ asset('js/utils/mostrarNuevoModal.js') }}"></script>
<script src="{{ asset('js/utils/mostrarMensaje.js') }}"></script>
<script src="{{ asset('js/shooter/viewFolder.js') }}"></script>
<script src="{{ asset('js/shooter/viewListClients.js') }}"></script>
<script src="{{ asset('js/shooter/viewResumClient.js') }}"></script>

<script src="{{ asset('js/folder/deleteFolder.js') }}"></script>
<script src="{{ asset('js/folder/addGroupClientFolder.js') }}"></script>
<script src="{{ asset('js/folder/createFolder.js') }}"></script>
<script src="{{ asset('js/folder/assignedClientFolder.js') }}"></script>
<script src="{{ asset('js/folder/changeNameFolder.js') }}"></script>
<script src="{{ asset('js/customer/searchClient.js') }}"></script>

@endsection
