<table class="table table-striped">
    <thead>
    <tr>
        <th>Fecha de Ingreso</th>
        <th>Bono</th>
        <th>Comisión en Soles</th>
        <th>Agente</th>
        <th>Area</th>
        <th>Comentario</th>
    </tr>
    </thead>
    <tbody>
      @foreach ($bonusAgent as $ba)
          <tr @if($ba->action_id == 3) class="table-danger" @endif>
              <td>{{ date("d/m/Y", strtotime($ba->date_admission)) }}</td>
              <td> $ {{ number_format($ba->commission, 2) }}</td>
              <td>S/. {{ number_format($ba->commission*3.5, 2) }}</td>
              <td>
                {{-- @can('Ver Perfil Agente') --}}
                <a href="{{ route('perfilUsuario', ['id' => $ba->agent->id]) }}">
                {{-- @endcan --}}
                {{ $ba->agent->name }} {{ $ba->agent->lastname }}
                {{-- @can('Ver Perfil Agente') --}}
                </a>
                {{-- @endcan --}}
              </td>
              <td>{{ $ba->agent->area->name }}</td>
              <td>{{ $ba->observation }}</td>
          </tr>
      @endforeach
    </tbody>
</table>
