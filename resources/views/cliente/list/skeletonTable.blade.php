<div id="skeleton-loader">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th><div class="skeleton skeleton-text" style="width: 20px;"></div></th>
                    <th><div class="skeleton skeleton-text" style="width: 120px;"></div></th>
                    <th><div class="skeleton skeleton-text" style="width: 180px;"></div></th>
                    <th><div class="skeleton skeleton-text" style="width: 220px;"></div></th>
                    <th><div class="skeleton skeleton-text" style="width: 100px;"></div></th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < 5; $i++)
                <tr>
                    <td><div class="skeleton skeleton-box"></div></td>
                    <td><div class="skeleton skeleton-text" style="width: 100px;"></div></td>
                    <td><div class="skeleton skeleton-text" style="width: 150px;"></div></td>
                    <td><div class="skeleton skeleton-text" style="width: 200px;"></div></td>
                    <td>
                        <div class="d-flex">
                            <div class="skeleton skeleton-icon"></div>
                            <div class="skeleton skeleton-icon"></div>
                            <div class="skeleton skeleton-icon"></div>
                            <div class="skeleton skeleton-icon"></div>
                            <div class="skeleton skeleton-icon"></div>
                        </div>
                    </td>
                </tr>
                @endfor
            </tbody>
        </table>
    </div>
</div>
