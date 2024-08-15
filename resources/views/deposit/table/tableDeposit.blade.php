<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Fecha Registro</th>
                <th>Id Cliente</th>
                <th>Cliente</th>
                <th>Platform</th>
                <th>Trading Account Id</th>
                <th>Monto</th>
                <th>Monto ($)</th>
                <th>Transacción</th>
                <th>Agente</th>
                <th>Desk</th>
                <th>Campaña</th>
                <th>Encargado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($deposits as $deposit)
                <tr>
                    <th>{{ $deposit->date }}</th>
                    <th>{{ $deposit->customer->id }}</th>
                    <th>{{ $deposit->customer->name }} {{ $deposit->customer->lastname }}</th>
                    <th></th>
                    <th>{{ $deposit->id }}</th>
                    <th>S/. {{ $deposit->amount }}</th>
                    <th>$ {{ number_format($deposit->amount / 3.5, 2) }}</th>
                    <th>{{ $deposit->tipo }}</th>
                    <th>{{ $deposit->agent->name }} {{ $deposit->agent->lastname }}</th>
                    <th></th>
                    <th></th>
                    <th>
                        @if ($deposit->user)
                            {{ $deposit->user->name }}
                        @else
                            Verificar la Data
                        @endif
                    </th>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
