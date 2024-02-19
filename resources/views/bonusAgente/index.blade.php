@extends('layouts.app')

@section('title')
      Bonus de Agente
@endsection

@section('content')
<div class="row">
      <div class="col-lg-12">
          <div class="ibox ">
              <div class="ibox-title d-flex justify-content-between align-items-center">
                  <h5>Tabla Bonus </h5>
                  <div>
                    <button type="button" class="btn btn-default" type="button" onclick="registrarBonus()"><i class="fa fa-plus"></i> Registrar Bonus</button>
                  </div>
              </div>
              <div class="ibox-content">

                  <table class="table table-striped">
                      <thead>
                      <tr>
                          <th>Fecha de Ingreso</th>
                          <th>ID de Cliente</th>
                          <th>Nombre del Cliente</th>
                          <th>Monto</th>
                          <th>Porcentaje</th>
                          <th>Comisión</th>
                          <th>Tipo de Cambio</th>
                          <th>Comisión en Soles</th>
                          <th>Agente</th>
                          <th>Area</th>
                          <th>Comentario</th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($sales as $sale)

                            <tr>
                                <td>{{ date("d/m/Y", strtotime($sale->date_admission)) }}</td>
                                <td>{{ $sale->customer->id }}</td>
                                <td>{{ $sale->customer->name }} {{ $sale->customer->lastname }}</td>
                                <td> $ {{ number_format($sale->amount / $sale->exchangeRate->amount, 2) }} </td>
                                <td>{{ $sale->percent->description }}</td>
                                <td> $ {{ number_format($sale->commission->amount / $sale->exchangeRate->amount, 2) }}</td>
                                <td>{{ $sale->exchangeRate->name }}</td>
                                <td>{{ $sale->commission->name }}</td>
                                <td>{{ $sale->agent->name }} {{ $sale->agent->lastname }}</td>
                                <td>{{ $sale->agent->area->name }}</td>
                                <td>{{ $sale->obsercation }}</td>
                            </tr>

                        @endforeach

                      </tbody>
                  </table>
              </div>
          </div>
      </div>
  </div>

  <div class="col-lg-12">
      <div class="ibox ">
          <div class="ibox-title">
              <h5>Totales  </h5>
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

              <table class="table table-hover">
                  <thead>
                  </thead>
                  <tbody>
                  <tr style="background-color: #4ef34e;">
                      <td>TARGET MENSUAL</td>
                      <td>$ 50000.00</td>
                      <td>$ 2500.00</td>
                      <td> S/. 8750.00 </td>
                  </tr>
                  <tr>
                      <td>INGRESOS ACTUALES</td>
                      <td>$ 20000.00</td>
                      <td>$ 1000.00</td>
                      <td> S/. 3500.00 </td>
                  </tr>
                  <tr style="background-color: #f54738;">
                      <td>RETIROS ACTUALES</td>
                      <td>$ 2000.00</td>
                      <td>$ 100.00</td>
                      <td> </td>
                  </tr>
                  <tr style="background-color: #3922e9;">
                      <td>CUOTA PENDIENTE</td>
                      <td>$ 32000.00</td>
                      <td>$ 1400.00</td>
                      <td> S/. 5250.00 </td>
                  </tr>
                  <tr style="background-color: #3922e9;">
                      <td>PAGO EN EFECTIVO</td>
                      <td></td>
                      <td></td>
                      <td> S/. 5250.00 </td>
                  </tr>
                  </tbody>
              </table>
          </div>
      </div>
  </div>
@endsection
@section('script')
@endsection
