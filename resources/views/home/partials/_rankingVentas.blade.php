<div class="ibox-content">
    {{-- Loader de tabla de ranking --}}
    @include('home.partials.shimmers._shimmerRanking')

    {{-- Tabla real oculta inicialmente --}}
    <div id="ranking-real" class="table-responsive d-none">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Área</th>
                    <th>Nombre</th>
                    <th>Monto</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($montosPorAgente as $index => $rankingagent)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $rankingagent->area }}</td>
                        <td>{{ $rankingagent->name }} {{ $rankingagent->lastname }}</td>
                        <td>$ {{ number_format($rankingagent->monto, 2) }}</td>
                    </tr>
                @endforeach

                @if ($montosPorAgente->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center text-muted">
                            No hay datos de ranking disponibles.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
