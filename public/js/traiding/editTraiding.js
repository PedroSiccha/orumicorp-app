function editarTraiding(options) {

    var id = options.id !== undefined ? options.id : '';
    var code = options.code !== undefined ? options.code : '';
    var description = options.description !== undefined ? options.description : '';
    var status = options.status !== undefined ? options.status : '';
    var modal = options.modal !== undefined ? options.modal : '';
    var inputId = options.inputId !== undefined ? options.inputId : '';
    var inputCode = options.inputCode !== undefined ? options.inputCode : '';
    var inputDescription = options.inputDescription !== undefined ? options.inputDescription : '';

    $(inputId).val(id);
    $(inputCode).val(code);
    $(inputDescription).val(description);
    $(modal).modal('show');
}

function updateTraiding(options) {
    var id = options.idTraiding !== undefined ? $(options.idTraiding).val() : '';
    var code = options.codeTraiding !== undefined ? $(options.codeTraiding).val() : '';
    var description = options.descriptionTraiding !== undefined ? $(options.descriptionTraiding).val() : '';
    var modal = options.modal !== undefined ? options.modal : '';
    var tableName = options.tableName !== undefined ? options.tableName : '';
    $.post(updateTraidingRoute, {id: id, code: code, description: description, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
        $(options.idTraiding).val('');
        $(options.codeTraiding).val('');
        $(options.descriptionTraiding).val('');
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
    });
}
