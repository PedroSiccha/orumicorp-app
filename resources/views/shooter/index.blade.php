@extends('layouts.app')
@section('title')
Shooter
@endsection
@section('content')
<div class="wrapper wrapper-content animated fadeInRight d-flex justify-content-center" id="btnActiveAdmin">
    @can('Activar Shooter')
        @if ($shooter)
            <div class="widget red-bg p-lg text-center col-lg-4 m-2" onclick="disableShooter({ shooter_id: '{{ $shooter->id }}', tableName: '#btnActiveAdmin', secondTableName: '#tabShooter'})">
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
    @endcan
    @can('Administrar Shooter')
        @if (auth()->check() && auth()->user()->hasRole('ADMINISTRADOR'))
        <a class="widget white-bg p-lg text-center col-lg-4 m-2" href="{{ Route('administrarShoter') }}">
            <div class="m-b-md">
                <i class="fa fa-shield fa-4x"></i>
                <h1 class="m-xs">ADMINISTRAR</h1>
                <h3 class="font-bold no-margins">
                </h3>
                <small>Administre shooter.</small>
            </div>
        </a>
        @endif
    @endcan
</div>
<div class="ibox-content">
    @can('Lista Shooter')
    {{-- <div class="table-responsive" id="tabShooter">
        @include('shooter.table.tableShooter')
    </div> --}}
    @endcan
</div>
@include('shooter.modal.modalActivarShooter')
@include('cliente.modal.modalCrearComentario')

@endsection
@section('script')
<script src="{{ asset('js/shooter/activarShooter.js') }}"></script>
<script src="{{ asset('js/shooter/disableShooter.js') }}"></script>
<script src="{{ asset('js/utils/mostrarMensaje.js') }}"></script>
<script src="{{ asset('js/voiso/initiateCall.js') }}"></script>
<script src="{{ asset('js/comentario/guardarComentario.js') }}"></script>

<script src="{{ asset('js/utils/mostrarNuevoModal.js') }}"></script>
<script>
    var activeShooterRoute = '{{ route("activeShooter") }}';
    var disableShooterRoute = '{{ route("disableShooter") }}';
    var initiateCallRoute = '{{ route("initiateCall") }}';
    var saveComentarioRoute = '{{ route("saveComentario") }}';
    var token = '{{ csrf_token() }}';
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        markNotificationsAsSeen('shooter');
    });
</script>
@endsection
