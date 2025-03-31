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
            <th>Agente</th>
            <th>Área</th>
            <th>Comentario</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($sales as $sale)
            <tr>
                <td>{{ date('d/m/Y', strtotime($sale->date_admission)) }}</td>
                <td>{{ optional($sale->customer)->id }}</td>
                <td>{{ optional($sale->customer)->name }} {{ optional($sale->customer)->lastname }}</td>
                <td>$ {{ number_format($sale->amount, 2) }}</td>
                <td>{{ $sale->percent }}</td>
                <td>$ {{ number_format($sale->commission, 2) }}</td>
                <td>{{ $sale->exchange_rate }}</td>
                <td>{{ optional($sale->agent)->name }} {{ optional($sale->agent)->lastname }}</td>
                <td>{{ optional(optional($sale->agent)->area)->name }}</td>
                <td>{{ $sale->obsercation }}</td>
                <td>
                    @can('Editar Venta')
                        <button class="btn btn-warning" type="button"
                            onclick="editarSale(
                                '{{ $sale->id }}',
                                '{{ optional($sale->customer)->id }}',
                                '{{ optional($sale->customer)->name }} {{ optional($sale->customer)->lastname }}',
                                '{{ $sale->amount }}',
                                '{{ $sale->percent }}',
                                '{{ $sale->exchange_rate }}',
                                '{{ $sale->commission }}',
                                '{{ optional($sale->agent)->id }}',
                                '{{ optional($sale->agent)->code_voiso }}',
                                '{{ optional($sale->agent)->name }} {{ optional($sale->agent)->lastname }}',
                                '{{ $sale->obsercation }}',
                                '#modalEditarVenta',
                                '#eId',
                                '#eIdClient',
                                '#eNameClient',
                                '#eAmount',
                                '#ePercent',
                                '#eTypeChange',
                                '#eComission',
                                '#eIdAgent',
                                '#eCodAgent',
                                '#eNameAgent',
                                '#eObservation')">
                            <i class="fa fa-pencil"></i>
                        </button>
                    @endcan
                </td>
            </tr>
        @endforeach

        <tr>
            <td colspan="3"><strong>TOTAL</strong></td>
            <td>$ {{ number_format($totalAmount, 2) }}</td>
            <td colspan="7"></td>
        </tr>

        <tr>
            <td colspan="11" class="text-center">
                {{ $sales->links() }}
            </td>
        </tr>
    </tbody>
</table>
