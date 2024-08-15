@extends('layouts.app')
@section('title')
Shooter
@endsection
@section('content')
<div class="wrapper wrapper-content animated fadeInRight d-flex justify-content-center">
    @if ($shooter)
    {{ $shoter }}
        <div class="widget red-bg p-lg text-center col-lg-4 m-2" onclick="activarShooter()">
            <div class="m-b-md">
                <i class="fa fa-pause fa-4x"></i>
                <h1 class="m-xs">PAUSAR</h1>
                <h3 class="font-bold no-margins">
                </h3>
                <small>Pausar el shooter.</small>
            </div>
        </div>
    @else
        <div class="widget navy-bg p-lg text-center col-lg-4 m-2" onclick="mostrarNuevoModal('#modalActivarShooter')">
            <div class="m-b-md">
                <i class="fa fa-play fa-4x"></i>
                <h1 class="m-xs">ACTIVAR</h1>
                <h3 class="font-bold no-margins">
                </h3>
                <small>Activa el shooter.</small>
            </div>
        </div>
    @endif

    <a class="widget white-bg p-lg text-center col-lg-4 m-2" href="{{ Route('administrarShoter') }}">
        <div class="m-b-md">
            <i class="fa fa-shield fa-4x"></i>
            <h1 class="m-xs">ADMINISTRAR</h1>
            <h3 class="font-bold no-margins">
            </h3>
            <small>Administre shooter.</small>
        </div>
    </a>



</div>
<div class="ibox-content">
    <div class="table-responsive" id="tabShooter">
        @include('shooter.table.tableShooter')
    </div>
</div>
@include('shooter.modal.modalActivarShooter')

@endsection
@section('script')
<script src="{{ asset('js/shooter/activarShooter.js') }}"></script>
<script src="{{ asset('js/utils/mostrarMensaje.js') }}"></script>

<script src="{{ asset('js/utils/mostrarNuevoModal.js') }}"></script>
@endsection
