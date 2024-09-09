@extends('layouts.app')

@section('title')
      Tablero
@endsection

@section('content')
@if (auth()->check() && auth()->user()->hasRole('PROVEEDOR'))
<div class="row">
    <div class="col-lg-4">
        <div class="ibox ">
            <div class="ibox-title">
                <span class="label label-success float-right">{{ \Carbon\Carbon::now()->translatedFormat('F') }}</span>
                <h5>Clientes Registrados</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins">{{ $cantClientsRegisterProvider }}</h1>
                <div class="stat-percent font-bold text-success">{{ $percentClientsRegisterProvider }}% <i class="fa fa-users"></i></div>
                <small>Total Clientes</small>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="ibox ">
            <div class="ibox-title">
                <span class="label label-info float-right">{{ \Carbon\Carbon::now()->translatedFormat('F') }}</span>
                <h5>Clientes Activados</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins">{{ $cantClientsActiveProvider }}</h1>
                <div class="stat-percent font-bold text-info">{{ $percentClientsActiveProvider }}% <i class="fa fa-check"></i></div>
                <small>Clientes Activos</small>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="ibox ">
            <div class="ibox-title">
                <span class="label label-warning float-right">{{ \Carbon\Carbon::now()->year }}</span>
                <h5>Clientes Anuales</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins">{{ $cantClientsProvider }}</h1>
                <div class="stat-percent font-bold text-warning"> <i class="fa fa-calendar"></i></div>
                <small>Registro de clientes durante el año</small>
            </div>
        </div>
    </div>

</div>

<div class="row">

    {{-- <div class="col-lg-4">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Mensajes</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content ibox-heading">
                <h3><i class="fa fa-envelope-o"></i> Nuevo Mensaje</h3>
                <small><i class="fa fa-tim"></i> Usted tiene 3 mensajes.</small>
            </div>
            <div class="ibox-content">
                <div class="feed-activity-list">

                    <div class="feed-element">
                        <div>
                            <small class="float-right text-navy">1m ago</small>
                            <strong>Monica Smith</strong>
                            <div>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum</div>
                            <small class="text-muted">Today 5:60 pm - 12.06.2014</small>
                        </div>
                    </div>

                    <div class="feed-element">
                        <div>
                            <small class="float-right">2m ago</small>
                            <strong>Jogn Angel</strong>
                            <div>There are many variations of passages of Lorem Ipsum available</div>
                            <small class="text-muted">Today 2:23 pm - 11.06.2014</small>
                        </div>
                    </div>

                    <div class="feed-element">
                        <div>
                            <small class="float-right">5m ago</small>
                            <strong>Jesica Ocean</strong>
                            <div>Contrary to popular belief, Lorem Ipsum</div>
                            <small class="text-muted">Today 1:00 pm - 08.06.2014</small>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div> --}}

    <div class="col-lg-8">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Posicionamiento de Clientes</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content table-responsive">
                <table class="table table-hover no-margins">
                    <thead>
                    <tr>
                        <th>Estado</th>
                        <th>Fecha Registro</th>
                        <th>Cliente</th>
                        {{-- <th>Carpeta</th> --}}
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($listClientsProvider as $clientProvider)
                        <tr>
                            <td><small>{{ $clientProvider->statusCustomer->name }}</small></td>
                            <td><i class="fa fa-clock-o"></i> {{ $clientProvider->date_admission }}</td>
                            <td>{{ $clientProvider->name }} {{ $clientProvider->lastname }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="ibox-content">
            <div>
                <div class="row">
                    {{-- <div class="col-lg-12">
                        <div class="widget style1 lazur-bg">
                            <div class="row vertical-align">
                                <div class="col-3">
                                    <i class="fa fa-plus fa-3x"></i>
                                </div>
                                <div class="col-9 text-right">
                                    <h2 class="font-bold">Registrar Cliente</h2>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-lg-12" onclick="mostrarNuevoModal('#modalChargeGroup')">
                        <div class="widget style1 navy-bg">
                            <div class="row vertical-align">
                                <div class="col-3">
                                    <i class="fa fa-group fa-3x"></i>
                                </div>
                                <div class="col-9 text-right">
                                    <h2 class="font-bold">Carga Masiva</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@else

<div class="row">

    @can('Ver Ventas Tablero')
        <div class="col-lg-6">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Ventas</h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-6">
                            <h1 class="no-margins">$ {{ number_format($montoVenta, 2) }}</h1>
                            <div class="font-bold text-navy"> <i class="fa fa-level-up"></i> <small>Área de Ventas</small></div>
                        </div>
                        <div class="col-md-6">
                            <h1 class="no-margins">$ {{ number_format($montoRetencion, 2) }}</h1>
                            <div class="font-bold text-navy"> <i class="fa fa-level-up"></i> <small>Área de Retenciones</small></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan

    @can('Ver Cantidad Agentes Tablero')
        <div class="col-lg-3">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Agentes</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ $cantAgents }}</h1>
                    <div class="stat-percent font-bold text-success"><i class="fa fa-bolt"></i></div>
                    <br>
                </div>
            </div>
        </div>
    @endcan

    @can('Ver Cantidad Clientes Tablero')
        <div class="col-lg-3">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Clientes</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ $cantClients }}</h1>
                    <div class="stat-percent font-bold text-info"> <i class="fa fa-level-up"></i></div>
                    <br>
                </div>
            </div>
        </div>
    @endcan
</div>

@can('Estadistica de Ventas')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div>
                        <span class="float-right text-right">
                            Total de Ventas: $ {{ number_format($montoVenta + $montoRetencion, 2) }}
                        </span>
                        <h3 class="font-bold no-margins">
                            Ventas
                        </h3>
                    </div>
                    <div class="m-t-sm">
                        <div class="row">
                            <div class="col-md-12">
                                <div>
                                    <canvas id="lineChart" height="114"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="m-t-md">
                        <small class="float-left">
                            <i class="fa fa-clock-o"> </i>
                            Actualizado <span id="fecha_actual"></span>
                        </small>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endcan

@can('Rankig de Ventas Tablero')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Ranking de Ventas </h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>

                                <th>#</th>
                                <th>Área </th>
                                <th>Nombre </th>
                                <th>Monto </th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($montosPorAgente as $index => $rankingagent)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $rankingagent->area }}</td>
                                    <td>{{ $rankingagent->name }} {{ $rankingagent->lastname }}</td>
                                    <td>$ {{ number_format($rankingagent->monto, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endcan
@endif

@include('cliente.modal.modalChargeGroup')

@endsection
@section('script')
<script src="{{asset('js/utils/fechaActual.js')}}"></script>
<script src="{{ asset('js/utils/mostrarNuevoModal.js') }}"></script>
<script src="{{ asset('js/utils/mostrarMensaje.js') }}"></script>
<script>

    var token = '{{ csrf_token() }}';

    $(document).ready(function() {
        $.ajax({
            url: "{{ route('obtenerDatosVentas') }}",
            type: "GET",
            success: function(data) {
                var lineData = {
                    labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                    datasets: data.datasets
                };

                var lineOptions = {
                    responsive: true
                };

                var ctx = document.getElementById("lineChart").getContext("2d");
                new Chart(ctx, {type: 'line', data: lineData, options:lineOptions});
            }
        });
    });
</script>
@endsection
