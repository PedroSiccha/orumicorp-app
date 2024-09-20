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
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Ver Carpetas:</h5>
                        @can('Crear Categoria Folder')
                            <button class="btn btn-default" onclick="mostrarNuevoModal('#modalCrearCategory')">
                                <i class="fa fa-plus"></i>
                            </button>
                        @endcan
                    </div>
                    @foreach ($categoryFolders as $categoryFolder)
                        <a onclick="viewFolder({categoryId: '{{ $categoryFolder->id }}', tableName: '#folders'})" class="file-control active">{{ $categoryFolder->name }}</a>
                    @endforeach
                    <div class="hr-line-dashed"></div>
                    @can('Crear Carpeta')
                    <button class="btn btn-primary btn-block" onclick="mostrarNuevoModal('#modalCrearFolder')">Crear Carpeta</button>
                    @endcan
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
@include('shooter.modal.modalCargaMasivaShooter')
@include('shooter.modal.modalCrearCategory')

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
    var saveCategoryFolderRoute = '{{ Route("saveCategoryFolder") }}';
    var token = '{{ csrf_token() }}';
    var uploadExcelRoute = '{{ route("uploadExcel") }}';
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

<script src="{{ asset('js/categoryFolder/saveCategoryFolder.js') }}"></script>

<script src="{{ asset('js/shooter/uploadExcelbyFolder.js') }}"></script>
<script src="{{ asset('js/shooter/modalCargaMasiva.js') }}"></script>

@endsection
