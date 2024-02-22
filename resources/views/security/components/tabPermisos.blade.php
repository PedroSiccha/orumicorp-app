<table class="table table-striped">
    <thead>
      <tr>
            <th>ID</th>
            <th>Permiso</th>
            <th>Acción</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($permisos as $permiso)
          <tr>
              <td>{{ $permiso->id }}</td>
              <td>{{ $permiso->name }}</td>
              <td>{{ $permiso->guard_name }}</td>
              <td>
                  <button class="btn btn-warning " type="button"><i class="fa fa-pencil"></i></button>
                  <button class="btn btn-danger " type="button"><i class="fa fa-trash"></i></button>
              </td>
          </tr>
      @endforeach
    </tbody>
</table>
