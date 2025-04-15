<!-- shimmer de tabla para Bonus por Agente -->
<div id="shimmer-table" class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Fecha de Ingreso</th>
                <th>Monto en Soles</th>
                <th>Comisión</th>
                <th>Comisión en Soles</th>
                <th>Agente</th>
                <th>Área</th>
                <th>Comentario</th>
            </tr>
        </thead>
        <tbody>
            @for ($i = 0; $i < 8; $i++)
                <tr>
                    <td><div class="skeleton skeleton-text" style="width: 100px;"></div></td>
                    <td><div class="skeleton skeleton-text" style="width: 90px;"></div></td>
                    <td><div class="skeleton skeleton-text" style="width: 80px;"></div></td>
                    <td><div class="skeleton skeleton-text" style="width: 100px;"></div></td>
                    <td><div class="skeleton skeleton-text" style="width: 140px;"></div></td>
                    <td><div class="skeleton skeleton-text" style="width: 120px;"></div></td>
                    <td><div class="skeleton skeleton-text" style="width: 130px;"></div></td>
                </tr>
            @endfor
        </tbody>
    </table>
</div>
