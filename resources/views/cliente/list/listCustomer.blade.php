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
            <th>Ultima llamada</th>
            <th>COD. de Cliente</th>
            <th>Fecha de Ingreso</th>
            <th>Fecha de Última Llamada</th>
            <th>Fecha de Última Asignación</th>
            <th>Asignado Por</th>
            <th>Proveedor</th>
            <th>Campaña</th>
            <th>Nombre del Cliente</th>
            <th>Correo</th>
            <th>Teléfono</th>
            <th>Teléfono Opcional</th>
            <th>Ciudad</th>
            <th>Pais</th>
            <th>Estado</th>
            <th>Agente</th>
            <th>Comentario</th>
            <th>Última Visita</th>
            <th>FTD Date</th>
            <th>Método</th>
            <th>N° de Depósito</th>
            <th>Total Depósitos</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($customers as $customer)
            <tr class="{{ $customer->status_color }}">
                <td>
                    <div class="i-checks"><label> <input type="checkbox" class="i-checks flat chekboxses" name="idGroupClientes[]" value="{{ $customer->id }}" id="idGroupClientes"> <i></i> </label></div>
                    {{-- <input type="checkbox" class="i-checks flat chekboxses" name="idGroupClientes[]" value="{{ $asignCustomer->id }}" id="idGroupClientes"> --}}
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
                    @if ($customer->latestAssignamet)
                        {{ date("d/m/Y", strtotime($customer->latestAssignamet->date)) }}
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
                    @if ($customer->latestCampaign)
                        {{ $customer->latestCampaign }}
                    @else
                        Sin Campaña
                    @endif
                </td>
                <td>
                    <a href="{{ route('profileClient', ['id' => $customer->id]) }}">
                        {{ $customer->name }} {{ $customer->lastname }}
                    </a>
                </td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->phone }}</td>
                <td>{{ $customer->optiomal_phone }}</td> <!-- Modificar Número Opcional -->
                <td>{{ $customer->city }}</td>
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
                    <div class="d-flex align-items-center">
                        <button class="btn btn-success" type="button" onclick="initiateCall({phone: '{{ $customer->phone }}', modal: '#modalCrearComentario', input: '#idComunication'})"><i class="fa fa-phone"></i> </button>
                        @can('Asignar Agente')
                            <button class="btn btn-default " type="button" onclick="asignarAgente('{{ $customer->id }}', '{{ $customer->name }} {{ $customer->lastname }}', '#modalAsignarAgente', '#aId', '#nameClient')"><i class="fa fa-user"></i></button>
                        @endcan
                        {{-- @can('Estado Cliente')
                            @if ($customer->status == 0)
                                <button class="btn btn-info " type="button" onclick="cambiarEstado('{{ $customer->id }}', '{{ $customer->name }} {{ $customer->lastname }}', '#tabClient', '1')"><i class="fa fa-check"></i></button>
                            @else
                                <button class="btn btn-danger " type="button" onclick="cambiarEstado('{{ $customer->id }}', '{{ $customer->name }} {{ $customer->lastname }}', '#tabClient', '0')"><i class="fa fa-minus"></i></button>
                            @endif
                        @endcan --}}
                        @can('Editar Cliente')
                        <button class="btn btn-warning " type="button" onclick="editarCliente(
                            '{{ $customer->customer_id }}',
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
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<label for="limit">Mostrar:</label>
<select name="limit" id="limit">
    <option value="5" {{ request('limit') == 5 ? 'selected' : '' }}>5</option>
    <option value="10" {{ request('limit') == 10 ? 'selected' : '' }}>10</option>
    <option value="20" {{ request('limit') == 20 ? 'selected' : '' }}>20</option>
    <option value="50" {{ request('limit') == 50 ? 'selected' : '' }}>50</option>
    <option value="100" {{ request('limit') == 100 ? 'selected' : '' }}>100</option>
    <option value="500" {{ request('limit') == 500 ? 'selected' : '' }}>500</option>
    <option value="1000" {{ request('limit') == 1000 ? 'selected' : '' }}>1000</option>
</select>
{{ $customers->appends(['limit' => request('limit')])->links() }}

<script src="{{ asset('js/utils/viewCheck.js') }}"></script>
{{-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAllCheckbox = $('#selectAllCheckboxes');
        const checkboxes = $('.chekboxses');

        selectAllCheckbox.on('ifChanged', function () {
            const isChecked = $(this).is(':checked');
            checkboxes.iCheck(isChecked ? 'check' : 'uncheck');
        });

        checkboxes.on('ifChanged', function () {
            if (!$(this).is(':checked')) {
                selectAllCheckbox.iCheck('uncheck');
            } else {
                const allChecked = checkboxes.filter(':checked').length === checkboxes.length;
                selectAllCheckbox.iCheck(allChecked ? 'check' : 'uncheck');
            }
        });
    });
</script> --}}
