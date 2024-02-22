<table class="table table-striped">
    <thead>
      <tr>
            <th>ID</th>
            <th>Rol</th>
            <th>Tipo</th>
            <th>Acción</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($roles as $rol)
          <tr>
              <td>{{ $rol->id }}</td>
              <td>{{ $rol->name }}</td>
              <td>{{ $rol->guard_name }}</td>
              <td>
                  <button class="btn btn-warning " type="button"><i class="fa fa-pencil"></i></button>
                  <button class="btn btn-danger " type="button"><i class="fa fa-trash"></i></button>
              </td>
          </tr>
      @endforeach
    </tbody>
</table>
