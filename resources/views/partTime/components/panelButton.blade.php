@can('Registrar Asistencia')
<h3>
    Registro de Asistencia
</h3>

<div class="form-group" id="data_2">
    <label class="font-normal">Entrada</label>
    @if ( $dateIn )
        <button class="btn btn-outline btn-success  dim form-control" type="button"><i class="fa fa-address-card-o"></i> {{ $dateIn->hour }}</button>
    @else
    <button class="btn btn-outline btn-success  dim form-control" type="button" onclick="registerAssitance('{{ date('Y-m-d') }}', '#comentario', 'IN', '#panelButton', '#tabAssistance')"><i class="fa fa-address-card-o"></i> Marcar Entrada</button>
    @endif
</div>

<div class="form-group" id="data_3">
    <label class="font-normal">Break</label>
    @if ( $dateBreakIn )
        <button class="btn btn-outline btn-warning  dim form-control" type="button"><i class="fa fa-cutlery"></i> <i class="fa fa-arrow-circle-o-left"></i> {{ $dateBreakIn->hour }}</button>
    @else
        <button class="btn btn-outline btn-warning  dim form-control" type="button" onclick="registerAssitance('{{ date('Y-m-d') }}', '#comentario', 'IN-BREAK', '#panelButton', '#tabAssistance')"><i class="fa fa-cutlery"></i> <i class="fa fa-arrow-circle-o-left"></i> Marcar Salia Break</button>
    @endif
</div>

<div class="form-group" id="data_3">
    <label class="font-normal">Break</label>
    @if ( $dateBreakOut )
        <button class="btn btn-outline btn-primary  dim form-control" type="button"><i class="fa fa-cutlery"></i> <i class="fa fa-arrow-circle-o-right"></i> {{ $dateBreakOut->hour }}</button>
    @else
        <button class="btn btn-outline btn-primary  dim form-control" type="button" onclick="registerAssitance('{{ date('Y-m-d') }}', '#comentario', 'OUT-BREAK', '#panelButton', '#tabAssistance')"><i class="fa fa-cutlery"></i> <i class="fa fa-arrow-circle-o-right"></i> Marcar Vuelta Break</button>
    @endif
</div>

<div class="form-group" id="data_4">
    <label class="font-normal">Salida</label>
    @if ( $dateOut )
        <button class="btn btn-outline btn-danger  dim form-control" type="button"><i class="fa fa-bus"></i> {{ $dateOut->hour }}</button>
    @else
        <button class="btn btn-outline btn-danger  dim form-control" type="button" onclick="registerAssitance('{{ date('Y-m-d') }}', '#comentario', 'OUT', '#panelButton', '#tabAssistance')"><i class="fa fa-bus"></i> Marcar Salida</button>
    @endif
</div>

<div class="form-group row"><label class="col-lg-2 col-form-label">Comentarios</label>
        <div class="col-lg-10">
        <textarea class="form-control" placeholder="Ingrese su comentario" id="comentario"></textarea>
        </div>
    </div>
@endcan
