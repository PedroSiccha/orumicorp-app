@extends('layouts.app')

@section('title')
    Bonus de Agente
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Tabla Bonus</h5>
                <div class="d-flex">
                    @can('Registrar Descuento')
                        <button class="btn btn-danger btn-sm" onclick="mostrarNuevoModal('#modalDescuento')">
                            <i class="fa fa-plus"></i> Registrar Descuento
                        </button>
                    @endcan
                    @can('Registrar Bonus')
                        <button class="btn btn-default btn-sm ms-2" onclick="mostrarNuevoModal('#modalBonus')">
                            <i class="fa fa-plus"></i> Registrar Bonus
                        </button>
                    @endcan
                </div>

            </div>       
                    
            
            <div class="ibox-content pt-2 pb-2">
                <div class="row">
                    @if (auth()->check() && auth()->user()->hasRole('ADMINISTRADOR'))
                        <div class="col-md-2 mb-2">
                            <input type="text" class="form-control" id="date_added_init" placeholder="Fecha inicio" value="{{ date('01/01/Y') }}">
                        </div>
                        <div class="col-md-2 mb-2">
                            <input type="text" class="form-control" id="date_added_end" placeholder="Fecha fin" value="{{ date('d/m/Y') }}">
                        </div>
                        <div class="col-md-3 mb-2">
                            <select class="form-control" id="area">
                                <option value="">TODOS</option>
                                @foreach($areas as $area)
                                    <option value="{{ $area->id }}">{{ $area->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <select class="form-control" id="inputCode" style="width: 100%"></select>


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
                        <input type="text" class="form-control" id="dniAgent" placeholder="ID DEL AGENTE">
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
                <button class="btn btn-info " type="button" onclick="createBonus({dniAgent: '#dniAgent', commission: '#commission', inputObservation: '#observation', modal: '#modalBonus', table: '#tabBonus', typeSales: '2'})"><i class="fa fa-save"></i> Guardar</button>
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
                        <input type="text" class="form-control" id="dniDiscountAgent" placeholder="ID DEL AGENTE">
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
                <button class="btn btn-info " type="button" onclick="createDiscount({dniAgent: '#dniDiscountAgent', commission: '#amountDiscount', inputObservation: '#observationDiscount', modal: '#modalDescuento', table: '#tabBonus', typeSales: '3'})"><i class="fa fa-save"></i> Guardar</button>
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
                        <input type="text" class="form-control" id="dniTargetAgent" placeholder="ID DEL AGENTE">
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
                        <input type="text" class="form-control" id="dniAgentRetiro" placeholder="ID DEL AGENTE">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary ladda-button-agent-registrar-retiro" data-style="zoom-in" onclick="searchAgent({ inputcodeVoiso: '#dniAgentRetiro', inputName: '#nameAgentRetiro', alertError: '#alertErrorRegistrarRetiro', alertErrorText: '#alertErrorTextRegistrarRetiro', btnLadda: '.ladda-button-agent-registrar-retiro' })"><i class="fa fa-search"></i></button>

                        </div>
                        <div class="col-md-2 mb-2">
                            <button class="btn btn-warning btn-sm" id="btnClearFilters"><i class="fa fa-eraser"></i> Limpiar Filtros</button>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="ibox-content" id="tabBonus">
                {{-- Shimmer placeholders visibles al cargar --}}
                <div id="shimmer-wrapper-table" class="_shimmerTable">
                    @include('bonusAgente.partials._shimmerTable')
                </div>
            
                {{-- <div id="shimmer-wrapper-totals" class="_shimmerTotals">
                    @include('bonusAgente.partials._shimmerTotals')
                </div> --}}
            
                {{-- Contenedores reales que serán reemplazados vía AJAX --}}
                <div id="bonus-table-wrapper" style="display: none;"></div>
                <div id="bonus-total-wrapper" style="display: none;"></div>
            </div>                       
        </div>
    </div>
</div>

@include('bonusAgente.modals._modalBonus')
@include('bonusAgente.modals._modalDescuento')
@include('bonusAgente.modals._modalTarget')
@include('bonusAgente.modals._modalRetiro')
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        filterBonus('#area', '#inputCode', '#date_added_init', '#date_added_end', '#tabBonus');
    });

    $(document).ready(function() {
        $('#date_added_init').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true
        });
        $('#date_added_end').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true
        });
    });

    $('#inputCode').select2({
        placeholder: "Buscar por nombre o código",
        minimumInputLength: 2,
        ajax: {
            url: '{{ route("searchAgentAjax") }}',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return { q: params.term };
            },
            processResults: function (data) {
                return { results: data };
            },
            cache: true
        },
        templateResult: function (agent) {
            return agent.text;
        },
        templateSelection: function (agent) {
            return agent.text || agent.id;
        }
    });

    var filterBonusRoute = '{{ route("filterBonus") }}';
    var searchAgentRoute = '{{ route("searchAgent") }}';
    var saveRetiroRoute = '{{ route("saveRetiro") }}';
    var saveBonusRoute = '{{ route("saveBonus") }}';
    var saveTargetRoute = '{{ route("saveTarget") }}';
    var token = '{{ csrf_token() }}';
</script>
<script src="{{ asset('js/utils/mostrarNuevoModal.js') }}"></script>
<script src="{{ asset('js/utils/mostrarMensaje.js') }}"></script>
<script src="{{ asset('js/bonusAgent/filterBonus.js') }}"></script>
<script src="{{ asset('js/bonusAgent/createDiscount.js') }}"></script>
<script src="{{ asset('js/bonusAgent/createBonus.js') }}"></script>
<script src="{{ asset('js/bonusAgent/createTarget.js') }}"></script>
<script src="{{ asset('js/agent/searchAgent.js') }}"></script>
@endsection
