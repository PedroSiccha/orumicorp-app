@extends('layouts.app')
@section('title')
      Perfil de Usuario
@endsection

@section('content')

<div class="row m-b-lg m-t-lg">

    <div class="col-md-6">
        <div class="profile-image">
            <img src="{{ $dataCustomer->img ?? asset('img/logo/basic_logo.png') }}" class="rounded-circle circle-border m-b-md" alt="profile">
        </div>
        <div class="profile-info">
            <div class="">
                <div>
                    <h2 class="no-margins">
                        {{ $dataCustomer->name }} {{ $dataCustomer->lastname }}
                    </h2>
                    <h4>{{ $dataCustomer->email }}</h4>
                    <small>
                        {{ $dataCustomer->comment }}
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="row col-md-12">

        <div class="col-lg-4">

            <div class="ibox">
                <div class="ibox-content">
                    <h3>Datos Personales</h3>
                    @can('Perfil Cliente - Ver Codigo')
                        <div class="form-group">
                            <label>Código</label>
                            <input type="text" class="form-control" placeholder="Ingrese su código" id="code" value="{{ $dataCustomer->code }}">
                        </div>
                    @endcan
                    @can('Perfil Cliente - Ver Nombre')
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" class="form-control" placeholder="Ingrese su nómbre" id="name" value="{{ $dataCustomer->name }}">
                        </div>
                    @endcan
                    @can('Perfil Cliente - Ver Apellido')
                        <div class="form-group">
                            <label>Apellido</label>
                            <input type="text" class="form-control" placeholder="Ingrese su apellido" id="lastname" value="{{ $dataCustomer->lastname }}">
                        </div>
                    @endcan
                    @can('Perfil Cliente - Ver Correo')
                        <div class="form-group">
                            <label>Corréo</label>
                            <input type="email" class="form-control" placeholder="Ingrese su corréo" id="email" value="{{ $dataCustomer->email }}">
                        </div>
                    @endcan
                    @can('Perfil Cliente - Ver Telefono')
                        <div class="form-group">
                            <label>Teléfono</label>
                            <input type="text" class="form-control" placeholder="Ingrese su teléfono" id="phone" value="{{ $dataCustomer->phone }}">
                        </div>
                    @endcan
                    @can('Perfil Cliente - Ver Telefono Opcional')
                        <div class="form-group">
                            <label>Teléfono Opcional</label>
                            <input type="text" class="form-control" placeholder="Ingrese su teléfono opcional" id="optionalPhone" value="{{ $dataCustomer->optional_phone }}">
                        </div>
                    @endcan
                    @can('Perfil Cliente - Ver Ciudad')
                        <div class="form-group">
                            <label>Ciudad</label>
                            <input type="text" class="form-control" placeholder="Ingrese su ciudad" id="city" value="{{ $dataCustomer->city }}">
                        </div>
                    @endcan
                    @can('Perfil Cliente - Ver Pais')
                        <div class="form-group">
                            <label>País</label>
                            <input type="text" class="form-control" placeholder="Ingrese su país" id="country" value="{{ $dataCustomer->country }}">
                        </div>
                    @endcan
                    <button class="btn btn-primary btn-block">Actualizar</button>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="social-feed-box">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li><a class="nav-link active" data-toggle="tab" href="#tab-resum"> <i class="fa fa-newspaper-o"></i> Resumen</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#tab-coment"><i class="fa fa-comment-o"></i> Comentarios</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#tab-call"><i class="fa fa-mobile"></i> Llamadas</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#tab-task"><i class="fa fa-calendar"></i> Task</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#tab-campaing"><i class="fa fa-cc"></i> Campañas</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#tab-provider"><i class="fa fa-group"></i> Proveedores</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#tab-views"><i class="fa fa-group"></i> Visualización</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-resum" class="tab-pane active">
                            <div class="panel-body">

                                <div class="col-sm-12">
                                    <div class="ibox selected">

                                        <div class="ibox-content">
                                            <div class="tab-content">
                                                <div id="contact-1" class="tab-pane active">
                                                    <div class="row m-b-lg" id="agentAssignament">
                                                        @include('cliente.components.assignedAgent')
                                                    </div>

                                                    <div class="client-detail">
                                                    <div class="full-height-scroll">

                                                        <strong>Ultima Campaña</strong>
                                                        @if ($lastCampaing)
                                                            <ul class="list-group clear-list">
                                                                <li class="list-group-item fist-item">
                                                                    {{ $lastCampaing->name }}
                                                                </li>
                                                            </ul>
                                                        @else
                                                            <ul class="list-group clear-list">
                                                                <li class="list-group-item fist-item">
                                                                    Aun sin campañas
                                                                </li>
                                                            </ul>
                                                        @endif
                                                        <strong>Ultimo Proveedor</strong>
                                                        @if ($lastProvider)
                                                            <ul class="list-group clear-list">
                                                                <li class="list-group-item fist-item">
                                                                    {{ $lastProvider->name }}
                                                                </li>
                                                            </ul>
                                                        @else
                                                            <ul class="list-group clear-list">
                                                                <li class="list-group-item fist-item">
                                                                    Aun sin proveedores
                                                                </li>
                                                            </ul>
                                                        @endif


                                                        <strong>Ultimas llamadas</strong>
                                                        <hr/>
                                                        <strong>Timeline llamadas</strong>
                                                        <div id="vertical-timeline" class="vertical-container dark-timeline">
                                                            @foreach ($communications as $communication)
                                                                @if(is_object($communication))
                                                                    <div class="vertical-timeline-block">
                                                                        <div class="vertical-timeline-icon navy-bg">
                                                                            <i class="fa fa-phone"></i>
                                                                        </div>
                                                                        <div class="vertical-timeline-content">
                                                                            <p>Agente que llamó: {{ $communication->agent->name.' '.$communication->agent->lastname ?? 'Sin Agente' }}.</p>
                                                                            <span class="vertical-date small text-muted"> {{ $communication->date->format('d/m/Y H:i:s') }} </span>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <div class="vertical-timeline-block">
                                                                        <div class="vertical-timeline-icon">
                                                                            <i class="fa fa-phone"></i>
                                                                        </div>
                                                                        <div class="vertical-timeline-content">
                                                                            <p>Aun sin llamadas.</p>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div id="tab-coment" class="tab-pane">
                            <div class="panel-body">
                                <div class="ibox-content">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Comentario</th>
                                                <th>Agente</th>
                                                <th>Estado</th>
                                                <th>Fecha Registro</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($communications as $communication)
                                                @if(is_object($communication))
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td> <!-- Número de fila -->
                                                        <td>{{ $communication->comment ?? 'Sin Comentario' }}</td>
                                                        <td>{{ $communication->agent->name.' '.$communication->agent->lastname ?? 'Sin Agente' }}</td> <!-- Muestra 'Sin Agente' si no hay agente -->
                                                        <td>{{ $communication->status }}</td>
                                                        <td>{{ $communication->date->format('d/m/Y H:i:s') }}</td> <!-- Formato de fecha -->
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td colspan="4">Datos inválidos: {{ var_dump($communication) }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                        <div id="tab-call" class="tab-pane">
                            <div class="panel-body">
                                <div class="ibox-content">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Fecha de Llammada</th>
                                            <th>Agente</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($communications as $communication)
                                                @if(is_object($communication))
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td> <!-- Número de fila -->
                                                        <td>{{ $communication->date->format('d/m/Y H:i:s') }}</td> <!-- Formato de fecha -->
                                                        <td>{{ $communication->agent->name.' '.$communication->agent->lastname ?? 'Sin Agente' }}</td> <!-- Muestra 'Sin Agente' si no hay agente -->
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td colspan="4">Datos inválidos: {{ var_dump($communication) }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="tab-task" class="tab-pane">
                            <div class="panel-body">
                                <button type="button" class="btn btn-primary btn-sm btn-block" onclick="mostrarNuevoModal('#modalNuevaTarea')">
                                    <i class="fa fa-plus"></i> Agregar Tarea
                                </button>
                                <div class="ibox-content" id="tabTaskClient">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Fecha</th>
                                            <th>Hora Inicio</th>
                                            <th>Hora de Fin</th>
                                            <th>Evento</th>
                                            <th>Agente</th>
                                            <th>Prioridad</th>
                                            <th>Detalle</th>
                                            <th>Estado</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($eventos as $evento)
                                                <tr>
                                                    <td>{{ $evento->id }}</td>
                                                    <td>13/05/2024</td>
                                                    <td>13:30</td>
                                                    <td>14:30</td>
                                                    <td>Evento de Prueba</td>
                                                    <td>Agente Prueba</td>
                                                    <td>BAJO</td>
                                                    <td>Esto es una prueba</td>
                                                    <td>Pendiente</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="tab-campaing" class="tab-pane">
                            <div class="panel-body">
                                <div class="ibox-content">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nombre</th>
                                                <th>Descripción</th>
                                                <th>Inicio</th>
                                                <th>Fin</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($campaings) && $campaings->isNotEmpty())
                                                @foreach ($campaings as $campaign)

                                                    @if(is_object($campaign))
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td> <!-- Número de fila -->
                                                            <td>{{ $campaign->name ?? 'N/A' }}</td> <!-- Nombre de la campaña -->
                                                            <td>{{ $campaign->description ?? 'N/A' }}</td> <!-- Descripción de la campaña -->
                                                            <td>{{ $campaign->start_date ?? 'N/A' }}</td> <!-- Formato de fecha -->
                                                            <td>{{ optional($campaign->end_date)->format('d/m/Y H:i:s') ?? 'N/A' }}</td> <!-- Formato de fecha -->
                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <td colspan="5">Datos inválidos: {{ var_dump($campaign) }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5">No hay campañas disponibles</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="tab-provider" class="tab-pane">
                            <div class="panel-body">
                                <div class="ibox-content">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nombre</th>
                                                <th>Teléfono</th>
                                                <th>Correo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($providers as $provider)
                                                @if(is_object($provider))
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td> <!-- Número de fila -->
                                                        <td>{{ $provider->name }}</td>
                                                        <td>{{ $provider->phone }}</td> <!-- Muestra 'Sin Agente' si no hay agente -->
                                                        <td>{{ $provider->email }}</td> <!-- Formato de fecha -->
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td colspan="4">Datos inválidos: {{ var_dump($provider) }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div id="tab-views" class="tab-pane">
                            <div class="panel-body">
                                <div class="ibox-content">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Agente</th>
                                                <th>Fecha Y Hora de Visita</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($vistas as $vista)
                                                @if(is_object($vista))
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $vista->agent->name.' '.$vista->agent->lastname ?? 'Sin Agente' }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($vista->viewed_at)->format('d/m/Y H:i:s') }}</td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td colspan="4">Datos inválidos: {{ var_dump($vista) }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@include('cliente.modal.modalNuevaTarea')
@include('cliente.modal.modalAsignAgentByProfile')
@endsection
@section('script')
<script>
    var saveEventClientRoute = '{{ route("saveEventClient") }}';
    var searchAgentRoute = '{{ route("searchAgent") }}';
    var searchClientRoute = '{{ route("searchCustomer") }}';
    var asignAgentByProfileRoute = '{{ route("asignAgentByProfile") }}';
</script>
<script src="{{ asset('js/utils/mostrarNuevoModal.js') }}"></script>
<script src="{{ asset('js/customer/client.js') }}"></script>
<script src="{{ asset('js/utils/mostrarMensaje.js') }}"></script>
<script src="{{ asset('js/agent/searchAgent.js') }}"></script>
<script src="{{ asset('js/customer/searchClient.js') }}"></script>
<script src="{{ asset('js/agent/assignGroupAgentByProfile.js') }}"></script>
@endsection
