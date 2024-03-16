<table class="table table-striped">
    <thead>
      <tr>
            <th>ID de Área</th>
            <th>Nombre del Área</th>
            <th>Descripción</th>
            <th>Cantidad de Agentes</th>
            <th>Acción</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($areas as $area)
          <tr @if($area->status == 0) class="table-danger" @endif>
              <td>{{ $area->id }}</td>
              <td>{{ $area->name }}</td>
              <td>{{ $area->description }}</td>
              <td>{{ $area->agents->count() }}</td>
              <td>
                  @can('Estado Area')
                      @if ($area->status == 0)
                          <button class="btn btn-info " type="button" onclick="cambiarEstado('{{ $area->id }}', '{{ $area->name }}', '1')"><i class="fa fa-check"></i></button>
                      @else
                          <button class="btn btn-danger " type="button" onclick="cambiarEstado('{{ $area->id }}', '{{ $area->name }}', '0')"><i class="fa fa-minus"></i></button>
                      @endif
                  @endcan
                  @can('Editar Area')
                  <button class="btn btn-warning " type="button" onclick="editarArea('{{ $area->id }}', '{{ $area->name }}', '{{ $area->description }}')"><i class="fa fa-pencil"></i></button>
                  @endcan
                  @can('Eliminar Area')
                  <button class="btn btn-danger " type="button" onclick="eliminarArea('{{ $area->id }}', '{{ $area->name }}')"><i class="fa fa-trash"></i></button>
                  @endcan
              </td>
          </tr>
      @endforeach
    </tbody>
</table>
