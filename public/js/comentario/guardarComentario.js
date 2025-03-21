function guardarComentario(options) {

    var inputComunication = options.inputComunication !== undefined ? options.inputComunication : '';
    var modal = options.modal !== undefined ? options.modal : '';
    var inputComentario = options.inputComentario !== undefined ? options.inputComentario : '';
    var table = options.table !== undefined ? options.table : '';
    var customerStatusId = options.customerStatusId !== undefined ? $(options.customerStatusId).val() : '';

    var idComunication = $(inputComunication).val();
    var txtComentario = $(inputComentario).val();

    $.post(saveComentarioRoute, {idComunication: idComunication, txtComentario: txtComentario, customerStatusId: customerStatusId, _token: token}).done(function(data) {

        $(table).empty();
        $(table).html(data.view);
        $(inputComentario).val('');
        $(options.customerStatusId).prop('selectedIndex', 0);
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);

    });
}
