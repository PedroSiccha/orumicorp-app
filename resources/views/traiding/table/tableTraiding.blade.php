<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Código</th>
            <th>Descripción</th>
            <th>Estado</th>
            <th>Acción</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($traidings as $traiding)
            <tr>
                <td>{{ $traiding->id }}</td>
                <td>{{ $traiding->code }}</td>
                <td>{{ $traiding->description }}</td>
                <td>{{ $traiding->status }}</td>
                <td>
                    <div class="d-flex align-items-center">
                        @can('Editar Traiding')
                        <button class="btn btn-warning " type="button" onclick="editarTraiding({id: '{{ $traiding->id }}', code: '{{ $traiding->code }}', description: '{{ $traiding->description }}', status: '{{ $traiding->status }}', modal: '#modalEditarTraiding', inputId: '#idEditarTraiding', inputCode: '#codeTraidingEdit', inputDescription: '#descriptionTraidingEdit'})"><i class="fa fa-pencil"></i></button>
                        @endcan
                        @can('Eliminar Traiding')
                        <button class="btn btn-danger " type="button" onclick="eliminarTraiding({id: '{{ $traiding->id }}', code: '{{ $traiding->code }}', tableName: '#tabTraiding'})"><i class="fa fa-trash"></i></button>
                        @endcan
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
