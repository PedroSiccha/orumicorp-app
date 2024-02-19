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
                    <button type="button" class="btn btn-default" type="button" onclick="nuevaVenta()"><i class="fa fa-plus"></i> Registrar Venta</button>
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
                                        <button type="button" class="btn btn-primary" onclick="searchCustomer()"><i class="fa fa-search"></i></button>
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
                                <strong>Monto</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='text' class='form-control text-success' placeholder="Ingrese el monto" id='amount'>
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
                        <tr>
                            <td>
                                <strong>Porcentaje</strong>
                            </td>
                            <td>
                                <select class="form-control m-b" name="percent_id" id="percent_id">
                                    <option>Seleccione un porcentaje</option>
                                    @foreach($percents as $percent)
                                    <option value = "{{ $percent->id }}">{{ $percent->description }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                              <td>
                                    <strong>Comisión</strong>
                              </td>
                              <td>
                                    <select class="form-control m-b" name="commission_id" id="commission_id">
                                          <option>Seleccione una comisión</option>
                                          @foreach($commissions as $commission)
                                          <option value = "{{ $commission->id }}">{{ $commission->name }}</option>
                                          @endforeach
                                      </select>
                              </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Tipo de Cambio</strong>
                            </td>
                            <td>
                                <select class="form-control m-b" name="exchange_rate_id" id="exchange_rate_id">
                                    <option>Seleccione un tipo de cambio</option>
                                    @foreach($exchange_rates as $exchange_rate)
                                    <option value = "{{ $exchange_rate->id }}">{{ $exchange_rate->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button class="btn btn-info " type="button" onclick="guardarNuevoAgente()"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')

    <script>

        function nuevaVenta() {
            $('#modalVenta').modal('show');
        }

        function searchCustomer() {
            var dni = $("#dniCustomer").val();
            $.post("{{ Route('searchCustomer') }}", {dni: dni, _token: '{{ csrf_token() }}'}).done(function(data) {
                $('#nameCustomer').val(data.name);
            });
        }

        function guardarNuevoAgente() {
            var dniCustomer = $("#dniCustomer").val();
            var amount = $("#amount").val();
            var observation = $("#observation").val();
            var percent_id = $("#percent_id").val();
            var commission_id = $("#commission_id").val();
            var exchange_rate_id = $("#exchange_rate_id").val();
            $.post("{{ Route('saveSale') }}", {dniCustomer: dniCustomer, amount: amount, observation: observation, percent_id: percent_id, commission_id: commission_id, exchange_rate_id: exchange_rate_id, _token: '{{ csrf_token() }}'}).done(function(data) {
                $('#modalVenta').modal('hide');
                $("#tabVenta").empty();
                $("#tabVenta").html(data.view);
                if (data.resp == 1) {

                    Swal.fire({
                        title: "Correcto",
                        text: "La venta se registró correctamente",
                        icon: "success"
                    });

                } else {

                    Swal.fire({
                        title: "Error",
                        text: "La venta no se pudo registrar",
                        icon: "error"
                    });

                }

            });
        }

    </script>

@endsection
