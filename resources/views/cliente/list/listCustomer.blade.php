<table class="table table-striped">
    <thead>
        <tr>
            <th>Ultima llamada</th>
            <th>ID de Cliente</th>
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
            <tr @if($customer->status == 0) class="table-danger" @endif>
                <td>{{ $customer->last_communication_date }}</td>
                <td>{{ $customer->customer_id }}</td>
                <td>{{  date("d/m/Y", strtotime($customer->date_admission)) }}</td>
                <td>{{ $customer->last_communication_date }}</td>
                <td>{{ $customer->last_assignment_date }}</td>
                <td>{{ $customer->assignment_description }}</td>
                <td>{{ $customer->provider_name }}</td>
                <td>{{ $customer->campaign_name }}</td>
                <td>
                    <a href="{{ route('profileClient', ['id' => $customer->customer_id]) }}">
                        {{ $customer->customer_name }}
                    </a>
                </td>
                <td>{{ $customer->user_email }}</td>
                <td>{{ $customer->phone }}</td>
                <td>{{ $customer->phone }}</td> <!-- Modificar Número Opcional -->
                <td>{{ $customer->city }}</td>
                <td>{{ $customer->country }}</td>
                <td>{{ $customer->customer_status }}</td> <!-- Modificar Tiene que ser de la tabla ESTADOS -->
                <td>{{ $customer->agent_name }}</td>
                <td>{{ $customer->communication_comment }}</td>
                <td>{{ $customer->last_communication_date }}</td>
                <td>{{ $customer->last_communication_date }}</td>
                <td>{{ $customer->deposit_type }}</td>
                <td>{{ $customer->deposit_number }}</td>
                <td>{{ $customer->total_deposit }}</td>
                <td>
                    <div class="d-flex align-items-center">
                        <button class="btn btn-success" type="button" onclick="initiateCall({phone: '{{ $customer->phone }}', modal: '#modalCrearComentario', input: '#idComunication'})"><i class="fa fa-phone"></i> </button>
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
