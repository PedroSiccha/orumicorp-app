<table class="table table-striped">
      <thead>
        <tr>
              <th>ID de Agente</th>
              <th>Nombre del Agente</th>
              <th>DNI</th>
              <th>Área</th>
              <th>Correo</th>
              <th>Acción</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($agents as $agent)
            <tr>
                <td>{{ $agent->code }}</td>
                <td>{{ $agent->name }} {{ $agent->lastname }}</td>
                <td>{{ $agent->dni }}</td>
                <td>{{ $agent->area->name }}</td>
                <td>{{ $agent->user->email }}</td>
                <td>
                    <button class="btn btn-info " type="button"><i class="fa fa-check"></i></button>
                    <button class="btn btn-warning " type="button"><i class="fa fa-pencil"></i></button>
                    <button class="btn btn-danger " type="button"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        @endforeach
      </tbody>
  </table>
