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
      @foreach ($bonusAgent as $ba)

          <tr>
              <td>{{ date("d/m/Y", strtotime($ba->date_admission)) }}</td>
              <td>{{ $ba->customer->id }}</td>
              <td>{{ $ba->customer->name }} {{ $ba->customer->lastname }}</td>
              <td> $ {{ number_format($ba->amount / $ba->exchangeRate->amount, 2) }} </td>
              <td>{{ $ba->percent->description }}</td>
              <td> $ {{ number_format($ba->commission->amount / $ba->exchangeRate->amount, 2) }}</td>
              <td>{{ $ba->exchangeRate->name }}</td>
              <td>{{ $ba->commission->name }}</td>
              <td>{{ $ba->agent->name }} {{ $ba->agent->lastname }}</td>
              <td>{{ $ba->agent->area->name }}</td>
              <td>{{ $ba->obsercation }}</td>
          </tr>

      @endforeach

    </tbody>
</table>
