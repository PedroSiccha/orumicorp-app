@extends('layouts.app')

@section('title')
      Part Time
@endsection

@section('content')
<div class="row">

      <div class="col-lg-5">
          <div class="ibox ">
              <div class="ibox-title">
                  {{-- <h5>Data Picker <small>https://github.com/eternicode/bootstrap-datepicker</small></h5> --}}
                  <div class="ibox-tools">
                      <a class="collapse-link">
                          <i class="fa fa-chevron-up"></i>
                      </a>
                      <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                          <i class="fa fa-wrench"></i>
                      </a>
                      <ul class="dropdown-menu dropdown-user">
                          <li><a href="#" class="dropdown-item">Config option 1</a>
                          </li>
                          <li><a href="#" class="dropdown-item">Config option 2</a>
                          </li>
                      </ul>
                      <a class="close-link">
                          <i class="fa fa-times"></i>
                      </a>
                  </div>
              </div>
              <div class="ibox-content" id="panelButton">
                @can('Registrar Asistencia')
                <h3>
                    Registro de Asistencia
                </h3>

                <div class="form-group" id="data_2">
                    <label class="font-normal">Entrada</label>
                    @if ( $dateIn )
                        <button class="btn btn-outline btn-success  dim form-control" type="button"><i class="fa fa-address-card-o"></i> {{ $dateIn->hour }}</button>
                    @else
                    <button class="btn btn-outline btn-success  dim form-control" type="button" onclick="registerAssitance('{{ date('Y-m-d') }}', '#comentario', 'IN', '#panelButton', '#tabAssistance')"><i class="fa fa-address-card-o"></i> Marcar Entrada</button>
                    @endif
                </div>

                <div class="form-group" id="data_3">
                    <label class="font-normal">Break</label>
                    @if ( $dateBreakIn )
                        <button class="btn btn-outline btn-warning  dim form-control" type="button"><i class="fa fa-cutlery"></i> <i class="fa fa-arrow-circle-o-left"></i> {{ $dateBreakIn->hour }}</button>
                    @else
                        <button class="btn btn-outline btn-warning  dim form-control" type="button" onclick="registerAssitance('{{ date('Y-m-d') }}', '#comentario', 'IN-BREAK', '#panelButton', '#tabAssistance')"><i class="fa fa-cutlery"></i> <i class="fa fa-arrow-circle-o-left"></i> Marcar Salia Break</button>
                    @endif
                </div>

                <div class="form-group" id="data_3">
                    <label class="font-normal">Break</label>
                    @if ( $dateBreakOut )
                        <button class="btn btn-outline btn-primary  dim form-control" type="button"><i class="fa fa-cutlery"></i> <i class="fa fa-arrow-circle-o-right"></i> {{ $dateBreakOut->hour }}</button>
                    @else
                        <button class="btn btn-outline btn-primary  dim form-control" type="button" onclick="registerAssitance('{{ date('Y-m-d') }}', '#comentario', 'OUT-BREAK', '#panelButton', '#tabAssistance')"><i class="fa fa-cutlery"></i> <i class="fa fa-arrow-circle-o-right"></i> Marcar Vuelta Break</button>
                    @endif
                </div>

                <div class="form-group" id="data_4">
                    <label class="font-normal">Salida</label>
                    @if ( $dateOut )
                        <button class="btn btn-outline btn-danger  dim form-control" type="button"><i class="fa fa-bus"></i> {{ $dateOut->hour }}</button>
                    @else
                        <button class="btn btn-outline btn-danger  dim form-control" type="button" onclick="registerAssitance('{{ date('Y-m-d') }}', '#comentario', 'OUT', '#panelButton', '#tabAssistance')"><i class="fa fa-bus"></i> Marcar Salida</button>
                    @endif
                </div>

                <div class="form-group row"><label class="col-lg-2 col-form-label">Comentarios</label>
                      <div class="col-lg-10">
                        <textarea class="form-control" placeholder="Ingrese su comentario" id="comentario"></textarea>
                      </div>
                  </div>
                @endcan
              </div>
          </div>
      </div>
      <div class="col-lg-7">
          <div class="ibox ">
              <div class="widget style1 navy-bg">
                  <div class="row">
                      <div class="col-4">
                          <i class="fa fa-clock-o fa-5x"></i>
                      </div>
                      <div class="col-8 text-right">
                        <h1><b>{{ date('d/m/Y'); }}</b></h1>
                        <div id="clock" class="clock-style"></div>
                      </div>
                  </div>
              </div>
          </div>
          </div>
          </div>

          <div class="wrapper wrapper-content animated fadeInRight ecommerce">
            @can('Filtrar Historial de Asistencias')
            <div class="ibox-content m-b-sm border-bottom">
                <div class="row">
                    <div class="col-sm-4">
                        <h3>Filtrar Fechas</h3>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group date">

                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="date_added_init" type="text" class="form-control" value="03/04/2014">
                        </div>
                    </div>
                    <div class="col-sm-4 text-right">
                        <div class="input-group date">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="date_added_end" type="text" class="form-control" value="03/04/2014" onchange="filterAssitance('#date_added_init', '#date_added_end')">
                        </div>
                    </div>
                </div>
            </div>
            @endcan
        </div>


          <div class="row">
            <div class="col-lg-12">
            <div class="ibox ">
                @can('Ver Historial de Asistencias')
                <div class="ibox-title">
                    <h5>Historial</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#" class="dropdown-item">Config option 1</a>
                            </li>
                            <li><a href="#" class="dropdown-item">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link" >
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content" id="tabAssistance">
                    <table class="table table-striped">
                        <thead>
                          <tr>
                                <th>Fecha de Asistencia</th>
                                <th>Nombre del Agente</th>
                                <th>Hora de Ingreso</th>
                                <th>Hora de Break</th>
                                <th>Vuelta de Break</th>
                                <th>Hora de Salida</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($assistances as $assistance)
                              <tr>
                                <td>{{ $assistance->date }}</td>
                                <td>{{ $assistance->name }} {{ $assistance->lastname }}</td>
                                <td>{{ $assistance->IN }}</td>
                                <td>{{ $assistance->INBREAK }}</td>
                                <td>{{ $assistance->OUTBREAK }}</td>
                                <td>{{ $assistance->OUT }}</td>
                              </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
                @endcan
            </div>
        </div>
      </div>

      <style>
            .clock-style {
                font-size: 2em;
                font-weight: bold;
                text-align: center;
                margin: 50px;
                font-family: 'Arial', sans-serif;
            }
        </style>

      <script>
            function updateClock() {
                const now = new Date();
                const hours = now.getHours().toString().padStart(2, '0');
                const minutes = now.getMinutes().toString().padStart(2, '0');
                const seconds = now.getSeconds().toString().padStart(2, '0');

                const timeString = `${hours}:${minutes}:${seconds}`;
                document.getElementById('clock').innerText = timeString;
            }
            setInterval(updateClock, 1000);
            updateClock();
        </script>

@endsection
@section('script')
<script>
    var registerAssitanceRoute = '{{ route("registerAssistance") }}';
    var filterAssitanceRoute = '{{ route("filterAssistance") }}';
    var token = '{{ csrf_token() }}';
</script>
<script src="{{ asset('js/partTime/registerAssitance.js') }}"></script>

@endsection
