<table class="table table-striped">
    <thead>
      <tr>
            <th>Estado</th>
            <th>ID de Agente</th>
            <th>Nombre del Agente</th>
            <th>Código Voiso</th>
            <th>Área</th>
            <th>Correo</th>
            <th>Cantidad de Giros</th>
            <th>Acción</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($agents as $agent)
          <tr @if($agent->status == 0) class="table-danger" @endif>
              <td><p @if($agent->status_voiso == 'LIBRE') class="text-navy" @else class="text-danger" @endif>{{ $agent->status_voiso }}</p></td>
              <td>{{ $agent->code }}</td>
              <td>
                  <a href="{{ route('perfilUsuario', ['id' => $agent->user->id]) }}">
                      {{ $agent->name }} {{ $agent->lastname }}
                  </a>
              </td>
              <td>{{ $agent->code_voiso }}</td>
              <td>{{ $agent->area->name }}</td>
              <td>{{ $agent->user->email }}</td>
              <td>{{ $agent->number_turns }}</td>
              <td>
                  {{-- @can('Asignar Cantidad Giros') --}}
                      <button class="btn btn-default" type="button" onclick="asignarCantGiros('{{ $agent->id }}', '{{ $agent->name }} {{ $agent->lastname }}')"><i class="fa fa-dashboard"></i></button>
                  {{-- @endcan --}}
                  {{-- @can('Estado Agente') --}}
                      @if ($agent->status == 0)
                          <button class="btn btn-info " type="button" onclick="cambiarEstado('{{ $agent->id }}', '{{ $agent->name }} {{ $agent->lastname }}', '1')"><i class="fa fa-check"></i></button>
                      @else
                          <button class="btn btn-danger " type="button" onclick="cambiarEstado('{{ $agent->id }}', '{{ $agent->name }} {{ $agent->lastname }}', '0')"><i class="fa fa-minus"></i></button>
                      @endif
                  {{-- @endcan
                  @can('Editar Agente') --}}
                  <button class="btn btn-warning " type="button" onclick="editarAgente('{{ $agent->id }}', '{{ $agent->code }}', '{{ $agent->name }}', '{{ $agent->lastname }}', '{{ $agent->code_voiso }}', '{{ $agent->email }}', '{{ $agent->area->id }}', '{{ $agent->user->roles->first()->id ?? '1' }}')"><i class="fa fa-pencil"></i></button>
                  {{-- @endcan
                  @can('Eliminar Agente') --}}
                  <button class="btn btn-danger " type="button" onclick="eliminarAgente('{{ $agent->id }}', '{{ $agent->name }} {{ $agent->lastname }}')"><i class="fa fa-trash"></i></button>
                  {{-- @endcan --}}

              </td>
          </tr>
      @endforeach
    </tbody>
</table>
{{ $agents->links() }}

