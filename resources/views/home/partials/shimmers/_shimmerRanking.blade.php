<div id="shimmer-ranking" class="p-3">
    <table class="table table-striped mb-0">
        <thead>
            <tr>
                <th>#</th>
                <th>Área</th>
                <th>Nombre</th>
                <th>Monto</th>
            </tr>
        </thead>
        <tbody>
            @for ($i = 0; $i < 5; $i++)
                <tr>
                    <td><div class="skeleton skeleton-text w-25"></div></td>
                    <td><div class="skeleton skeleton-text w-50"></div></td>
                    <td><div class="skeleton skeleton-text w-75"></div></td>
                    <td><div class="skeleton skeleton-text w-50"></div></td>
                </tr>
            @endfor
        </tbody>
    </table>
</div>
