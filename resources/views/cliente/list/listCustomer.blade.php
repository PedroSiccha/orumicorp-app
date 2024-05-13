{{-- <div class="ibox-content"> --}}
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Fecha de Ingreso</th>
            <th>ID de Cliente</th>
            <th>Nombre del Cliente</th>
            <th>Teléfono</th>
            <th>Teléfono Opcional</th>
            <th>Correo</th>
            <th>Ciudad</th>
            <th>Pais</th>
            <th>Comentario</th>
            <th>Acción</th>
        </tr>
        </thead>
        <tbody>
          @foreach ($customers as $customer)
              <tr @if($customer->status == 0) class="table-danger" @endif>
                  <td>{{  date("d/m/Y", strtotime($customer->date_admission)) }}</td>
                  <td>{{ $customer->code }}</td>
                  <td>
                      <a href="{{ route('profileClient', ['id' => $customer->id]) }}">
                          {{ $customer->name }} {{ $customer->lastname }}
                      </a>
                  </td>
                  <td>{{ $customer->phone }}</td>
                  <td>{{ $customer->optional_phone }}</td>
                  <td>{{ $customer->email }}</td>
                  <td>{{ $customer->city }}</td>
                  <td>{{ $customer->country }}</td>
                  <td>{{ $customer->comment }}</td>
                  <td>
                    <button class="btn btn-success" type="button" onclick="initiateCall({phone: '{{ $customer->dni }}'})"><i class="fa fa-phone"></i> </button>
                      @can('Asignar Agente')
                          <button class="btn btn-default " type="button" onclick="asignarAgente('{{ $customer->id }}', '{{ $customer->name }} {{ $customer->lastname }}', '#modalAsignarAgente', '#aId', '#nameClient')"><i class="fa fa-user"></i></button>
                      @endcan
                      @can('Estado Cliente')
                          @if ($customer->status == 0)
                              <button class="btn btn-info " type="button" onclick="cambiarEstado('{{ $customer->id }}', '{{ $customer->name }} {{ $customer->lastname }}', '#tabClient', '1')"><i class="fa fa-check"></i></button>
                          @else
                              <button class="btn btn-danger " type="button" onclick="cambiarEstado('{{ $customer->id }}', '{{ $customer->name }} {{ $customer->lastname }}', '#tabClient', '0')"><i class="fa fa-minus"></i></button>
                          @endif
                      @endcan
                      @can('Editar Cliente')
                      <button class="btn btn-warning " type="button" onclick="editarCliente(
                        '{{ $customer->id }}',
                        '{{ $customer->code }}',
                        '{{ $customer->name }}',
                        '{{ $customer->lastname }}',
                        '{{ $customer->phone }}',
                        '{{ $customer->optional_phone }}',
                        '{{ $customer->city }}',
                        '{{ $customer->country }}',
                        '{{ $customer->comment }}',
                        '{{ $customer->email }}',
                        '#modalEditarCliente',
                        '#eId',
                        '#eCode',
                        '#eName',
                        '#eLastname',
                        '#ePhone',
                        '#eOptionalPhone',
                        '#eCity',
                        '#eCountry',
                        '#eComment',
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
  {{-- </div> --}}
