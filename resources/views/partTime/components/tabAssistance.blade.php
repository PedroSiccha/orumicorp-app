<table class="table table-striped">
    <thead>
      <tr>
            <th>Fecha de Asistencia</th>
            <th>Nombre del Agente</th>
            <th>Hora de Ingreso</th>
            <th>Hora de Break</th>
            <th>Vuelta de Break</th>
            <th>Hora de Salida</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($assistances as $assistance)
          <tr>
            <td>{{ $assistance->date }}</td>
            <td>{{ $assistance->name }} {{ $assistance->lastname }}</td>
            <td>{{ $assistance->IN }}</td>
            <td>{{ $assistance->INBREAK }}</td>
            <td>{{ $assistance->OUTBREAK }}</td>
            <td>{{ $assistance->OUT }}</td>
          </tr>
      @endforeach
    </tbody>
</table>
