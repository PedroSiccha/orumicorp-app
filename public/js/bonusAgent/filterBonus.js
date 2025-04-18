// js/bonusAgent/filterBonus.js
document.addEventListener('DOMContentLoaded', function () {
    // Disparo automático de filtros cuando se cambia un valor
    $('#area, #inputCode, #date_added_init, #date_added_end').on('change', function () {
        filterBonus('#area', '#inputCode', '#date_added_init', '#date_added_end', '#tabBonus');
    });
});

document.addEventListener('DOMContentLoaded', function () {
    $('#btnResetFilters').on('click', function () {
        const now = new Date();

        const day = String(now.getDate()).padStart(2, '0');
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const year = now.getFullYear();

        const today = `${day}/${month}/${year}`;
        const yearStart = `01/01/${year}`;

        $('#date_added_init').val(yearStart);
        $('#date_added_end').val(today);
        $('#area').val('');
        $('#inputCode').val(null).trigger('change'); // limpiar Select2

        filterBonus('#area', '#inputCode', '#date_added_init', '#date_added_end', '#tabBonus');
    });
});



function filterBonus(inputArea, inputCode, inputDateInit, inputDateEnd) {
    const area = $(inputArea).val();
    const dateInit = $(inputDateInit).val();
    const dateEnd = $(inputDateEnd).val();
    const code = $(inputCode).val();

    // Mostrar shimmer y ocultar tabla/total
    $('#bonus-table-wrapper').hide();
    $('#bonus-total-wrapper').hide();
    $('#shimmer-wrapper-table').show();
    $('#shimmer-wrapper-totals').show();

    $.post(filterBonusRoute, {
        area: area,
        code: code,
        dateInit: dateInit,
        dateEnd: dateEnd,
        _token: token
    })
    .done(function(response) {
        $('#shimmer-wrapper-table').hide();
        $('#shimmer-wrapper-totals').hide();

        $('#bonus-table-wrapper')
            .html(response.viewTable)
            .fadeIn();

        $('#bonus-total-wrapper')
            .html(response.viewTotals)
            .fadeIn();
    })
    .fail(function(xhr) {
        $('#shimmer-wrapper-table').hide();
        $('#shimmer-wrapper-totals').hide();

        $('#bonus-table-wrapper').html('<div class="alert alert-danger">Error al cargar los datos.</div>').fadeIn();
        $('#bonus-total-wrapper').html('');
        console.error(xhr);
    });
}


// Event delegation para paginación con AJAX
$(document).on('click', '.pagination a', function (e) {
    e.preventDefault();
    let url = $(this).attr('href');

    // Obtener filtros actuales
    const area = $('#area').val();
    const code = $('#inputCode').val();
    const dateInit = $('#date_added_init').val();
    const dateEnd = $('#date_added_end').val();

    // Mostrar shimmer antes del nuevo request
    $('#bonus-table-wrapper').hide();
    $('#bonus-total-wrapper').hide();
    $('._shimmerTable').show();
    $('._shimmerTotals').show();

    $.post(url, {
        area: area,
        code: code,
        dateInit: dateInit,
        dateEnd: dateEnd,
        _token: token
    })
    .done(function(response) {
        $('._shimmerTable').hide();
        $('._shimmerTotals').hide();
        $('#bonus-table-wrapper').html(response.viewTable).fadeIn();
        $('#bonus-total-wrapper').html(response.viewTotals).fadeIn();
    })
    .fail(function(xhr) {
        console.error("Error en paginación:", xhr);
        $('._shimmerTable').hide();
        $('._shimmerTotals').hide();
        $('#bonus-table-wrapper').html('<div class="alert alert-danger">Error al cargar la nueva página.</div>').fadeIn();
        $('#bonus-total-wrapper').html('');
    });
});