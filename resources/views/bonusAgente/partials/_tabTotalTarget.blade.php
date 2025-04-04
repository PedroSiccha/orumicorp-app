<div class="ibox">
    <div class="ibox-title">
        <h5>Totales</h5>
        @can('Registrar Target')
            <div class="ibox-tools">
                <a onclick="mostrarNuevoModal('#modalRegistrarTarget')">
                    <i class="fa fa-plus"></i>
                </a>
            </div>
        @endcan
    </div>

    @can('Bonus Agente - Target Mensual')
        <div class="ibox-content navy-bg">
            <div class="row" id="tabTotalTarget">
                <div class="col-4">
                    <h4>Target Mensual</h4>
                </div>
                <div class="col-4">
                    <h4>$ {{ number_format($reportTargetMensual ?? 0, 2) }}</h4>
                </div>
                <div class="col-4">
                    <h4>S/. {{ number_format(($reportTargetMensual ?? 0) * 3.5, 2) }}</h4>
                </div>
            </div>
        </div>
    @endcan

    @can('Bonus Agente - Ingresos Actuales')
        <div class="ibox-content yellow-bg">
            <div class="row">
                <div class="col-4">
                    <h4>Ingresos Actuales</h4>
                </div>
                <div class="col-4">
                    <h4>$ {{ number_format($amount ?? 0, 2) }}</h4>
                </div>
                <div class="col-4">
                    <h4>S/. {{ number_format(($amount ?? 0), 2) }}</h4>
                </div>
            </div>
        </div>
    @endcan

    @can('Bonus Agente - Descuentos Actuales')
        <div class="ibox-content red-bg">
            <div class="row">
                <div class="col-4">
                    <h4>Descuentos Actuales</h4>
                </div>
                <div class="col-4">
                    <h4>$ {{ number_format($amountRetiro ?? 0, 2) }}</h4>
                </div>
                <div class="col-4">
                    <h4>S/. {{ number_format(($amountRetiro ?? 0) * 3.5, 2) }}</h4>
                </div>
            </div>
        </div>
    @endcan

    @can('Bonus Agente - Cuota Pendiente')
        <div class="ibox-content lazur-bg">
            <div class="row">
                <div class="col-4">
                    <h4>Cuota Pendiente</h4>
                </div>
                <div class="col-4">
                    <h4>$ {{ number_format(($cuotaPendiente) ?? 0, 2) }}</h4>
                </div>
                <div class="col-4">
                    <h4>S/. {{ number_format((($cuotaPendiente) ?? 0) * 3.5, 2) }}</h4>
                </div>
            </div>
        </div>
    @endcan
</div>
