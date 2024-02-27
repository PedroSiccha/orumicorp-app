@extends('layouts.app')

@section('title')
      Ventas
@endsection

@section('content')
<div class="row">
      <div class="col-lg-12">
          <div class="ibox ">
              <div class="ibox-title d-flex justify-content-between align-items-center">
                  <h5>Tabla Ventas </h5>
                  <div>
                    @can('Registrar Ventas')
                    <button type="button" class="btn btn-default" type="button" onclick="mostrarNuevoModal('#modalVenta')"><i class="fa fa-plus"></i> Registrar Venta</button>
                    @endcan
                  </div>
              </div>
              <div class="ibox-content" id="tabVenta">
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

<div class="modal inmodal fade" id="modalVenta" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Nueva Venta</h4>
                <small class="font-bold">Registre su venta</small>
            </div>
            <div class="modal-body">
                <table class="table m-b-xs">
                    <tbody>
                        <tr>
                            <td>
                                <strong>Cliente</strong>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="dniCustomer" placeholder="Ingrese el DNI o Código del cliente">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-primary" onclick="searchClient('#dniCustomer', '#nameCustomer')"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Datos del Cliente</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='text' class='form-control text-success' placeholder="Nombre del cliente" id='nameCustomer' readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Agente</strong>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="dniAgent" placeholder="Ingrese el DNI o Código del agente">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-primary" onclick="searchAgent('#dniAgent', '#nameAgent')"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Datos del Agente</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='text' class='form-control text-success' placeholder="Nombre del agente" id='nameAgent' readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Monto</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='text' class='form-control text-success' placeholder="Ingrese el monto" id='amount'>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Porcentaje</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='text' class='form-control text-success' placeholder="Ingrese el porcentaje" id='percent'>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Tipo de Cambio</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='text' class='form-control text-success' placeholder="Ingrese el tipo de cambio" id='typeChange'>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                  <strong>Comisión</strong>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input style='font-size: large;' type='text' class='form-control text-success' placeholder="Calculo de comisión" id='commission' readonly>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-primary" onclick="calculateCommission('#amount', '#percent', '#typeChange', '#commission')"><i class="fa fa-calculator"></i></button>
                                    </div>
                                </div>

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Observación</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='text' class='form-control text-success' placeholder="Ingrese una observación" id='observation'>
                            </td>
                        </tr>


                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button class="btn btn-info " type="button" onclick="createSales('#dniCustomer', '#dniCustomer', '#amount', '#percent', '#typeChange', '#commission', '#observation', '#modalVenta', '#tabVenta')"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        var searchClientRoute = '{{ route("searchCustomer") }}';
        var saveSaleRoute = '{{ Route("saveSale") }}';
        var searchAgentRoute = '{{ route("searchAgent") }}';
        var token = '{{ csrf_token() }}';
    </script>

    <script src="{{ asset('js/utils/mostrarNuevoModal.js') }}"></script>
    <script src="{{ asset('js/customer/searchClient.js') }}"></script>
    <script src="{{ asset('js/sales/createSales.js') }}"></script>
    <script src="{{ asset('js/sales/calculateCommission.js') }}"></script>
    <script src="{{ asset('js/agent/searchAgent.js') }}"></script>


@endsection
