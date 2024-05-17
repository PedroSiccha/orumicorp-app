{{-- <div class="ibox-content"> --}}
    <table class="table table-striped">
        <thead>
        <tr>
          @if ($configTablesDateInit->status == 'active')
              <th>Fecha de Ingreso</th>
          @endif
          @if ($configTablesCode->status == 'active')
              <th>ID de Cliente</th>
          @endif
              <th>Nombre del Cliente</th>
          @if ($configTablesPhone->status == 'active')
              <th>Teléfono</th>
          @endif
          @if ($configTablesOptionalPhone->status == 'active')
              <th>Teléfono Opcional</th>
          @endif
          @if ($configTablesEmail->status == 'active')
              <th>Correo</th>
          @endif
          @if ($configTablesCity->status == 'active')
              <th>Ciudad</th>
          @endif
          @if ($configTablesCountry->status == 'active')
              <th>Pais</th>
          @endif
          @if ($configTablesComment->status == 'active')
              <th>Comentario</th>
          @endif
              <th>Acción</th>
        </tr>
        </thead>
        <tbody>
          @foreach ($customers as $customer)

              <tr @if($customer->status == 0) class="table-danger" @endif>
                  @if ($configTablesDateInit->status == 'active')
                      <td>{{  date("d/m/Y", strtotime($customer->date_admission)) }}</td>
                  @endif
                  @if ($configTablesCode->status == 'active')
                      <td>{{ $customer->code }}</td>
                  @endif
                      <td>
                          <a href="{{ route('profileClient', ['id' => $customer->id]) }}">
                              {{ $customer->name }} {{ $customer->lastname }}
                          </a>
                      </td>
                  @if ($configTablesPhone->status == 'active')
                      <td>{{ $customer->phone }}</td>
                  @endif
                  @if ($configTablesOptionalPhone->status == 'active')
                      <td>{{ $customer->optional_phone }}</td>
                  @endif
                  @if ($configTablesEmail->status == 'active')
                      <td>{{ $customer->email }}</td>
                  @endif
                  @if ($configTablesCity->status == 'active')
                      <td>{{ $customer->city }}</td>
                  @endif
                  @if ($configTablesCountry->status == 'active')
                      <td>{{ $customer->country }}</td>
                  @endif
                  @if ($configTablesComment->status == 'active')
                      <td>{{ $customer->comment }}</td>
                  @endif
                      <td>
                          <button class="btn btn-success" type="button" onclick="initiateCall({phone: '{{ $customer->phone }}'})"><i class="fa fa-phone"></i> </button>

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
