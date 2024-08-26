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
        <th>Acción</th>
    </tr>
    </thead>
    <tbody>
      @foreach ($sales as $sale)
          <tr>
              <td>{{ date("d/m/Y", strtotime($sale->date_admission)) }}</td>
              <td>{{ $sale->customer->id }}</td>
              <td>{{ $sale->customer->name }} {{ $sale->customer->lastname }}</td>
              <td> $ {{ number_format($sale->amount, 2) }} </td>
              <td>{{ $sale->percent }}</td>
              <td> $ {{ number_format($sale->commission, 2) }}</td>
              <td>{{ $sale->exchange_rate }}</td>
              <td>{{ $sale->commission }}</td>
              <td>{{ $sale->agent->name }} {{ $sale->agent->lastname }}</td>
              <td>{{ $sale->agent->area->name }}</td>
              <td>{{ $sale->obsercation }}</td>
              <td>
                    {{-- @can('Editar Venta') --}}
                        <button class="btn btn-warning " type="button" onclick="editarSale('{{ $sale->id }}', '{{ $sale->customer->id }}', '{{ $sale->customer->name }} {{ $sale->customer->lastname }}', '{{ $sale->amount }}', '{{ $sale->percent }}', '{{ $sale->exchange_rate }}', '{{ $sale->comission }}', '{{ $sale->agent->id }}', '{{ $sale->agent->code }}', '{{ $sale->agent->name }} {{ $sale->agent->lastname }}', '{{ $sale->obsercation }}', '#modalEditarVenta', '#eId', '#eIdClient', '#eNameClient', '#eAmount', '#ePercent', '#eTypeChange', '#eComission', '#eIdAgent', '#eCodAgent', '#eNameAgent', '#eObservation')"><i class="fa fa-pencil"></i></button>
                    {{-- @endcan --}}
                </td>
          </tr>
      @endforeach
        <tr>
            <td></td>
            <td>TOTAL</td>
            <td>:</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>$ {{ number_format($totalAmount, 2) }}</td>
            <td></td>
        </tr>
    </tbody>
</table>
