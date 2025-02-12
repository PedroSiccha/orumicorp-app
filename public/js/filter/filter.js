function filterAdvanced(options) {
    var filterFor = options.buttonFilter !== undefined ? $(options.buttonFilter).text(): '';
    var inputName = options.inputFilter !== undefined ? $(options.inputFilter).val(): '';
    var statusId = options.selectStatus !== undefined ? $(options.selectStatus).val(): '';
    var typeRange = options.selectTypeRange !== undefined ? $(options.selectTypeRange).val(): '';
    var dateInit = options.dateInit !== undefined ? $(options.dateInit).val(): '';
    var dateEnd = options.dateEnd !== undefined ? $(options.dateEnd).val(): '';
    var tableName = options.tableName !== undefined ? options.tableName : '';

    if (dateInit) {
        var formattedDateInit = new Date(dateInit).toISOString().split('T')[0]; // YYYY-MM-DD
    } else {
        var formattedDateInit = '';
    }

    if (dateEnd) {
        var formattedDateEnd = new Date(dateEnd).toISOString().split('T')[0]; // YYYY-MM-DD
    } else {
        var formattedDateEnd = '';
    }

    $(tableName).closest('.ibox-content').addClass('sk-loading');

    $.post(filterAdvancedRoute, {filterFor: filterFor, inputName: inputName, statusId: statusId, typeRange: typeRange, dateInit: formattedDateInit, dateEnd: formattedDateEnd, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
    }).fail(function() {
        // Mostrar un mensaje de error si falla
        $(tableName).empty();
        $(tableName).html('<p style="text-align: center; color: red;">SIN DATOS.</p>');
    }).always(function() {
        // Desactivar spinner al completar la petición
        $(tableName).closest('.ibox-content').removeClass('sk-loading');
    });

}
