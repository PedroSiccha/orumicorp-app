function saveEvent(inputId, inputDateEvent, inputNameEvent, inputDescriptionEvent, inputCodCustomer, inputDesde, inputHasta, inputPriority, modal, tableName) {
    var idEvent = $(inputId).val();
    var dateEvent = $(inputDateEvent).val();
    var nameEvent = $(inputNameEvent).val();
    var descriptionEvent = $(inputDescriptionEvent).val();
    var codCustomer = $(inputCodCustomer).val();
    var desde = $(inputDesde).val();
    var hasta = $(inputHasta).val();
    var priorityEvent = $(inputPriority).val();
    $.post(saveEventRoute, {idEvent: idEvent, dateEvent: dateEvent, nameEvent: nameEvent, descriptionEvent: descriptionEvent, codCustomer: codCustomer, desde: desde, hasta: hasta, priorityEvent: priorityEvent, _token: token}).done(function(data) {
        //$(tableName).empty();
        //$(tableName).html(data.view);
        //calendar.refetchEvents();
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
        location.reload();
    });
}