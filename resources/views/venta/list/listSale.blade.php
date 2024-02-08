<table class="table table-striped">
      <thead>
      <tr>
          <th>Fecha de Ingreso</th>
          <th>ID de Cliente</th>
          <th>Nombre del Cliente</th>
          <th>Monto</th>
          <th>Porcentaje</th>
          <th>Comisión</th>
          <th>Tipo de Cambio</th>
          <th>Comisión en Soles</th>
          <th>Agente</th>
          <th>Area</th>
          <th>Comentario</th>
      </tr>
      </thead>
      <tbody>
        @foreach ($sales as $sale)

            <tr>
                <td>{{ date("d/m/Y", strtotime($sale->date_admission)) }}</td>
                <td>{{ $sale->customer->id }}</td>
                <td>{{ $sale->customer->name }} {{ $sale->customer->lastname }}</td>
                <td> $ {{ number_format($sale->amount / $sale->exchangeRate->amount, 2) }} </td>
                <td>{{ $sale->percent->description }}</td>
                <td> $ {{ number_format($sale->commission->amount / $sale->exchangeRate->amount, 2) }}</td>
                <td>{{ $sale->exchangeRate->name }}</td>
                <td>{{ $sale->commission->name }}</td>
                <td>{{ $sale->agent->name }} {{ $sale->agent->lastname }}</td>
                <td>{{ $sale->agent->area->name }}</td>
                <td>{{ $sale->obsercation }}</td>
            </tr>
            
        @endforeach
      </tbody>
  </table>