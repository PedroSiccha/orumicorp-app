function searchGeneral(options) {
    var customerStatusId = options.customerStatusId !== undefined ? $(options.customerStatusId).val(): '';
    var dateInit = options.dateInit !== undefined ? $(options.dateInit).val(): '';
    var dateEnd = options.dateEnd !== undefined ? $(options.dateEnd).val(): '';
    var data = options.data !== undefined ? $(options.data).val(): '';
    var tableName = options.tableName !== undefined ? options.tableName: '';

    var dateInitInput = $(options.dateInit);

    // Restablecer el borde por si se corrige el error después
    dateInitInput.css('border', '');

    if (dateEnd != '' && dateInit == '') {
        dateInitInput.css('border', '2px solid red');
        dateInitInput.focus();
        return;
    }

    $('#dateInitSearchGeneral').on('input', function() {
        if ($(this).val() !== '') {
            $(this).css('border', ''); // Elimina el borde rojo si hay un valor
        }
    });

    $.post(searchGeneralRoute, {customerStatusId: customerStatusId, dateInit: dateInit, dateEnd: dateEnd, data: data, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
    });

}
