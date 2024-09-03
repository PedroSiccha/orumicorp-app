<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Color</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($customersStatus as $customerStatus)
        <tr>
            <td>{{ $customerStatus->id }}</td>
            <td>{{ $customerStatus->name }}</td>
            <td>{{ $customerStatus->color }}</td>
            <td>
                <div class="d-flex align-items-center">
                    @can('Editar Estados de Cliente')
                    <button class="btn btn-warning " type="button" onclick="editCustomenStatus({id: '{{ $customerStatus->id }}', name: '{{ $customerStatus->name }}', modal: '#modalEditarEstado', inputId: '#idEditarEstado', inputName: '#editaNameStatus'})"><i class="fa fa-pencil"></i></button>
                    @endcan
                    @can('Eliminar Estados de Cliente')
                    <button class="btn btn-danger " type="button" onclick="deleteCustomerStatus({id: '{{ $customerStatus->id }}', name: '{{ $customerStatus->name }}', tableName: '#tabStatus'})"><i class="fa fa-trash"></i></button>
                    @endcan
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
