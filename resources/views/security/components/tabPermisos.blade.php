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
                @can('Quitar Permiso')
                    <button class="btn btn-danger " type="button" onclick="deletePermiso('{{ $permiso->id }}', '#idRol')"><i class="fa fa-trash"></i></button>
                @endcan
              </td>
          </tr>
      @endforeach
    </tbody>
</table>
