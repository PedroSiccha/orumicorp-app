<table class="table table-striped">
    <thead>
    <tr>
        <th>N°</th>
        @can('Tabla Today Statistics - Ver Agente')
          <th>Agente</th>
        @endcan
        @can('Tabla Today Statistics - Ver Venta del Día')
          <th>Ventas del Día</th>
        @endcan
        @can('Tabla Today Statistics - Ver Venta del Mes')
          <th>Ventas del Mes</th>
        @endcan
        @can('Tabla Today Statistics - Ver Monto del Día')
          <th>Monto del Día</th>
        @endcan
        @can('Tabla Today Statistics - Ver Monto del Mes')
          <th>Monto del Mes</th>
        @endcan
        @can('Tabla Today Statistics - Ver Call Over Triger')
          <th>Call over triger</th>
        @endcan
        @can('Tabla Today Statistics - Ver Total Calls')
          <th>Total calls</th>
        @endcan
        @can('Tabla Today Statistics - Ver Retiros')
          <th>Retiros</th>
        @endcan
        @can('Tabla Today Statistics - Ver Chargeback')
          <th>Chargeback</th>
        @endcan

    </tr>
    </thead>
    <tbody>
      @foreach ($sales as $sale)

          <tr>
              <td>{{ $sale->id }}</td>
              @can('Tabla Today Statistics - Ver Agente')
                  <td>{{ $sale->name }} {{ $sale->lastname }}</td>
              @endcan
              @can('Tabla Today Statistics - Ver Venta del Día')
                  <td>{{ $sale->total_sales_day }}</td>
              @endcan
              @can('Tabla Today Statistics - Ver Venta del Mes')
                  <td>{{ $sale->total_sales_month }}</td>
              @endcan
              @can('Tabla Today Statistics - Ver Monto del Día')
                  <td>$ {{ number_format($sale->total_amount_day, 2) }}</td>
              @endcan
              @can('Tabla Today Statistics - Ver Monto del Mes')
                  <td>$ {{ number_format($sale->total_amount_month, 2) }}</td>
              @endcan
              @can('Tabla Today Statistics - Ver Call Over Triger')
                  <td>0 (00:00:00)</td>
              @endcan
              @can('Tabla Today Statistics - Ver Total Calls')
                  <td>0 (00:00:00)</td>
              @endcan
              @can('Tabla Today Statistics - Ver Retiros')
                  <td>$ {{ number_format(0, 2) }}</td>
              @endcan
              @can('Tabla Today Statistics - Ver Chargeback')
                  <td>$ {{ number_format(0, 2) }}</td>
              @endcan
          </tr>

      @endforeach
    </tbody>
</table>
