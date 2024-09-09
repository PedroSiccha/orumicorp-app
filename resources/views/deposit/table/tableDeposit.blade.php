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
                    <th>
                        @if ($deposit->date)
                            {{ $deposit->date }}
                        @endif
                    </th>
                    <th>
                        @if ($deposit->customer)
                            {{ $deposit->customer->id }}
                        @endif
                    </th>
                    <th>
                        @if ($deposit->customer)
                            {{ $deposit->customer->name }} {{ $deposit->customer->lastname }}
                        @endif
                    </th>
                    <th></th>
                    <th>
                            {{ $deposit->id }}
                    </th>
                    <th>
                        S/. {{ $deposit->amount }}
                    </th>
                    <th>
                        $ {{ number_format($deposit->amount / 3.5, 2) }}
                    </th>
                    <th>
                        {{ $deposit->tipo }}
                    </th>
                    <th>
                        @if ($deposit->agent)
                            {{ $deposit->agent->name }} {{ $deposit->agent->lastname }}
                        @endif
                    </th>
                    <th></th>
                    <th></th>
                    <th>
                        @if ($deposit->user)
                            {{ $deposit->user->name }}
                        @endif
                    </th>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
