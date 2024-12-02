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
                  @if (auth()->check() && auth()->user()->hasRole('ADMINISTRADOR'))
                    <div class="col-sm-2">
                        <div class="input-group date">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="date_added_init" type="text" class="form-control" value="01/01/2024">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="input-group date">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="date_added_end" type="text" class="form-control" value="12/31/2024" onchange="filterBonus('#area', '#inputCode', '#date_added_init', '#date_added_end', '#tabBonus')">
                        </div>
                    </div>
                    <div class="col-sm-2 text-right">
                        <select class="form-control m-b" name="area" id="area" onchange="filterBonus('#area', '#inputCode', '#date_added_init', '#date_added_end', '#tabBonus')" onclick="filterBonus('#area', '#inputCode', '#date_added_init', '#date_added_end', '#tabBonus')">
                            @foreach($areas as $area)
                            <option value = "{{ $area->id }}">{{ $area->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control form-control-sm" placeholder="Buscar por nombre o código" id="inputCode" oninput="filterBonus('#area', '#inputCode', '#date_added_init', '#date_added_end', '#tabBonus')">
                            <div class="input-group-append">
                                <button class="btn btn-sm btn-default" type="button"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    @endif
                  <div>
                    @can('Registrar Descuento')
                    <button type="button" class="btn btn-danger" type="button" onclick="mostrarNuevoModal('#modalDescuento')"><i class="fa fa-plus"></i> Registrar Descuento</button>
                    @endcan
                    @can('Registrar Bonus')
                    <button type="button" class="btn btn-default" type="button" onclick="mostrarNuevoModal('#modalBonus')"><i class="fa fa-plus"></i> Registrar Bonus</button>
                    @endcan
                  </div>
              </div>
              <div class="ibox-content" id="tabBonus">
                  <table class="table table-striped">
                      <thead>
                      <tr>
                          <th>Fecha de Ingreso</th>
                          <th>Bono</th>
                          <th>Comisión en Soles</th>
                          <th>Agente</th>
                          <th>Area</th>
                          <th>Comentario</th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($bonusAgent as $ba)
                            <tr @if($ba->action_id == 3) class="table-danger" @endif>
                                <td>{{ date("d/m/Y", strtotime($ba->date_admission)) }}</td>
                                <td> $ {{ number_format($ba->commission, 2) }}</td>
                                <td>S/. {{ number_format($ba->commission*3.5, 2) }}</td>
                                <td>
                                    @can('Ver Perfil Agente')
                                    <a href="{{ route('perfilUsuario', ['id' => $ba->agent->id]) }}">
                                    @endcan
                                    {{ $ba->agent->name }} {{ $ba->agent->lastname }}
                                    @can('Ver Perfil Agente')
                                    </a>
                                    @endcan
                                </td>
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

  <div class="modal inmodal fade" id="modalBonus" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Registrar Bonus</h4>
            </div>
            <div class="modal-body">
                <div id="alertErrorCreateBonus" class="alert alert-danger alert-dismissable d-none">
                    <span id="alertErrorTextCreateBonus"></span>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Agente</label>
                    <div class="input-group col-lg-9">
                        <input type="text" class="form-control" id="dniAgent" placeholder="Ingrese el DNI o Código del cliente">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary ladda-button-agent-create-bonus" data-style="zoom-in" onclick="searchAgent({ inputcodeVoiso: '#dniAgent', inputName: '#nameAgent', alertError: '#alertErrorCreateBonus', alertErrorText: '#alertErrorTextCreateBonus', btnLadda: '.ladda-button-agent-create-bonus' })"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Datos del Agente</label>
                    <div class="col-lg-9">
                        <input type="text" placeholder="Nombre del agente" class="form-control" id='nameAgent' readonly>
                    </div>
                </div>
                <div class="form-group row"><label class="col-lg-3 col-form-label">Bono</label>
                    <div class="col-lg-9">
                        <input type="number" placeholder="Ingrese el bono" class="form-control" id="commission">
                    </div>
                </div>
                <div class="form-group row"><label class="col-lg-3 col-form-label">Comentario</label>
                    <div class="col-lg-9"><textarea class="form-control" placeholder="Ingrese su comentario" id="observation"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info " type="button" onclick="createBonus({dniAgent: '#dniAgent', commission: '#commission', modal: '#modalBonus', tableName: '#tabBonus', typeSales: '2'})"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="modalDescuento" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div    class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Registrar Descuento</h4>
            </div>
            <div class="modal-body">
                <div id="alertErrorCreateDescuento" class="alert alert-danger alert-dismissable d-none">
                    <span id="alertErrorTextCreateDescuento"></span>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Agente</label>
                    <div class="input-group col-lg-9">
                        <input type="text" class="form-control" id="dniDiscountAgent" placeholder="Ingrese el DNI o Código del agente">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary ladda-button-agent-create-descuento" data-style="zoom-in" onclick="searchAgent({ inputcodeVoiso: '#dniDiscountAgent', inputName: '#nameDiscountAgent', alertError: '#alertErrorCreateDescuento', alertErrorText: '#alertErrorTextCreateDescuento', btnLadda: '.ladda-button-agent-create-descuento' })"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Datos del Agente</label>
                    <div class="col-lg-9">
                        <input type="text" placeholder="Nombre del agente" class="form-control" id='nameDiscountAgent' readonly>
                    </div>
                </div>
                <div class="form-group row"><label class="col-lg-3 col-form-label">Monto</label>
                    <div class="col-lg-9">
                        <input type="number" placeholder="Ingrese un monto" class="form-control" id="amountDiscount">
                    </div>
                </div>
                <div class="form-group row"><label class="col-lg-3 col-form-label">Comentario</label>
                    <div class="col-lg-9"><textarea class="form-control" placeholder="Ingrese su comentario" id="observationDiscount"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info " type="button" onclick="createDiscount({dniAgent: '#dniDiscountAgent', commission: '#amountDiscount', modal: '#modalDescuento', tableName: '#tabBonus', typeSales: '3'})"><i class="fa fa-save"></i> Guardar</button>
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
                <div id="alertErrorRegistrarTarget" class="alert alert-danger alert-dismissable d-none">
                    <span id="alertErrorTextRegistrarTarget"></span>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Agente</label>
                    <div class="input-group col-lg-9">
                        <input type="text" class="form-control" id="dniTargetAgent" placeholder="Ingrese el DNI o Código del agente">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary ladda-button-agent-registrar-target" data-style="zoom-in" onclick="searchAgent({inputcodeVoiso: '#dniTargetAgent', inputName: '#nameTargetAgent', alertError: '#alertErrorRegistrarTarget', alertErrorText: '#alertErrorTextRegistrarTarget', btnLadda: '.ladda-button-agent-registrar-target' })"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Datos del Agente</label>
                    <div class="col-lg-9">
                        <input type="text" placeholder="Nombre del agente" class="form-control" id='nameTargetAgent' readonly>
                    </div>
                </div>
                <div class="form-group row"><label class="col-lg-3 col-form-label">Monto</label>
                    <div class="col-lg-9">
                        <input type="number" placeholder="Ingrese un moneto" class="form-control" id="amountTarget">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info " type="button" onclick="createTarget('#amountTarget', '#dniTargetAgent', '#modalRegistrarTarget', '#tabTarget')"><i class="fa fa-save"></i> Guardar</button>
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
                <div id="alertErrorRegistrarRetiro" class="alert alert-danger alert-dismissable d-none">
                    <span id="alertErrorTextRegistrarRetiro"></span>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Agente</label>
                    <div class="input-group col-lg-9">
                        <input type="text" class="form-control" id="dniAgentRetiro" placeholder="Ingrese el DNI o Código del agente">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary ladda-button-agent-registrar-retiro" data-style="zoom-in" onclick="searchAgent({ inputcodeVoiso: '#dniAgentRetiro', inputName: '#nameAgentRetiro', alertError: '#alertErrorRegistrarRetiro', alertErrorText: '#alertErrorTextRegistrarRetiro', btnLadda: '.ladda-button-agent-registrar-retiro' })"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Datos del Agente</label>
                    <div class="col-lg-9">
                        <input type="text" placeholder="Nombre del agente" class="form-control" id='nameAgentRetiro' readonly>
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
                <button class="btn btn-info " type="button" onclick="createRetirement('#dniAgentRetiro', '#amountRetiro', '#modalRegistrarRetiro', '#tabRetiroEfectivo')"><i class="fa fa-save"></i> Guardar</button>
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
    var saveTargetRoute = '{{ route("saveTarget") }}';
    var searchAgentRoute = '{{ route("searchAgent") }}';
    var saveRetiroRoute = '{{ route("saveRetiro") }}';
    var searchClientRoute = '{{ Route("searchCustomer") }}';
    var saveBonusRoute = '{{ Route("saveBonus") }}';
    var saveSaleRoute = '{{ Route("saveSale") }}';
    var filterBonusRoute = '{{ route("filterBonus") }}';
    var token = '{{ csrf_token() }}';
</script>
<script src="{{ asset('js/utils/mostrarMensaje.js') }}"></script>
<script src="{{ asset('js/utils/mostrarNuevoModal.js') }}"></script>
<script src="{{ asset('js/agent/searchAgent.js') }}"></script>
<script src="{{ asset('js/customer/searchClient.js') }}"></script>
<script src="{{ asset('js/bonusAgent/createTarget.js') }}"></script>
<script src="{{ asset('js/bonusAgent/createRetirement.js') }}"></script>
<script src="{{ asset('js/bonusAgent/createBonus.js') }}"></script>
<script src="{{ asset('js/bonusAgent/createDiscount.js') }}"></script>
<script src="{{ asset('js/sales/createSales.js') }}"></script>
<script src="{{ asset('js/bonusAgent/filterBonus.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        markNotificationsAsSeen('bonusagent');
    });
</script>
@endsection
