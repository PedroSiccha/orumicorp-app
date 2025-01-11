@if(isset($lastAssignament) && isset($lastAssignament->agent))
    <div class="col-lg-4 text-center">
        <h2>{{ $lastAssignament->agent->name }}</h2>
        <div class="m-b-sm">
            <img alt="image" class="rounded-circle" src="{{ $lastAssignament->agent->img ?? asset('img/logo/basic_logo.png') }}" style="width: 62px">
        </div>
    </div>
    <div class="col-lg-8">
        <strong>Fecha de Asignación: {{ $lastAssignament->date->format('d/m/Y H:i:s') }}</strong>
        <p>
            {{ $lastAssignament->comment }}
        </p>
        <button type="button" class="btn btn-primary btn-sm btn-block">
            <i class="fa fa-envelope"></i> Send Message
        </button>
    </div>
@else
    <div class="col-lg-12 text-center">
        <h2>Aun no tiene agente asignado</h2>
        <button type="button" class="btn btn-primary btn-sm btn-block" onclick="asignarAgentePorPerfil('{{ $dataCustomer->id }}', '{{ $dataCustomer->name }} {{ $dataCustomer->lastname }}', '#modalAsignAgentByProfile', '#idClientesAsignacion', '#nameClient')">
            <i class="fa fa-plus"></i> Asignar Agente
        </button>
    </div>
@endif
