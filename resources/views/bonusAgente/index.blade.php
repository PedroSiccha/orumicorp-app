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
    var token = '{{ csrf_token() }}';
</script>
<script src="{{ asset('js/bonusAgent/filterBonus.js') }}"></script>
<script src="{{ asset('js/utils/mostrarNuevoModal.js') }}"></script>

@endsection
