<table class="table table-striped">
    <thead>
        <tr>
            <th>
                Seleccionar Todo
                <div class="i-checks">
                <label>
                    <input type="checkbox" id="selectAllCheckboxes" class="i-checks flat" name="selectAll">
                    <i></i>
                </label>
            </div></div></th>
            <th>
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        Última llamada
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" onclick="filterOrder({ order: 'comunications.date', type: 'DESC', tableName: '#tabClient' })">Más Recientes</a>
                        <a class="dropdown-item" onclick="filterOrder({ order: 'comunications.date', type: 'ASC', tableName: '#tabClient' })">Más Antigüos</a>
                    </div>
                </div>
            </th>
            <th>
                <div class="dropdown">
                    COD. de Cliente
                </div>
            </th>
            <th>
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        Fecha de Ingreso
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" onclick="filterOrder({ order: 'date_admission', type: 'DESC', tableName: '#tabClient' })">Más Recientes</a>
                        <a class="dropdown-item" onclick="filterOrder({ order: 'date_admission', type: 'ASC', tableName: '#tabClient' })">Más Antigüos</a>
                    </div>
                </div>
            </th>
            <th>
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        Fecha de Última Llamada
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" onclick="filterOrder({ order: 'comunications.date', type: 'DESC', tableName: '#tabClient' })">Más Recientes</a>
                        <a class="dropdown-item" onclick="filterOrder({ order: 'comunications.date', type: 'ASC', tableName: '#tabClient' })">Más Antigüos</a>
                    </div>
                </div>
            </th>
            <th>
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        Fecha de última Asignación
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" onclick="filterOrder({ order: 'latestAssignamet.date', type: 'DESC', tableName: '#tabClient' })">Más Recientes</a>
                        <a class="dropdown-item" onclick="filterOrder({ order: 'latestAssignamet.date', type: 'ASC', tableName: '#tabClient' })">Más Antigüos</a>
                    </div>
                </div>
            </th>
            <th>
                <div class="dropdown">
                    Asignado Por
                </div>
            </th>
            <th>
                <div class="dropdown">
                    Proveedor
                </div>
            </th>
            <th>
                <div class="dropdown">
                    Nombre del Cliente
                </div>
            </th>
            <th>
                <div class="dropdown">
                    Correo
                </div>
            </th>
            <th>
                <div class="dropdown">
                    Teléfono
                </div>
            </th>
            <th>
                <div class="dropdown">
                    Teléfono Opcional
                </div>
            </th>
            {{-- <th>
                <div class="dropdown">
                    Ciudad
                </div>
            </th> --}}
            <th>
                <div class="dropdown">
                    País
                </div>
            </th>
            <th>
                <div class="dropdown">
                    Estado
                </div>
            </th>
            <th>
                <div class="dropdown">
                    Agente
                </div>
            </th>
            <th>Comentario</th>
            <th>
                <div class="dropdown">
                    Última Visita
                </div>
            </th>
            <th>
                <div class="dropdown">
                    FTD Date
                </div>
            </th>
            <th>
                <div class="dropdown">
                    Método
                </div>
            </th>
            <th>
                <div class="dropdown">
                    N° de Depósito
                </div>
            </th>
            <th>
                <div class="dropdown">
                    Total Depósito
                </div>
            </th>
            <th>
                <div class="dropdown">
                    Folder
                </div>
            </th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($customers as $customer)
            <tr class="{{ $customer->status_color }}">
                <td>
                    <div class="i-checks"><label> <input type="checkbox" class="i-checks flat chekboxses" name="idGroupClientes[]" value="{{ $customer->id }}" id="idGroupClientes"> <i></i> </label></div>
                </td>
                <td>
                    @if ($customer->latestComunication)
                        {{ date("d/m/Y", strtotime($customer->latestComunication->date)) }}
                    @else
                        Sin Comunicación
                    @endif
                </td>
                <td>{{ $customer->code }}</td>
                <td>{{  date("d/m/Y", strtotime($customer->date_admission)) }}</td>
                <td>
                    @if ($customer->latestComunication)
                        {{ date("d/m/Y", strtotime($customer->latestComunication->date)) }}
                    @else
                        Sin Comunicación
                    @endif
                </td>
                <td>
                    @if ($customer->latestAssignamet)
                        {{ date("d/m/Y", strtotime($customer->latestAssignamet->date)) }}
                    @else
                        Sin Asignacion
                    @endif
                </td>
                <td>
                    @if ($customer->latestAssignametBy)
                        {{ $customer->latestAssignametBy->assignedBy->name }}
                    @else
                        Sin Asignacion
                    @endif
                </td>
                <td>
                    @if ($customer->provider)
                        {{ $customer->provider->name }}
                    @else
                        Sin Proveedor
                    @endif
                </td>
                <td>
                    @can('Ver Perfil Cliente')
                        <a onclick="saveVista({ client_id: '{{ $customer->id }}' })" href="{{ route('profileClient', ['id' => $customer->id]) }}">
                            {{ $customer->name }} {{ $customer->lastname }}
                        </a>
                    @else
                        <a>
                            {{ $customer->name }} {{ $customer->lastname }}
                        </a>
                    @endcan
                </td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->phone }}</td>
                <td>{{ $customer->optiomal_phone }}</td> <!-- Modificar Número Opcional -->
                {{-- <td>{{ $customer->city }}</td> --}}
                <td>{{ $customer->country }}</td>
                <td>
                    @if ($customer->statusCustomer)
                        {{ $customer->statusCustomer->name }}
                    @else
                        Sin Estado
                    @endif
                </td> <!-- Modificar Tiene que ser de la tabla ESTADOS -->
                <td>
                    @if ($customer->latestAssignamet)
                        {{ $customer->latestAssignamet->agent->name }}
                    @else
                        Sin Asignacion
                    @endif
                </td>
                <td>
                    @if ($customer->latestComunication)
                        {{ $customer->latestComunication->comment }}
                    @else
                        Sin Comentario
                    @endif
                </td>
                <td>{{ $customer->last_communication_date }}</td>
                <td>
                    @if ($customer->latestDeposit)
                        {{ date("d/m/Y", strtotime($customer->latestDeposit->date)) }}
                    @else
                        Sin Depósito
                    @endif
                </td>
                <td>
                    @if ($customer->latestDeposit)
                        {{ $customer->latestDeposit->transactionType->name }}
                    @else
                        Sin Depósito
                    @endif
                </td>
                <td>
                    @if ($customer->latestDeposit)
                        {{ $customer->latestDeposit->number }}
                    @else
                        Sin Depósito
                    @endif
                </td>
                <td>
                    @if ($customer->latestDeposit)
                        $ {{ $customer->latestDeposit->amount }}
                    @else
                        Sin Depósito
                    @endif
                </td>
                <td>
                    @if ($customer->folder)
                        {{ $customer->folder->name }}
                    @else
                        Sin Folder
                    @endif
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <button class="btn btn-primary" type="button" onclick="changeFolder({customerId: '{{ $customer->id }}', folderId: '{{ $customer->folder_id }}', modal: '#modalChangeFolder'})"><i class="fa fa-refresh"></i> </button>
                        <button class="btn btn-info" type="button" onclick="sendMail({customerId: '{{ $customer->id }}', email: '{{ $customer->email }}', modal: '#modalSendMail'})"><i class="fa fa-paper-plane"></i> </button>
                        @can('Llamadas VOISO')
                        <button class="btn btn-success" type="button" onclick="initiateCall({phone: '{{ $customer->phone }}', modal: '#modalCrearComentario', input: '#idComunication'})"><i class="fa fa-phone"></i> </button>
                        @endcan
                        @can('Asignar Agente')
                        <button class="btn btn-default " type="button" onclick="asignarAgente('{{ $customer->id }}', '{{ $customer->name }} {{ $customer->lastname }}', '#modalAsignarAgente', '#aId', '#nameClient')"><i class="fa fa-user"></i></button>
                        @endcan
                        @can('Editar Cliente')
                        <button class="btn btn-warning " type="button" onclick="editarCliente(
                            '{{ $customer->id }}',
                            '{{ $customer->code }}',
                            '{{ $customer->name }}',
                            '{{ $customer->lastname }}',
                            '{{ $customer->phone }}',
                            '{{ $customer->optional_phone }}',
                            '{{ $customer->country }}',
                            '{{ $customer->email }}',
                            '{{ $customer->provider_id }}',
                            '{{ $customer->status_id }}',
                            '#modalEditarCliente',
                            '#eId',
                            '#eCode',
                            '#eName',
                            '#eLastname',
                            '#ePhone',
                            '#eOptionalPhone',
                            '#eCountry',
                            '#eEmail',
                            '#eProvide_id',
                            '#eStatus_id'
                            )"><i class="fa fa-pencil"></i></button>
                        @endcan
                        @can('Eliminar Cliente')
                            <button class="btn btn-danger " type="button" onclick="eliminarCliente('{{ $customer->id }}', '{{ $customer->name }} {{ $customer->lastname }}', '#tabClient')"><i class="fa fa-trash"></i></button>
                        @endcan
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $customers->appends(['limit' => request('limit')])->links() }}



<script src="{{ asset('js/utils/viewCheck.js') }}"></script>
<script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('js/plugins/ionRangeSlider/ion.rangeSlider.min.js') }}"></script>

<script>
    $(document).ready(function(){

        $('#data_5 .input-daterange').datepicker({
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
        });

    });

</script>
