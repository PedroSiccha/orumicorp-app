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
                <div class="ibox-content" id="componentDataClient">
                    <h3>Datos Personales</h3>
                    @can('Perfil Cliente - Ver Codigo')
                        <div class="form-group">
                            <label>Código</label>
                            <input type="text" class="form-control" placeholder="Ingrese su código" id="code" value="{{ $dataCustomer->code }}" readonly>
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
                    {{-- @can('Perfil Cliente - Ver Ciudad')
                        <div class="form-group">
                            <label>Ciudad</label>
                            <input type="text" class="form-control" placeholder="Ingrese su ciudad" id="city" value="{{ $dataCustomer->city }}">
                        </div>
                    @endcan --}}
                    @can('Perfil Cliente - Ver Pais')
                        <div class="form-group">
                            <label>País</label>
                            <input type="text" class="form-control" placeholder="Ingrese su país" id="country" value="{{ $dataCustomer->country }}">
                        </div>
                    @endcan
                    <button class="btn btn-primary btn-block" onclick="updateClientProfile(
                        '#code',
                        '#name',
                        '#lastname',
                        '#email',
                        '#phone',
                        '#optionalPhone',
                        '#country',
                        '#componentDataClient')">Actualizar</button> 
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
                        <li><a class="nav-link" data-toggle="tab" href="#tab-assignments"><i class="fa fa-group"></i> Asignaciones</a></li>
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
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($eventos as $evento)
                                                <tr>
                                                    <td>{{ $evento->id }}</td>
                                                    <td>Fecha del evento: {{ $evento->formatted_date }}</td>
                                                    <td>{{ $evento->timeStart }}</td>
                                                    <td>{{ $evento->timeEnd }}</td>
                                                    <td>{{ $evento->name }}</td>
                                                    <td>{{ $evento->agent->name }} {{ $evento->agent->lastname }}</td>
                                                    <td>{{ $evento->priority->name }}</td>
                                                    <td>{{ $evento->description }}</td>
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

                        <div id="tab-assignments" class="tab-pane">
                            <div class="panel-body">
                                <div class="ibox-content">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Agente</th>
                                                <th>Fecha</th>
                                                <th>Asignado Por</th>
                                                <th>Comentario</th>
                                                <th>Descripción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($listAssignaments as $listAssignament)
                                                @if(is_object($listAssignament))
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $listAssignament->agent->name.' '.$listAssignament->agent->lastname ?? 'Sin Agente' }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($listAssignament->date)->format('d/m/Y H:i:s') }}</td>
                                                        <td>{{ $listAssignament->assignedBy->name.' '.$listAssignament->assignedBy->lastname ?? 'Sin Agente' }}</td>
                                                        <td>{{ $listAssignament->comment }}</td>
                                                        <td>{{ $listAssignament->descripcion }}</td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td colspan="4">Datos inválidos: {{ var_dump($listAssignament) }}</td>
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
    var updateClientProfileRoute = '{{ route("updateClientProfile") }}';

    document.addEventListener("DOMContentLoaded", function () {
        let dateInput = document.getElementById("dateEvent");
        let horaInicio = document.getElementById("horaInicio");
        let horaFin = document.getElementById("horaFin");
        let saveButton = document.querySelector(".btn-success"); // Botón de "Guardar"

        // Establecer la fecha mínima al cargar la página
        let today = new Date().toISOString().split("T")[0];
        dateInput.setAttribute("min", today);
        saveButton.disabled = true; // Bloquear el botón de inicio

        // Función para obtener la hora actual + 1 hora en formato HH:MM
        function getMinHour() {
            let now = new Date();
            // now.setHours(now.getHours() + 1); // Sumar 1 hora
            now.setHours(now.getHours() + 0);
            return now.toTimeString().slice(0, 5); // Formato HH:MM
        }

        // Función para validar la fecha
        function validateDate() {
            if (dateInput.value < today) {
                // alert("No puedes ingresar una fecha anterior a hoy.");
                // dateInput.value = today;
                dateInput.classList.add("border-danger");
                saveButton.disabled = true;
            } else {
                dateInput.classList.remove("border-danger");
                // validateHours(); // Validar horas después de validar fecha
                
            }
        }

        // Función para validar las horas
        // function validateHours() {
        //     let minHour = getMinHour();
        //     let startTime = horaInicio.value;
        //     let endTime = horaFin.value;

        //     // Resetear clases y validaciones
        //     horaInicio.classList.remove("border-danger");
        //     horaFin.classList.remove("border-danger");
        //     saveButton.disabled = false;

        //     // Validar hora de inicio (debe ser al menos 1 hora después de la actual)
        //     if (startTime && startTime < minHour) {
        //         // alert("La hora de inicio debe ser al menos 1 hora después de la actual.");
        //         horaInicio.value = "";
        //         horaInicio.classList.add("border-danger");
        //         saveButton.disabled = true;
        //     }

        //     // Validar hora de fin (debe ser mayor que la hora actual + 1)
        //     if (endTime && endTime < minHour) {
        //         // alert("La hora de fin debe ser al menos 1 hora después de la actual.");
        //         horaFin.value = "";
        //         horaFin.classList.add("border-danger");
        //         saveButton.disabled = true;
        //     }

        //     // Validar que la hora de fin sea mayor que la de inicio
        //     if (startTime && endTime && endTime <= startTime) {
        //         // alert("La hora de fin debe ser mayor que la hora de inicio.");
        //         horaFin.value = "";
        //         horaFin.classList.add("border-danger");
        //         saveButton.disabled = true;
        //     }
        // }

        // Eventos de validación
        dateInput.addEventListener("input", validateDate);
        dateInput.addEventListener("change", validateDate);
        // horaInicio.addEventListener("input", validateHours);
        // horaInicio.addEventListener("change", validateHours);
        // horaFin.addEventListener("input", validateHours);
        // horaFin.addEventListener("change", validateHours);
    });






</script>
<script src="{{ asset('js/utils/mostrarNuevoModal.js') }}"></script>
<script src="{{ asset('js/customer/client.js') }}"></script>
<script src="{{ asset('js/utils/mostrarMensaje.js') }}"></script>
<script src="{{ asset('js/agent/searchAgent.js') }}"></script>
<script src="{{ asset('js/customer/searchClient.js') }}"></script>
<script src="{{ asset('js/agent/assignGroupAgentByProfile.js') }}"></script>
@endsection
 