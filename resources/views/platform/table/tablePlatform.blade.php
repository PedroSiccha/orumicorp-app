<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Estado</th>
            <th>Acción</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($platforms as $platform)
            <tr>
                <td>{{ $platform->id }}</td>
                <td>{{ $platform->name }}</td>
                <td>{{ $platform->description }}</td>
                <td>{{ $platform->status }}</td>
                <td>
                    <div class="d-flex align-items-center">
                        @can('Editar Plataforma')
                        <button class="btn btn-warning " type="button" onclick="editarPlatform({id: '{{ $platform->id }}', name: '{{ $platform->name }}', description: '{{ $platform->description }}', status: '{{ $platform->status }}', modal: '#modalEditarPlatform', inputId: '#idEditarPlatform', inputName: '#namePlatformEdit', inputDescription: '#descriptionPlatformEdit'})"><i class="fa fa-pencil"></i></button>
                        @endcan
                        @can('Eliminar Plataforma')
                        <button class="btn btn-danger " type="button" onclick="eliminarPlatform({id: '{{ $platform->id }}', name: '{{ $platform->name }}', tableName: '#tabPlatform'})"><i class="fa fa-trash"></i></button>
                        @endcan
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
