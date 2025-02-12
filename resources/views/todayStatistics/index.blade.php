@extends('layouts.app')

@section('title')
      Statistics Today
@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight ecommerce">
    <div class="ibox-content m-b-sm border-bottom">
        <div class="row">
            <div class="col-sm-2">
                <button class="btn btn-primary " type="button"><i class="fa fa-area-chart"></i> TODAY STATISTICS</button>
            </div>
            @if (auth()->check() && auth()->user()->hasRole('ADMINISTRADOR'))
            <div class="col-sm-4">
                @can('Filtrar Today')
                <div class="input-group date">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="date_added_init" type="text" class="form-control" value="01/01/2024">
                </div>
                @endcan
            </div>
            <div class="col-sm-4">
                @can('Filtrar Today')
                <div class="input-group date">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="date_added_end" type="text" class="form-control" value="12/31/2024" onchange="filterStatistics('#area', '#date_added_init', '#date_added_end', '#tabStatistics')">
                </div>
                @endcan
            </div>
            <div class="col-sm-2 text-right">
                @can('Filtrar Area Today')
                    <select class="form-control m-b" name="area" id="area" onchange="filterStatistics('#area', '#date_added_init', '#date_added_end', '#tabStatistics')" onclick="filterStatistics('#area', '#date_added_init', '#date_added_end', '#tabStatistics')">
                        @foreach($areas as $area)
                        <option value = "{{ $area->id }}">{{ $area->name }}</option>
                        @endforeach
                    </select>
                @endcan
            </div>
            @endif
        </div>
    </div>
</div>

<div class="row">
      <div class="col-lg-12">
          <div class="ibox ">
              <div class="ibox-title">
                  {{-- <h5>Tabla Ventas </h5> --}}
                  <div class="ibox-tools">
                  </div>
              </div>
              <div class="ibox-content" id="tabStatistics">

                  <table class="table table-striped">
                      <thead>
                      <tr>
                          <th>N°</th>
                          @can('Tabla Today Statistics - Ver Agente')
                            <th>Agente</th>
                          @endcan
                          @can('Tabla Today Statistics - Ver Venta del Día')
                            <th>Ventas del Día</th>
                          @endcan
                          @can('Tabla Today Statistics - Ver Venta del Mes')
                            <th>Ventas del Mes</th>
                          @endcan
                          @can('Tabla Today Statistics - Ver Monto del Día')
                            <th>Monto del Día</th>
                          @endcan
                          @can('Tabla Today Statistics - Ver Monto del Mes')
                            <th>Monto del Mes</th>
                          @endcan
                          @can('Tabla Today Statistics - Ver Call Over Triger')
                            <th>Call over triger</th>
                          @endcan
                          @can('Tabla Today Statistics - Ver Total Calls')
                            <th>Total calls</th>
                          @endcan
                          @can('Tabla Today Statistics - Ver Retiros')
                            <th>Retiros</th>
                          @endcan
                          @can('Tabla Today Statistics - Ver Chargeback')
                            <th>Chargeback</th>
                          @endcan

                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($sales as $sale)

                            <tr>
                                <td>{{ $sale->id }}</td>
                                @can('Tabla Today Statistics - Ver Agente')
                                    <td>{{ $sale->name }} {{ $sale->lastname }}</td>
                                @endcan
                                @can('Tabla Today Statistics - Ver Venta del Día')
                                    <td>{{ $sale->total_sales_day }}</td>
                                @endcan
                                @can('Tabla Today Statistics - Ver Venta del Mes')
                                    <td>{{ $sale->total_sales_month }}</td>
                                @endcan
                                @can('Tabla Today Statistics - Ver Monto del Día')
                                    <td>$ {{ number_format($sale->total_amount_day, 2) }}</td>
                                @endcan
                                @can('Tabla Today Statistics - Ver Monto del Mes')
                                    <td>$ {{ number_format($sale->total_amount_month, 2) }}</td>
                                @endcan
                                @can('Tabla Today Statistics - Ver Call Over Triger')
                                    <td>0 (00:00:00)</td>
                                @endcan
                                @can('Tabla Today Statistics - Ver Total Calls')
                                    <td>0 (00:00:00)</td>
                                @endcan
                                @can('Tabla Today Statistics - Ver Retiros')
                                    <td>$ {{ number_format(0, 2) }}</td>
                                @endcan
                                @can('Tabla Today Statistics - Ver Chargeback')
                                    <td>$ {{ number_format(0, 2) }}</td>
                                @endcan
                            </tr>

                        @endforeach
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
  </div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('#date_added_init').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
        });
        $('#date_added_end').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
        });
    });
    var filterStatisticsRoute = '{{ route("filterStatistics") }}';
    var token = '{{ csrf_token() }}';
</script>
<script src="{{ asset('js/statisticsToday/filterStatistics.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        markNotificationsAsSeen('todaystatistics');
    });
</script>
@endsection
