@extends('layouts.app')
@section('title')
Shooter
@endsection
@section('content')
<div class="wrapper wrapper-content animated fadeInRight d-flex justify-content-center">
    <div class="widget navy-bg p-lg text-center col-lg-4 m-2" onclick="activarShooter()">
        <div class="m-b-md">
            <i class="fa fa-check fa-4x"></i>
            <h1 class="m-xs">ACTIVAR</h1>
            <h3 class="font-bold no-margins">
            </h3>
            <small>Activa el shooter.</small>
        </div>
    </div>
    <div class="widget white-bg p-lg text-center col-lg-4 m-2">
        <div class="m-b-md">
            <i class="fa fa-shield fa-4x"></i>
            <h1 class="m-xs">ADMINISTRAR</h1>
            <h3 class="font-bold no-margins">
            </h3>
            <small>Administre shooter.</small>
        </div>
    </div>



</div>
@include('shooter.table.tableShooter')

@endsection
@section('script')
<script src="{{ asset('js/shooter/activarShooter.js') }}"></script>
<script src="{{ asset('js/utils/mostrarMensaje.js') }}"></script>
@endsection
