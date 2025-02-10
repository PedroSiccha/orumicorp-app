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

//Registrar Evento desde perfil del cliente
function saveEventClient(options) {
    // var idClient = options.inputIdClient !== undefined ? $(options.inputIdClient).val(): '';
    var date = options.inputDateEvent !== undefined ? $(options.inputDateEvent).val(): '';
    var nameEvent = options.inputNombreEvent !== undefined ? $(options.inputNombreEvent).val(): '';
    var description = options.inputDescriptionEvent !== undefined ? $(options.inputDescriptionEvent).val(): '';
    var dniClient = options.inputDniClient !== undefined ? $(options.inputDniClient).val(): '';
    var codeAgent = options.inputCodeAgent !== undefined ? $(options.inputCodeAgent).val(): '';
    var hourInit = options.inputHourInit !== undefined ? $(options.inputHourInit).val(): '';
    var hourEnd = options.inputHourEnd !== undefined ? $(options.inputHourEnd).val(): '';
    var idPriority = options.inputIdPriority !== undefined ? $(options.inputIdPriority).val(): '';
    var tableName = options.tableName !== undefined ? options.tableName: '';
    var modal = options.modal !== undefined ? options.modal: '';

    var urlPath = window.location.pathname; // Obtiene "/profileClient/285"
    var idClient = urlPath.split('/').pop();

    $.post(saveEventClientRoute, {idClient: idClient, date: date, nameEvent: nameEvent, description: description, dniClient: dniClient, codeAgent: codeAgent, hourInit: hourInit, hourEnd: hourEnd, idPriority: idPriority, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
    });
}
