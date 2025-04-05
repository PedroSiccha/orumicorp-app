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