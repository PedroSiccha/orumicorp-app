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

              </td>
          </tr>
      @endforeach
    </tbody>
</table>
