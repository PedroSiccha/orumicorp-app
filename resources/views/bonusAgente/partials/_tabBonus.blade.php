<table class="table table-striped">
    <thead>
        <tr>
            <th>Fecha de Ingreso</th>
            <th>Monto en Soles</th>
            <th>Comision</th>
            <th>Comisión en Soles</th>
            <th>Agente</th>
            <th>Área</th>
            <th>Comentario</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($bonusAgent as $ba)
            <tr @if(number_format($ba->amount, 2) <= 0) class="table-danger" @endif>
                <td>{{ date("d/m/Y", strtotime($ba->date_admission)) }}</td>
                <td>S/. {{ $ba->observation === 'Giro de Ruleta' ? '0.00' : number_format($ba->amount, 2) }}</td>
                <td>$ {{ number_format($ba->commission / 3.5, 2) }}</td>
                <td>S/. {{ number_format($ba->commission, 2) }}</td>
                <td>
                    @can('Ver Perfil Agente')
                        <a href="{{ route('perfilUsuario', ['id' => $ba->agent->id]) }}">
                    @endcan
                            {{ $ba->agent->name }} {{ $ba->agent->lastname }}
                    @can('Ver Perfil Agente')
                        </a>
                    @endcan
                </td>
                <td>{{ $ba->agent->area->name }}</td>
                <td>{{ $ba->observation }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center text-muted">No se encontraron registros para los filtros aplicados.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="mt-2">
    {!! $bonusAgent->links() !!}
</div>
