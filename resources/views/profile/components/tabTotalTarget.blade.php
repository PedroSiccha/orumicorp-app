<div class="col-4">
    <h4>Target Mensual</h4>
</div>

<div class="col-4">
    <h4>$ {{ number_format($targetMensual->amount ?: 0, 2) }}</h4>
</div>
<div class="col-4">
    <h4>S/. {{ number_format(($targetMensual->amount ?: 0)*3.5, 2) }}</h4>
</div>
