@extends('layouts.app')

@section('title')
      Tablero
@endsection

@section('content')
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

@endsection
@section('script')
<script src="{{asset('js/utils/fechaActual.js')}}"></script>
<script>
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
