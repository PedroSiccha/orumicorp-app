<table class="table table-hover no-margins">
    <thead>
    <tr>
        <th>Código</th>
        <th>Mes</th>
        <th>Monto</th>
    </tr>
    </thead>
    <tbody>
        @foreach ($targets as $target)
            <tr>
                <td>{{ $target->id }}</td>
                <td>{{ $target->mes }}</td>
                <td>$ {{ number_format($target->amount, 2) }} </td>
            </tr>
        @endforeach
    </tbody>
</table>
