function createTransactionType(options) {
    var name = options.nameTransactionType !== undefined ? $(options.nameTransactionType).val() : '';
    var description = options.descriptionTransactionType !== undefined ? $(options.descriptionTransactionType).val() : '';
    var modal = options.modal !== undefined ? options.modal : '';
    var tableName = options.tableName !== undefined ? options.tableName : '';
    $.post(saveTransactionTypeRoute, {name: name, description: description, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
    });
}
