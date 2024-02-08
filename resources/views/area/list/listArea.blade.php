<table class="table table-striped">
      <thead>
        <tr>
              <th>ID de Área</th>
              <th>Nombre del Área</th>
              <th>Descripción</th>
              <th>Acción</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($areas as $area)
            <tr>
                <td>{{ $area->id }}</td>
                <td>{{ $area->name }}</td>
                <td>{{ $area->description }}</td>
                <td>
                    <button class="btn btn-info " type="button"><i class="fa fa-check"></i></button>
                    <button class="btn btn-warning " type="button"><i class="fa fa-pencil"></i></button>
                    <button class="btn btn-danger " type="button"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        @endforeach
      </tbody>
  </table>