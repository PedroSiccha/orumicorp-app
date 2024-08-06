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
        @foreach ($transactionsType as $transactionType)
            <tr>
                <td>{{ $transactionType->id }}</td>
                <td>{{ $transactionType->name }}</td>
                <td>{{ $transactionType->description }}</td>
                <td>{{ $transactionType->status }}</td>
                <td>
                    <div class="d-flex align-items-center">
                        <button class="btn btn-warning " type="button" onclick="editarTransactionType({id: '{{ $transactionType->id }}', name: '{{ $transactionType->name }}', description: '{{ $transactionType->description }}', status: '{{ $transactionType->status }}', modal: '#modalEditarTransactionType', inputId: '#idEditarTransactionType', inputName: '#nameTransactionTypeEdit', inputDescription: '#descriptionTransactionTypeEdit', tableName: '#tabTransactionType'})"><i class="fa fa-pencil"></i></button>
                        <button class="btn btn-danger " type="button" onclick="eliminarTransactionType({id: '{{ $transactionType->id }}', name: '{{ $transactionType->name }}', tableName: '#tabTransactionType'})"><i class="fa fa-trash"></i></button>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
