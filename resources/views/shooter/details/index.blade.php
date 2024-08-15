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
                        <a onclick="verCarpeta('{{ $categoryFolder->id }}')" class="file-control active">{{ $categoryFolder->name }}</a>
                    @endforeach
                    <div class="hr-line-dashed"></div>
                    <button class="btn btn-primary btn-block">Crear Carpeta</button>
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
            <div class="ibox-content">
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

            <div class="ibox-content">
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
@endsection
