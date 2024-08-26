@extends('layouts.app')

@section('title')
      Ventas
@endsection

@section('content')
<div class="row">
      <div class="col-lg-12">
          <div class="ibox ">
              <div class="ibox-title d-flex justify-content-between align-items-center">
                <div class="row">
                <div class="col-sm-1">
                  <h5>Tabla Ventas </h5>
                </div>
                {{-- @if (auth()->check() && auth()->user()->hasRole('ADMINISTRADOR')) --}}
                  <div class="col-sm-2">
                    {{-- @can('Filtrar Today') --}}
                    <div class="input-group date">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="date_added_init" type="text" class="form-control" value="01/01/2024">
                    </div>
                    {{-- @endcan --}}
                </div>
                <div class="col-sm-2">
                    {{-- @can('Filtrar Today') --}}
                    <div class="input-group date">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="date_added_end" type="text" class="form-control" value="12/31/2024" onchange="filterSales('#area', '#inputCode', '#date_added_init', '#date_added_end', '#tabVenta')">
                    </div>
                    {{-- @endcan --}}
                </div>
                <div class="col-sm-2 text-right">
                    {{-- @can('Filtrar Area Today') --}}
                        <select class="form-control m-b" name="area" id="area" onchange="filterSales('#area', '#inputCode', '#date_added_init', '#date_added_end', '#tabVenta')" onclick="filterSales('#area', '#inputCode', '#date_added_init', '#date_added_end', '#tabVenta')">
                            @foreach($areas as $area)
                            <option value = "{{ $area->id }}">{{ $area->name }}</option>
                            @endforeach
                        </select>
                    {{-- @endcan --}}
                </div>
                <div class="col-sm-3">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control form-control-sm" placeholder="Buscar por nombre o código" id="inputCode" oninput="filterSales('#area', '#inputCode', '#date_added_init', '#date_added_end', '#tabVenta')">
                        <div class="input-group-append">
                            <button class="btn btn-sm btn-default" type="button"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
                {{-- @endif --}}
                  <div class="col-sm-2">
                    {{-- @can('Registrar Ventas') --}}
                        <button type="button" class="btn btn-default" type="button" onclick="mostrarNuevoModal('#modalVenta')"><i class="fa fa-plus"></i> Registrar Venta</button>
                    {{-- @endcan --}}
                  </div>
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
                          <th>Acción</th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($sales as $sale)
                            <tr>
                                <td>{{ date("d/m/Y", strtotime($sale->date_admission)) }}</td>
                                <td>{{ $sale->customer->id }}</td>
                                <td>{{ $sale->customer->name }} {{ $sale->customer->lastname }}</td>
                                <td> $ {{ number_format($sale->amount, 2) }} </td>
                                <td>{{ $sale->percent }}</td>
                                <td> $ {{ number_format($sale->commission, 2) }}</td>
                                <td>{{ $sale->exchange_rate }}</td>
                                <td>{{ $sale->commission }}</td>
                                <td>{{ $sale->agent->name }} {{ $sale->agent->lastname }}</td>
                                <td>{{ $sale->agent->area->name }}</td>
                                <td>{{ $sale->obsercation }}</td>
                                <td>
                                    {{-- @can('Editar Venta') --}}
                                        <button class="btn btn-warning " type="button" onclick="editarSale('{{ $sale->id }}', '{{ $sale->customer->id }}', '{{ $sale->customer->name }} {{ $sale->customer->lastname }}', '{{ $sale->amount }}', '{{ $sale->percent }}', '{{ $sale->exchange_rate }}', '{{ $sale->comission }}', '{{ $sale->agent->id }}', '{{ $sale->agent->code }}', '{{ $sale->agent->name }} {{ $sale->agent->lastname }}', '{{ $sale->obsercation }}', '#modalEditarVenta', '#eId', '#eIdClient', '#eNameClient', '#eAmount', '#ePercent', '#eTypeChange', '#eComission', '#eIdAgent', '#eCodAgent', '#eNameAgent', '#eObservation')"><i class="fa fa-pencil"></i></button>
                                    {{-- @endcan --}}
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td>TOTAL</td>
                            <td>:</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>$ {{ number_format($totalAmount, 2) }}</td>
                            <td></td>
                        </tr>
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
                <div id="alertError" class="alert alert-danger alert-dismissable d-none">
                    <span id="alertErrorText"></span>
                </div>
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
                                        <button type="button" class="btn btn-primary ladda-button-client" data-style="zoom-in" onclick="searchClient({ inputDni: '#dniCustomer', inputName: '#nameCustomer', alertError: '#alertError', alertErrorText: '#alertErrorText', btnLadda: '.ladda-button-client' })"><i class="fa fa-search"></i></button>
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
                                        <button type="button" class="btn btn-primary ladda-button-agent" data-style="zoom-in" onclick="searchAgent({ inputcodeVoiso: '#dniAgent', inputName: '#nameAgent', alertError:  '#alertError', alertErrorText: '#alertErrorText', btnLadda: '.ladda-button-agent' })"><i class="fa fa-search"></i></button>
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
                <button class="btn btn-info ladda-button-save" type="button" data-style="zoom-in" onclick="createSales({dniCustomer: '#dniCustomer', dniAgent: '#dniAgent', amount: '#amount', percent: '#percent', exchange_rate: '#typeChange', commission: '#commission', observation: '#observation', modal: '#modalVenta', tableName: '#tabVenta' , typeSales: '1'})"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="modalEditarVenta" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Editar Venta</h4>
                <input type="text" class="form-control" id="eId" hidden>
            </div>
            <div class="modal-body">
                <table class="table m-b-xs">
                    <tbody>
                        <tr hidden>
                            <td>
                                <strong>Cliente</strong>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="eIdClient" placeholder="Ingrese el DNI o Código del cliente">
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
                                <input style='font-size: large;' type='text' class='form-control text-success' placeholder="Nombre del cliente" id='eNameClient' readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Agente</strong>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="eIdAgent" placeholder="Ingrese el DNI o Código del agente" hidden>
                                    <input type="text" class="form-control" id="eCodAgent" placeholder="Ingrese el DNI o Código del agente">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-primary" onclick="searchAgent('#eCodAgent', '#eNameAgent')"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Datos del Agente</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='text' class='form-control text-success' placeholder="Nombre del agente" id='eNameAgent' readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Monto</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='text' class='form-control text-success' placeholder="Ingrese el monto" id='eAmount'>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Porcentaje</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='text' class='form-control text-success' placeholder="Ingrese el porcentaje" id='ePercent'>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Tipo de Cambio</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='text' class='form-control text-success' placeholder="Ingrese el tipo de cambio" id='eTypeChange' readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                  <strong>Comisión</strong>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input style='font-size: large;' type='text' class='form-control text-success' placeholder="Calculo de comisión" id='eComission' readonly>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-primary" onclick="calculateCommission('#eAmount', '#ePercent', '#eTypeChange', '#eComission')"><i class="fa fa-calculator"></i></button>
                                    </div>
                                </div>

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Observación</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='text' class='form-control text-success' placeholder="Ingrese una observación" id='eObservation'>
                            </td>
                        </tr>


                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button class="btn btn-info " type="button" onclick="updateSale({eId: '#eId', eIdClient: '#eIdClient', eCodAgent: '#eCodAgent', eIdAgent: '#eIdAgent', eAmount: '#eAmount', ePercent: '#ePercent', eTypeChange: '#eTypeChange', eComission: '#eComission', eObservation: '#eObservation', modal: '#modalEditarVenta', tableName: '#tabVenta' , typeSales: '1'})"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i> Cancelar</button>
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
        var searchClientRoute = '{{ route("searchCustomer") }}';
        var saveSaleRoute = '{{ Route("saveSale") }}';
        var updateSaleRoute = '{{ Route("updateSale") }}';
        var searchAgentRoute = '{{ route("searchAgent") }}';
        var filterSalesRoute = '{{ route("filterSales") }}';
        var token = '{{ csrf_token() }}';
    </script>

    <script src="{{ asset('js/utils/mostrarMensaje.js') }}"></script>
    <script src="{{ asset('js/utils/mostrarMensajeModal.js') }}"></script>
    <script src="{{ asset('js/utils/mostrarNuevoModal.js') }}"></script>
    <script src="{{ asset('js/customer/searchClient.js') }}"></script>
    <script src="{{ asset('js/sales/createSales.js') }}"></script>
    <script src="{{ asset('js/sales/calculateCommission.js') }}"></script>
    <script src="{{ asset('js/agent/searchAgent.js') }}"></script>
    <script src="{{ asset('js/sales/filterSales.js') }}"></script>
    <script src="{{ asset('js/sales/editSale.js') }}"></script>


@endsection
