{{-- <div class="ibox-content"> --}}
      <table class="table table-striped">
          <thead>
          <tr>
              <th>Fecha de Ingreso</th>
              <th>ID de Cliente</th>
              <th>Nombre del Cliente</th>
              <th>Acción</th>
          </tr>
          </thead>
          <tbody>
            @foreach ($customers as $customer)
                <tr>
                    <td>{{  date("d/m/Y", strtotime($customer->date_admission)) }}</td>
                    <td>{{ $customer->code }}</td>
                    <td>
                        <a href="{{ route('perfilUsuario', ['id' => $customer->id]) }}">
                            {{ $customer->name }} {{ $customer->lastname }}
                        </a>
                    </td>
                    <td>
                        <button class="btn btn-default " type="button" onclick="asignarAgente('{{ $customer->id }}', '{{ $customer->name }} {{ $customer->lastname }}', '#modalAsignarAgente', '#aId', '#nameClient')"><i class="fa fa-user"></i></button>
                        @can('Estado Cliente')
                        <button class="btn btn-info " type="button" onclick="cambiarEstado('{{ $customer->id }}', '{{ $customer->name }} {{ $customer->lastname }}', '#tabClient')"><i class="fa fa-check"></i></button>
                        @endcan
                        @can('Editar Cliente')
                        <button class="btn btn-warning " type="button" onclick="editarCliente(
                            '{{ $customer->id }}',
                            '{{ $customer->code }}',
                            '{{ $customer->name }}',
                            '{{ $customer->lastname }}',
                            '{{ $customer->dni }}',
                            '{{ $customer->user->email }}',
                            '#modalEditarCliente',
                            '#eId',
                            '#eCode',
                            '#eName',
                            '#eLastname',
                            '#ePhone',
                            '#eEmail'
                            )"><i class="fa fa-pencil"></i></button>
                        @endcan
                        @can('Eliminar Cliente')
                        <button class="btn btn-danger " type="button" onclick="eliminarCliente('{{ $customer->id }}', '{{ $customer->name }} {{ $customer->lastname }}', '#tabClient')"><i class="fa fa-trash"></i></button>
                        @endcan
                    </td>
                </tr>
            @endforeach
          </tbody>
      </table>
    <div class="pagination justify-content-center">
        {{ $customers->links() }}
    </div>
  {{-- </div> --}}
