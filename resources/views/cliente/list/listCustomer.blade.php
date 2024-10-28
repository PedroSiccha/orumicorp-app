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
                        <a class="dropdown-item" onclick="filterByDate({ order: 'comunications.date', type: 'DESC', tableName: '#tabClient' })">Hoy</a>
                        <a class="dropdown-item" onclick="filterByDate({ order: 'comunications.date', type: 'DESC', tableName: '#tabClient' })">
                            <input type="date" placeholder="Seleccione una fecha" class="form-control" id='uLlDecha'>
                        </a>
                        <a class="dropdown-item" onclick="filterByDate({ order: 'comunications.date', type: 'DESC', tableName: '#tabClient' })">
                            <div class="form-group" id="data_5">
                                <div class="input-daterange input-group" id="datepicker">
                                    <input type="text" class="form-control-sm form-control" name="start" value="01/01/2024"/>
                                    <span class="input-group-addon">-</span>
                                    <input type="text" class="form-control-sm form-control" name="end" value="01/02/2024" />
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </th>
            <th>
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        COD. de Cliente
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" onclick="filterOrder({ order: 'code', type: 'DESC', tableName: '#tabClient' })">Ascedente</a>
                        <a class="dropdown-item" onclick="filterOrder({ order: 'code', type: 'ASC', tableName: '#tabClient' })">Descendente</a>
                        <!--
                        <a class="dropdown-item" onclick="filterOrder({ order: 'code', type: 'ASC', tableName: '#tabClient' })">
                            <input type="text" class="form-control-sm form-control" name="end" placeholder="Buscar..."/>
                        </a>
                        -->
                    </div>
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
                        <a href="#" class="dropdown-item">Hoy</a>
                        <a class="dropdown-item" onclick="filterByDate({ order: 'comunications.date', type: 'DESC', tableName: '#tabClient' })">
                            <input type="date" placeholder="Seleccione una fecha" class="form-control" id='uLlDecha'>
                        </a>
                        <a class="dropdown-item" onclick="filterByDate({ order: 'comunications.date', type: 'DESC', tableName: '#tabClient' })">
                            <div class="form-group" id="data_5">
                                <div class="input-daterange input-group" id="datepicker">
                                    <input type="text" class="form-control-sm form-control" name="start" value="01/01/2024"/>
                                    <span class="input-group-addon">-</span>
                                    <input type="text" class="form-control-sm form-control" name="end" value="01/02/2024" />
                                </div>
                            </div>
                        </a>
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
                        <a href="#" class="dropdown-item">Hoy</a>
                        <a class="dropdown-item" onclick="filterByDate({ order: 'comunications.date', type: 'DESC', tableName: '#tabClient' })">
                            <input type="date" placeholder="Seleccione una fecha" class="form-control" id='uLlDecha'>
                        </a>
                        <a class="dropdown-item" onclick="filterByDate({ order: 'comunications.date', type: 'DESC', tableName: '#tabClient' })">
                            <div class="form-group" id="data_5">
                                <div class="input-daterange input-group" id="datepicker">
                                    <input type="text" class="form-control-sm form-control" name="start" value="01/01/2024"/>
                                    <span class="input-group-addon">-</span>
                                    <input type="text" class="form-control-sm form-control" name="end" value="01/02/2024" />
                                </div>
                            </div>
                        </a>
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
                        <a href="#" class="dropdown-item">Hoy</a>
                        <a class="dropdown-item" onclick="filterByDate({ order: 'comunications.date', type: 'DESC', tableName: '#tabClient' })">
                            <input type="date" placeholder="Seleccione una fecha" class="form-control" id='uLlDecha'>
                        </a>
                        <a class="dropdown-item" onclick="filterByDate({ order: 'comunications.date', type: 'DESC', tableName: '#tabClient' })">
                            <div class="form-group" id="data_5">
                                <div class="input-daterange input-group" id="datepicker">
                                    <input type="text" class="form-control-sm form-control" name="start" value="01/01/2024"/>
                                    <span class="input-group-addon">-</span>
                                    <input type="text" class="form-control-sm form-control" name="end" value="01/02/2024" />
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </th>
            <th>
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        Asignado Por
                    </a>
                    <div class="dropdown-menu">
                        @foreach ($agents as $agent)
                            <a class="dropdown-item" href="#">{{ $agent->name }} {{ $agent->lastname }}</a>
                        @endforeach
                    </div>
                </div>
            </th>
            <th>
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        Proveedor
                    </a>
                    <div class="dropdown-menu">
                        @foreach ($providers as $provider)
                            <a class="dropdown-item" onclick="filterByAttr({ type: 'id_provider', id: '{{ $provider->id }}'})">{{ $provider->name }}</a>
                        @endforeach
                    </div>
                </div>
            </th>
            <th>
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        Campaña
                    </a>
                    <div class="dropdown-menu">
                        @foreach ($campaings as $campaing)
                            <a class="dropdown-item">{{ $campaing->name }}</a>
                        @endforeach
                    </div>
                </div>
            </th>
            <th>
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        Nombre del Cliente
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" onclick="filterOrder({ order: 'comunications.date', type: 'DESC', tableName: '#tabClient' })">Ascedente</a>
                        <a class="dropdown-item" onclick="filterOrder({ order: 'comunications.date', type: 'DESC', tableName: '#tabClient' })">Descendente</a>
                        <!--
                        <a class="dropdown-item" onclick="filterOrder({ order: 'code', type: 'ASC', tableName: '#tabClient' })">
                            <input type="text" class="form-control-sm form-control" name="end" placeholder="Buscar..."/>
                        </a>
                        -->
                    </div>
                </div>
            </th>
            <th>
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        Correo
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" onclick="filterOrder({ order: 'comunications.date', type: 'DESC', tableName: '#tabClient' })">Ascedente</a>
                        <a class="dropdown-item" onclick="filterOrder({ order: 'comunications.date', type: 'DESC', tableName: '#tabClient' })">Descendente</a>
                        <!--
                        <a class="dropdown-item" onclick="filterOrder({ order: 'code', type: 'ASC', tableName: '#tabClient' })">
                            <input type="text" class="form-control-sm form-control" name="end" placeholder="Buscar..."/>
                        </a>
                        -->
                    </div>
                </div>
            </th>
            <th>
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        Teléfono
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" onclick="filterOrder({ order: 'comunications.date', type: 'DESC', tableName: '#tabClient' })">Ascedente</a>
                        <a class="dropdown-item" onclick="filterOrder({ order: 'comunications.date', type: 'DESC', tableName: '#tabClient' })">Descendente</a>
                        <!--
                        <a class="dropdown-item" onclick="filterOrder({ order: 'code', type: 'ASC', tableName: '#tabClient' })">
                            <input type="text" class="form-control-sm form-control" name="end" placeholder="Buscar..."/>
                        </a>
                        -->
                    </div>
                </div>
            </th>
            <th>
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        Teléfono Opcional
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" onclick="filterOrder({ order: 'comunications.date', type: 'DESC', tableName: '#tabClient' })">Ascedente</a>
                        <a class="dropdown-item" onclick="filterOrder({ order: 'comunications.date', type: 'DESC', tableName: '#tabClient' })">Descendente</a>
                        <!--
                        <a class="dropdown-item" onclick="filterOrder({ order: 'code', type: 'ASC', tableName: '#tabClient' })">
                            <input type="text" class="form-control-sm form-control" name="end" placeholder="Buscar..."/>
                        </a>
                        -->
                    </div>
                </div>
            </th>
            <th>
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        Ciudad
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" onclick="filterOrder({ order: 'comunications.date', type: 'DESC', tableName: '#tabClient' })">Ascedente</a>
                        <a class="dropdown-item" onclick="filterOrder({ order: 'comunications.date', type: 'DESC', tableName: '#tabClient' })">Descendente</a>
                    </div>
                </div>
            </th>
            <th>
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        País
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" onclick="filterOrder({ order: 'comunications.date', type: 'DESC', tableName: '#tabClient' })">Ascedente</a>
                        <a class="dropdown-item" onclick="filterOrder({ order: 'comunications.date', type: 'DESC', tableName: '#tabClient' })">Descendente</a>
                    </div>
                </div>
            </th>
            <th>
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        Estado
                    </a>
                    <div class="dropdown-menu">
                        @foreach ($statusCustomers as $statusCustomer)
                            <a class="dropdown-item" onclick="filterByAttr({ type: 'id_status', id: '{{ $statusCustomer->id }}'})">{{ $statusCustomer->name }}</a>
                        @endforeach
                    </div>
                </div>
            </th>
            <th>
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        Agente
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Agente 01</a>
                    </div>
                </div>
            </th>
            <th>Comentario</th>
            <th>
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        Última Visita
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" onclick="filterOrder({ order: 'comunications.date', type: 'DESC', tableName: '#tabClient' })">Más Recientes</a>
                        <a class="dropdown-item" onclick="filterOrder({ order: 'comunications.date', type: 'DESC', tableName: '#tabClient' })">Más Antigüos</a>
                        <a href="#" class="dropdown-item">Hoy</a>
                    </div>
                </div>
            </th>
            <th>
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        FTD Date
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" onclick="filterOrder({ order: 'comunications.date', type: 'DESC', tableName: '#tabClient' })">Más Recientes</a>
                        <a class="dropdown-item" onclick="filterOrder({ order: 'comunications.date', type: 'DESC', tableName: '#tabClient' })">Más Antigüos</a>
                        <a href="#" class="dropdown-item">Hoy</a>
                    </div>
                </div>
            </th>
            <th>
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        Método
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Método 01</a>
                    </div>
                </div>
            </th>
            <th>
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        N° de Depósito
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" onclick="filterOrder({ order: 'comunications.date', type: 'DESC', tableName: '#tabClient' })">Ascedente</a>
                        <a class="dropdown-item" onclick="filterOrder({ order: 'comunications.date', type: 'DESC', tableName: '#tabClient' })">Descendente</a>
                    </div>
                </div>
            </th>
            <th>
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        Total Depósito
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" onclick="filterOrder({ order: 'comunications.date', type: 'DESC', tableName: '#tabClient' })">Mayor</a>
                        <a class="dropdown-item" onclick="filterOrder({ order: 'comunications.date', type: 'DESC', tableName: '#tabClient' })">Menor</a>
                    </div>
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
                        <button class="btn btn-primary" type="button" onclick="changeFolder({customerId: '{{ $customer->id }}', folderId: '{{ $customer->folder_id }}', modal: '#modalChangeFolder'})"><i class="fa fa-refresh"></i> </button>
                        <button class="btn btn-info" type="button" onclick="sendMail({customerId: '{{ $customer->id }}', email: '{{ $customer->email }}', modal: '#modalSendMail'})"><i class="fa fa-paper-plane"></i> </button>
                        @can('Llamadas VOISO')
                        <button class="btn btn-success" type="button" onclick="initiateCall({phone: '{{ $customer->phone }}', modal: '#modalCrearComentario', input: '#idComunication'})"><i class="fa fa-phone"></i> </button>
                        @endcan
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
                            '{{ $customer->id }}',
                            '{{ $customer->code }}',
                            '{{ $customer->name }}',
                            '{{ $customer->lastname }}',
                            '{{ $customer->phone }}',
                            '{{ $customer->optional_phone }}',
                            '{{ $customer->city }}',
                            '{{ $customer->country }}',
                            '{{ $customer->email }}',
                            '{{ $customer->provider_id }}',
                            '{{ $customer->platform_id }}',
                            '{{ $customer->traiding_id }}',
                            '{{ $customer->status_id }}',
                            '#modalEditarCliente',
                            '#eId',
                            '#eCode',
                            '#eName',
                            '#eLastname',
                            '#ePhone',
                            '#eOptionalPhone',
                            '#eCity',
                            '#eCountry',
                            '#eEmail',
                            '#eProvide_id',
                            '#ePlatform_id',
                            '#eTraiding_id',
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
<label for="limit">Mostrar:</label>
<div class="col-sm-1 m-b-xs">
    <select class="form-control-sm form-control input-s-sm inline" name="limit" id="limit">
        <option value="5" {{ request('limit') == 5 ? 'selected' : '' }}>5</option>
        <option value="10" {{ request('limit') == 10 ? 'selected' : '' }}>10</option>
        <option value="20" {{ request('limit') == 20 ? 'selected' : '' }}>20</option>
        <option value="50" {{ request('limit') == 50 ? 'selected' : '' }}>50</option>
        <option value="100" {{ request('limit') == 100 ? 'selected' : '' }}>100</option>
        <option value="500" {{ request('limit') == 500 ? 'selected' : '' }}>500</option>
        <option value="1000" {{ request('limit') == 1000 ? 'selected' : '' }}>1000</option>
    </select>
</div>
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
