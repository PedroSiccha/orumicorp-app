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
            <div class="col-sm-4">
                @can('Filtrar Today')
                <div class="input-group date">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="date_added" type="text" class="form-control" value="03/04/2014">
                </div>
                @endcan
            </div>
            <div class="col-sm-4">
                @can('Filtrar Today')
                <div class="input-group date">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="date_added" type="text" class="form-control" value="03/04/2014">
                </div>
                @endcan
            </div>
            <div class="col-sm-2 text-right">
                @can('Filtrar Area Today')
                <button class="btn btn-primary " type="button"><i class="fa fa-check"></i> RETENCIÓN</button>
                @endcan
            </div>
        </div>
    </div>
</div>

<div class="row">
      <div class="col-lg-12">
          <div class="ibox ">
              <div class="ibox-title">
                  {{-- <h5>Tabla Ventas </h5> --}}
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
              <div class="ibox-content">

                  <table class="table table-striped">
                      <thead>
                      <tr>
                          <th>N°</th>
                          <th>Agente</th>
                          <th>Monto del Día</th>
                          <th>Monto del Mes</th>
                          <th>Call over triger</th>
                          <th>Total calls</th>
                          <th>Retiros</th>
                          <th>Chargeback</th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($sales as $sale)

                            <tr>
                                <td>{{ $sale->id }}</td>
                                <td>{{ $sale->name }} {{ $sale->lastname }}</td>
                                <td>S/. {{ number_format($sale->total_amount_day, 2) }}</td>
                                <td>S/. {{ number_format($sale->total_amount_month, 2) }}</td>
                                <td>8 (01:02:24)</td>
                                <td>107 (01:33:12)</td>
                                <td>$ 3500.00</td>
                                <td>$ 2000.00</td>
                            </tr>

                        @endforeach
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
  </div>
@endsection
