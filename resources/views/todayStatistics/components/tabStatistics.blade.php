<table class="table table-striped">
    <thead>
    <tr>
        <th>N°</th>
        <th>Agente</th>
        <th>Monto del Día</th>
        <th>Monto del Mes</th>
        <th>Call over triger</th>
        <th>Total calls</th>
        <th>Retiros</th>
        <th>Chargeback</th>
    </tr>
    </thead>
    <tbody>
      @foreach ($sales as $sale)

        <tr>
            <td>{{ $sale->id }}</td>
            <td>{{ $sale->name }} {{ $sale->lastname }}</td>
            <td>$ {{ number_format($sale->total_amount_day, 2) }}</td>
            <td>$ {{ number_format($sale->total_amount_month, 2) }}</td>
            <td>8 (01:02:24)</td>
            <td>107 (01:33:12)</td>
            <td>$ {{ number_format($sale->total_amount_action_4, 2) }}</td>
            <td>$ {{ number_format($sale->total_amount_month, 2) }}</td>
        </tr>

      @endforeach
    </tbody>
</table>
