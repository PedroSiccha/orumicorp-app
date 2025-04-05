<div class="ibox-content navy-bg">
    <div class="row" id="tabTotalTarget">
        <div class="col-4">
            <h4>Target Mensual</h4>
        </div>
        <div class="col-4">
            <h4>$ {{ isset($reportTargetMensual) ? number_format(($reportTargetMensual), 2): '0.00' }}</h4>
        </div>
        <div class="col-4">
            <h4>S/. {{ isset($reportTargetMensual) ? number_format(($reportTargetMensual)*3.5, 2): '0.00' }}</h4>
        </div>
    </div>
</div>

@can('Bonus Agente - Ingresos Actuales')
    <div class="ibox-content yellow-bg">
        <div class="row">
            <div class="col-4">
                <h4>Ingresos Actuales</h4>
            </div>
            <div class="col-4">
                <h4>$ {{ isset($amount) ? number_format(($amount), 2): '0.00' }}</h4>
            </div>
            <div class="col-4">
                <h4>S/. {{ isset($amount) ? number_format(($amount), 2): '0.00' }}</h4>
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
                <h4>$ {{ isset($amountRetiro) ? number_format(($amountRetiro), 2): '0.00' }}</h4>
            </div>
            <div class="col-4">
                <h4>S/. {{ isset($amountRetiro) ? number_format(($amountRetiro)*3.5, 2): '0.00' }}</h4>
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
                <h4>$ {{ isset($reportTargetMensual) ? number_format(($reportTargetMensual - $amount), 2): '0.00' }}</h4>
            </div>
            <div class="col-4">
                <h4>S/. {{ isset($reportTargetMensual) ? number_format(($reportTargetMensual - $amount)*3.5, 2): '0.00' }}</h4>
            </div>
        </div>
    </div>
@endcan
