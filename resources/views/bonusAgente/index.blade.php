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
                    @can('Registrar Descuento')
                    <button type="button" class="btn btn-danger" type="button" onclick="registrarBonus()"><i class="fa fa-plus"></i> Registrar Descuento</button>
                    @endcan
                    @can('Registrar Bonus')
                    <button type="button" class="btn btn-default" type="button" onclick="registrarBonus()"><i class="fa fa-plus"></i> Registrar Bonus</button>
                    @endcan
                  </div>
              </div>
              <div class="ibox-content" id="tabBonus">
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
                        @foreach ($bonusAgent as $ba)
                            <tr>
                                <td>{{ date("d/m/Y", strtotime($ba->date_admission)) }}</td>
                                <td>{{ $ba->customer->id }}</td>
                                <td>{{ $ba->customer->name }} {{ $ba->customer->lastname }}</td>
                                <td> $ {{ number_format($ba->amount / $ba->exchangeRate->amount, 2) }} </td>
                                <td>{{ $ba->percent->description }}</td>
                                <td> $ {{ number_format($ba->commission->amount / $ba->exchangeRate->amount, 2) }}</td>
                                <td>{{ $ba->exchangeRate->name }}</td>
                                <td>{{ $ba->commission->name }}</td>
                                <td>{{ $ba->agent->name }} {{ $ba->agent->lastname }}</td>
                                <td>{{ $ba->agent->area->name }}</td>
                                <td>{{ $ba->observation }}</td>
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
                    @can('Registrar Target')
                    <li><a href="#" class="dropdown-item" onclick="registrarTarget()">Registrar Target</a></li>
                    @endcan
                    @can('Registrar Retiro')
                    <li><a href="#" class="dropdown-item" onclick="registrarRetiro()">Registrar Retiro</a></li>
                    @endcan
                  </ul>
              </div>
          </div>
          <div class="ibox-content">
            @can('Ver Totales')
            <table class="table table-hover">
                <thead>
                </thead>
                <tbody>
                <tr style="background-color: #4ef34e;" id="tabTarget">
                    <td style="color: rgb(0, 0, 0); font-weight: bold;">TARGET MENSUAL</td>
                    <td style="color: rgb(0, 0, 0); font-weight: bold;">$ {{ number_format($target->amount, 2, '.', ','); }}</td>
                    <td style="color: rgb(0, 0, 0); font-weight: bold;">$ {{ number_format($target->amount/30, 2, '.', ','); }}</td>
                    <td style="color: rgb(0, 0, 0); font-weight: bold;"> S/. {{ number_format($target->amount*3.5, 2, '.', ','); }} </td>
                </tr>
                <tr>
                    <td style="color: rgb(0, 0, 0); font-weight: bold;">INGRESOS ACTUALES</td>
                    <td style="color: rgb(0, 0, 0); font-weight: bold;">$ {{ number_format($amount, 2, '.', ','); }}</td>
                    <td style="color: rgb(0, 0, 0); font-weight: bold;"></td>
                    <td style="color: rgb(0, 0, 0); font-weight: bold;"> S/. {{ number_format($amount*3.5, 2, '.', ','); }} </td>
                </tr>
                <tr style="background-color: #f54738;">
                    <td style="color: rgb(0, 0, 0); font-weight: bold;">RETIROS ACTUALES</td>
                    <td style="color: rgb(0, 0, 0); font-weight: bold;">$ {{ number_format($amountRetiro, 2, '.', ','); }}</td>
                    <td style="color: rgb(0, 0, 0); font-weight: bold;"></td>
                    <td style="color: rgb(0, 0, 0); font-weight: bold;"> S/. {{ number_format($amountRetiro*3.5, 2, '.', ','); }}</td>
                </tr>
                <tr style="background-color: #3922e9;">
                    <td style="color: rgb(255, 255, 255); font-weight: bold;">CUOTA PENDIENTE</td>
                    <td style="color: rgb(255, 255, 255); font-weight: bold;">$ {{ number_format($target->amount - $amount + $amountRetiro, 2, '.', ','); }}</td>
                    <td style="color: rgb(255, 255, 255); font-weight: bold;"></td>
                    <td style="color: rgb(255, 255, 255); font-weight: bold;"> S/. {{ number_format($target->amount*3.5 - $amount*3.5 + $amountRetiro*3.5, 2, '.', ','); }} </td>
                </tr>
                <tr style="background-color: #000000;">
                    <td style="color: rgb(255, 255, 255); font-weight: bold;">PAGO EN EFECTIVO</td>
                    <td></td>
                    <td></td>
                    <td style="color: rgb(255, 255, 255); font-weight: bold;"> S/. 0.00 </td>
                </tr>
                </tbody>
            </table>
            @endcan
          </div>
      </div>
  </div>

  <div class="modal inmodal fade" id="modalBonus" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Registrar Bonus</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Cliente</label>
                    <div class="input-group col-lg-9">
                        <input type="text" class="form-control" id="dniCustomer" placeholder="Ingrese el DNI o Código del cliente">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary" onclick="searchCustomer()"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Datos del Cliente</label>
                    <div class="col-lg-9">
                        <input type="text" placeholder="Nombre del cliente" class="form-control" id='nameCustomer' readonly>
                    </div>
                </div>
                <div class="form-group row"><label class="col-lg-3 col-form-label">Monto</label>
                    <div class="col-lg-9">
                        <input type="number" placeholder="Ingrese un moneto" class="form-control" id="amount">
                    </div>
                </div>
                <div class="form-group row"><label class="col-lg-3 col-form-label">Porcentaje</label>
                    <div class="col-lg-9">
                        <select class="form-control m-b" name="percent_id" id="percent_id">
                            <option>Seleccione un porcentaje</option>
                            @foreach($percents as $percent)
                                <option value = "{{ $percent->id }}">{{ $percent->description }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row"><label class="col-lg-3 col-form-label">Comisión</label>
                    <div class="col-lg-9">
                        <select class="form-control m-b" name="commission_id" id="commission_id">
                            <option>Seleccione una comisión</option>
                            @foreach($commissions as $commission)
                                <option value = "{{ $commission->id }}">{{ $commission->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row"><label class="col-lg-3 col-form-label">Tipo de Cámbio</label>
                    <div class="col-lg-9">
                        <select class="form-control m-b" name="exchange_rate_id" id="exchange_rate_id">
                            <option>Seleccione un tipo de cambio</option>
                            @foreach($exchange_rates as $exchange_rate)
                                <option value = "{{ $exchange_rate->id }}">{{ $exchange_rate->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row"><label class="col-lg-3 col-form-label">Comentario</label>
                    <div class="col-lg-9"><textarea class="form-control" placeholder="Ingrese su comentario" id="observation"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info " type="button" onclick="guardarRegistroBonus()"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="modalRegistrarTarget" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Registrar Target</h4>
                <small>{{ date("F") }}</small>
            </div>
            <div class="modal-body">
                <div class="form-group row"><label class="col-lg-3 col-form-label">Monto</label>
                    <div class="col-lg-9">
                        <input type="number" placeholder="Ingrese un moneto" class="form-control" id="amountTarget">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info " type="button" onclick="guardarTarget()"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="modalRegistrarRetiro" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Registrar Retiro</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Agente</label>
                    <div class="input-group col-lg-9">
                        <input type="text" class="form-control" id="dniAgent" placeholder="Ingrese el DNI o Código del agente">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary" onclick="searchAgent()"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Datos del Agente</label>
                    <div class="col-lg-9">
                        <input type="text" placeholder="Nombre del agente" class="form-control" id='nameAgent' readonly>
                    </div>
                </div>
                <div class="form-group row"><label class="col-lg-3 col-form-label">Monto</label>
                    <div class="col-lg-9">
                        <input type="number" placeholder="Ingrese un moneto" class="form-control" id="amountRetiro">
                    </div>
                </div>
                <div class="form-group row"><label class="col-lg-3 col-form-label">Tipo de Pago</label>
                    <div class="col-lg-9">
                        <select class="form-control m-b" name="percent_id" id="percent_id">
                            <option>Seleccione un porcentaje</option>
                            @foreach($percents as $percent)
                                <option value = "{{ $percent->id }}">{{ $percent->description }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info " type="button" onclick="guardarRetiro()"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')

<script>
    function registrarBonus() {
        $('#modalBonus').modal('show');
    }

    function registrarTarget() {
        $('#modalRegistrarTarget').modal('show');
    }

    function guardarTarget() {
        var amount = $("#amountTarget").val();
        $.post("{{ Route('saveTarget') }}", {amount: amount, _token: '{{ csrf_token() }}'}).done(function(data) {
            $('#modalRegistrarTarget').modal('hide');
            $("#tabTarget").empty();
            $("#tabTarget").html(data.view);
            if (data.resp == 1) {
                Swal.fire({
                    title: "Correcto",
                    text: "Target registrado exitosamente",
                    icon: "success"
                });
            } else {
                Swal.fire({
                    title: "Error",
                    text: "Target no se pudo registrar",
                    icon: "error"
                });
            }
        });
    }

    function registrarRetiro() {
        $('#modalRegistrarRetiro').modal('show');
    }

    function guardarRetiro() {
        var dni = $("#dniAgent").val();
        var amount = $("#amountRetiro").val();
        $.post("{{ Route('saveRetiro') }}", {amount: amount, dni: dni, _token: '{{ csrf_token() }}'}).done(function(data) {
            $('#modalRegistrarRetiro').modal('hide');
            $("#tabRetiroEfectivo").empty();
            $("#tabRetiroEfectivo").html(data.view);
            if (data.resp == 1) {
                Swal.fire({
                    title: "Correcto",
                    text: "Retiro registrado exitosamente",
                    icon: "success"
                });
            } else {
                Swal.fire({
                    title: "Error",
                    text: "Retiro no se pudo registrar",
                    icon: "error"
                });
            }
        });
    }

    function searchCustomer() {
        var dni = $("#dniCustomer").val();
        $.post("{{ Route('searchCustomer') }}", {dni: dni, _token: '{{ csrf_token() }}'}).done(function(data) {
            $('#nameCustomer').val(data.name);
        });
    }

    function searchAgent() {
        var dni = $("#dniAgent").val();
        $.post("{{ Route('searchAgent') }}", {dni: dni, _token: '{{ csrf_token() }}'}).done(function(data) {
            $('#nameAgent').val(data.name);
        });
    }

    function guardarRegistroBonus() {
        var dniCustomer = $("#dniCustomer").val();
        var amount = $("#amount").val();
        var observation = $("#observation").val();
        var percent_id = $("#percent_id").val();
        var commission_id = $("#commission_id").val();
        var exchange_rate_id = $("#exchange_rate_id").val();
        $.post("{{ Route('saveBonus') }}", {dniCustomer: dniCustomer, amount: amount, observation: observation, percent_id: percent_id, commission_id: commission_id, exchange_rate_id: exchange_rate_id, _token: '{{ csrf_token() }}'}).done(function(data) {
            $('#modalBonus').modal('hide');
            $("#tabBonus").empty();
            $("#tabBonus").html(data.view);
            if (data.resp == 1) {
                Swal.fire({
                    title: "Correcto",
                    text: "El registro de bonus se guardó correctamente",
                    icon: "success"
                });
            } else {
                Swal.fire({
                    title: "Error",
                    text: "El registro no se pudo guardar",
                    icon: "error"
                });
            }
        });
    }
</script>
@endsection
