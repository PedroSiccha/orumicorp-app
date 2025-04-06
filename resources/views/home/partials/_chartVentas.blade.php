{{-- resources/views/home/partials/_chartVentas.blade.php --}}
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-content">
                <div>
                    <span class="float-right text-right">
                        Total de Ventas: $ {{ number_format($montoVenta + $montoRetencion, 2) }}
                    </span>
                    <h3 class="font-bold no-margins">Ventas</h3>
                </div>

                <div class="m-t-sm">
                    <div class="row">
                        <div class="col-md-12">
                            @include('home.partials.shimmers._shimmerChart')
                            <canvas id="lineChart" height="114"></canvas>
                        </div>
                    </div>
                </div>

                <div class="m-t-md">
                    <small class="float-left">
                        <i class="fa fa-clock-o"></i>
                        Actualizado <span id="fecha_actual"></span>
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
