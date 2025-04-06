{{-- resources/views/home/partials/_ventasStats.blade.php --}}
<div class="row">

    @can('Ver Ventas Tablero')
        <div class="col-lg-6">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Ventas</h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-6">
                            <h1 class="no-margins">$ {{ number_format($montoVenta, 2) }}</h1>
                            <div class="font-bold text-navy">
                                <i class="fa fa-level-up"></i>
                                <small>Área de Ventas</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h1 class="no-margins">$ {{ number_format($montoRetencion, 2) }}</h1>
                            <div class="font-bold text-navy">
                                <i class="fa fa-level-up"></i>
                                <small>Área de Retenciones</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan

    @can('Ver Cantidad Agentes Tablero')
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Agentes</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ $cantAgents }}</h1>
                    <div class="stat-percent font-bold text-success">
                        <i class="fa fa-bolt"></i>
                    </div>
                </div>
            </div>
        </div>
    @endcan

    @can('Ver Cantidad Clientes Tablero')
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Clientes</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ $cantClients }}</h1>
                    <div class="stat-percent font-bold text-info">
                        <i class="fa fa-level-up"></i>
                    </div>
                </div>
            </div>
        </div>
    @endcan

</div>
