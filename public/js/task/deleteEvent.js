function deleteEvent(inputId, modal) {
    var idEvent = $(inputId).val();
    $.post(deleteEventRoute, {idEvent: idEvent, _token: token}).done(function(data) {
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
        location.reload();
    });
}
