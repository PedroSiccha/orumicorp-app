<table class="table table-striped">
    <thead>
    <tr>
        <th>Fecha de Ingreso</th>
        <th>Premio</th>
        <th>Descripción</th>
        <th>Valor</th>
        <th>Estado</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($premios as $premio)
        <tr>
            <td>{{ $premio->created_at }}</td>
            <td>{{ $premio->name }}</td>
            <td>{{ $premio->description }}</td>
            <td>{{ $premio->value }}</td>
            <td>{{ $premio->status }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
