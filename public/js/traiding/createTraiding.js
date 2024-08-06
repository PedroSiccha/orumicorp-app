function createTraiding(options) {
    var code = options.codeTraiding !== undefined ? $(options.codeTraiding).val() : '';
    var description = options.descriptionTraiding !== undefined ? $(options.descriptionTraiding).val() : '';
    var modal = options.modal !== undefined ? options.modal : '';
    var tableName = options.tableName !== undefined ? options.tableName : '';
    $.post(saveTraidingRoute, {code: code, description: description, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
        $(options.codeTraiding).val('');
        $(options.descriptionTraiding).val('');
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
    });
}
