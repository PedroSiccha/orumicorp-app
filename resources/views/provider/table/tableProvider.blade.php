<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Teléfono</th>
            <th>Correo</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($suppliers as $supplier)
            <tr>
                <td>{{ $supplier->id }}</td>
                <td>{{ $supplier->name }}</td>
                <td>{{ $supplier->phone }}</td>
                <td>{{ $supplier->email }}</td>
                <td>
                    <div class="d-flex align-items-center">
                        @can('Editar Proveedor')
                        <button class="btn btn-warning " type="button" onclick="editarProvider({id: '{{ $supplier->id }}', name: '{{ $supplier->name }}', phone: '{{ $supplier->phone }}', email: '{{ $supplier->email }}', modal: '#modalEditarProvider', inputId: '#idEditarProvider', inputName: '#nameProviderEdit', inputPhone: '#phoneProviderEdit', inputEmail: '#emailProviderEdit'})"><i class="fa fa-pencil"></i></button>
                        @endcan
                        @can('Eliminar Proveedor')
                        <button class="btn btn-danger " type="button" onclick="deleteProvider({id: '{{ $supplier->id }}', name: '{{ $supplier->name }}', tableName: '#tabProvider'})"><i class="fa fa-trash"></i></button>
                        @endcan
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
