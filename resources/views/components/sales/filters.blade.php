@if (auth()->check() && auth()->user()->hasRole('ADMINISTRADOR'))
<div class="row" id="sales-filters">
    @can('Filtrar Today')
        <div class="col-md-2">
            <label for="date_added_init">Fecha Inicio</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                <input type="text" id="date_added_init" class="form-control" placeholder="DD/MM/AAAA">
            </div>
        </div>

        <div class="col-md-2">
            <label for="date_added_end">Fecha Fin</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                <input type="text" id="date_added_end" class="form-control" placeholder="DD/MM/AAAA">
            </div>
        </div>
    @endcan

    @can('Filtrar Area Today')
        <div class="col-md-2">
            <label for="area">Área</label>
            <select class="form-control" id="area">
                <option value="">-- Todas --</option>
                @foreach ($areas as $area)
                    <option value="{{ $area->id }}">{{ $area->name }}</option>
                @endforeach
            </select>
        </div>
    @endcan

    {{-- <div class="col-md-3">
        <label for="inputCode">Nombre o Código del Agente</label>
        <div class="input-group">
            <input type="text" id="inputCode" class="form-control" placeholder="Buscar por nombre o código">
            <span class="input-group-append">
                <button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
            </span>
        </div>
    </div> --}}
    <div class="col-md-3">
        <label for="inputAgentSelect">Buscar Agente</label>
        <select id="inputAgentSelect" class="form-control" style="width: 100%"></select>
    </div>

    <div class="col-md-2 d-flex align-items-end">
        <button type="button" class="btn btn-outline-secondary w-100" id="clearFilters">
            <i class="fa fa-eraser"></i> Limpiar Filtros
        </button>
    </div>    
    
    @endif
    <div class="col-md-1 d-flex align-items-end">
        @can('Registrar Ventas')
            <button type="button" class="btn btn-success w-100" onclick="mostrarNuevoModal('#modalVenta')">
                <i class="fa fa-plus"></i> Registrar Venta
            </button>
        @endcan
    </div>
</div>
