<table class="table table-striped">
    <thead>
        <tr>
            <th class="column-0">
                Seleccionar Todo
                <div class="i-checks">
                    <label>
                        <input type="checkbox" id="selectAllCheckboxes" class="i-checks flat" name="selectAll">
                        <i></i>
                    </label>
                </div>
            </th>
            <th class="column-1">
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
            @can('Perfil Cliente - Ver Codigo')
            <th class="column-2">
                <div class="dropdown">
                    COD. de Cliente
                </div>
            </th>
            @endcan
            <th class="column-3">
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
            <th class="column-4">
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
            <th class="column-5">
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
            <th class="column-6">
                <div class="dropdown">
                    Asignado Por
                </div>
            </th>
            <th class="column-7">
                <div class="dropdown">
                    Proveedor
                </div>
            </th>
            @can('Perfil Cliente - Ver Nombre')
            <th class="column-8">
                <div class="dropdown">
                    Nombre del Cliente
                </div>
            </th>
            @endcan
            @can('Perfil Cliente - Ver Correo')
            <th class="column-9">
                <div class="dropdown">
                    Correo
                </div>
            </th>
            @endcan
            @can('Perfil Cliente - Ver Telefono')
            <th class="column-10">
                <div class="dropdown">
                    Teléfono
                </div>
            </th>
            @endcan
            @can('Perfil Cliente - Ver Telefono Opcional')
            <th class="column-11">
                <div class="dropdown">
                    Teléfono Opcional
                </div>
            </th>
            @endcan
            {{-- <th>
                <div class="dropdown">
                    Ciudad
                </div>
            </th> --}}
            @can('Perfil Cliente - Ver Pais')
            <th class="column-12">
                <div class="dropdown">
                    País
                </div>
            </th>
            @endcan
            <th class="column-13">
                <div class="dropdown">
                    Estado
                </div>
            </th>
            <th class="column-14">
                <div class="dropdown">
                    Agente
                </div>
            </th>
            <th class="column-15">Comentario</th>
            <th class="column-16">
                <div class="dropdown">
                    Última Visita
                </div>
            </th>
            <th class="column-17">
                <div class="dropdown">
                    FTD Date
                </div>
            </th>
            <th class="column-18">
                <div class="dropdown">
                    Método
                </div>
            </th>
            <th class="column-19">
                <div class="dropdown">
                    N° de Depósito
                </div>
            </th>
            <th class="column-20">
                <div class="dropdown">
                    Total Depósito
                </div>
            </th>
            <th class="column-21">
                <div class="dropdown">
                    Folder
                </div>
            </th>
            <th class="column-22">Acción</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($customers as $customer)
            <tr class="{{ $customer->status_color }}">
                <td>
                    <div class="i-checks"><label> <input type="checkbox" class="i-checks flat chekboxses" name="idGroupClientes[]" value="{{ $customer->id }}" id="idGroupClientes"> <i></i> </label></div>
                </td>
                <td class="column-1">
                    @if ($customer->latestComunication)
                        {{ date("d/m/Y", strtotime($customer->latestComunication->date)) }}
                    @else
                        Sin Comunicación
                    @endif
                </td>
                @can('Perfil Cliente - Ver Codigo')
                <td class="column-2">{{ $customer->code }}</td>
                @endcan
                <td class="column-3">{{  date("d/m/Y", strtotime($customer->date_admission)) }}</td>
                <td class="column-4">
                    @if ($customer->latestComunication)
                        {{ date("d/m/Y", strtotime($customer->latestComunication->date)) }}
                    @else
                        Sin Comunicación
                    @endif
                </td>
                <td class="column-5">
                    @if ($customer->latestAssignamet)
                        {{ date("d/m/Y", strtotime($customer->latestAssignamet->date)) }}
                    @else
                        Sin Asignacion
                    @endif
                </td>
                <td class="column-6">
                    @if ($customer->latestAssignametBy)
                        {{ $customer->latestAssignametBy->assignedBy->name }}
                    @else
                        Sin Asignacion
                    @endif
                </td>
                <td class="column-7">
                    @if ($customer->provider)
                        {{ $customer->provider->name }}
                    @else
                        Sin Proveedor
                    @endif
                </td>
                @can('Perfil Cliente - Ver Nombre')
                <td class="column-8">
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
                @endcan
                @can('Perfil Cliente - Ver Correo')
                <td class="column-9">{{ $customer->email }}</td>
                @endcan
                @can('Perfil Cliente - Ver Telefono')
                <td class="column-10">{{ $customer->phone }}</td>
                @endcan
                @can('Perfil Cliente - Ver Telefono Opcional')
                <td class="column-11">{{ $customer->optiomal_phone }}</td> <!-- Modificar Número Opcional -->
                @endcan
                {{-- <td>{{ $customer->city }}</td> --}}
                @can('Perfil Cliente - Ver Pais')
                <td class="column-12">{{ $customer->country }}</td>
                @endcan
                <td class="column-13">
                    @if ($customer->statusCustomer)
                        {{ $customer->statusCustomer->name }}
                    @else
                        Sin Estado
                    @endif
                </td> <!-- Modificar Tiene que ser de la tabla ESTADOS -->
                <td class="column-14">
                    @if ($customer->latestAssignamet)
                        {{ $customer->latestAssignamet->agent->name }}
                    @else
                        Sin Asignacion
                    @endif
                </td>
                <td class="column-15">
                    @if ($customer->latestComunication)
                        {{ $customer->latestComunication->comment }}
                    @else
                        Sin Comentario
                    @endif
                </td>
                <td class="column-16">{{ $customer->last_communication_date }}</td>
                <td class="column-17">
                    @if ($customer->latestDeposit)
                        {{ date("d/m/Y", strtotime($customer->latestDeposit->date)) }}
                    @else
                        Sin Depósito
                    @endif
                </td>
                <td class="column-18">
                    @if ($customer->latestDeposit)
                        {{ $customer->latestDeposit->transactionType->name }}
                    @else
                        Sin Depósito
                    @endif
                </td>
                <td class="column-19">
                    @if ($customer->latestDeposit)
                        {{ $customer->latestDeposit->number }}
                    @else
                        Sin Depósito
                    @endif
                </td>
                <td class="column-20">
                    @if ($customer->latestDeposit)
                        $ {{ $customer->latestDeposit->amount }}
                    @else
                        Sin Depósito
                    @endif
                </td>
                <td class="column-21">
                    @if ($customer->folder)
                        {{ $customer->folder->name }}
                    @else
                        Sin Folder
                    @endif
                </td>
                <td class="column-22">
                    <div class="d-flex align-items-center">
                        @can('Asignar Folder')
                        <button class="btn btn-primary" type="button" onclick="changeFolder({customerId: '{{ $customer->id }}', folderId: '{{ $customer->folder_id }}', modal: '#modalChangeFolder'})"><i class="fa fa-refresh"></i> </button>
                        @endcan
                        <button class="btn btn-info" type="button" onclick="sendMail({customerId: '{{ $customer->id }}', email: '{{ $customer->email }}', modal: '#modalSendMail'})"><i class="fa fa-paper-plane"></i> </button>
                        @can('Llamadas VOISO') 
                        <button class="btn btn-success" type="button" onclick="initiateCall({phone: '{{ $customer->phone }}', customerId: '{{ $customer->id }}', modal: '#voisoModal'})">
                            <i class="fa fa-phone"></i>
                        </button>
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
