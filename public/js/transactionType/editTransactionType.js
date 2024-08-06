function editarTransactionType(options) {

    var id = options.id !== undefined ? options.id : '';
    var name = options.name !== undefined ? options.name : '';
    var description = options.description !== undefined ? options.description : '';
    var modal = options.modal !== undefined ? options.modal : '';
    var inputId = options.inputId !== undefined ? options.inputId : '';
    var inputName = options.inputName !== undefined ? options.inputName : '';
    var inputDescription = options.inputDescription !== undefined ? options.inputDescription : '';

    $(inputId).val(id);
    $(inputName).val(name);
    $(inputDescription).val(description);
    $(modal).modal('show');
}

function updateTransactionType(options) {
    var id = options.idTransactionType !== undefined ? $(options.idTransactionType).val() : '';
    var name = options.nameTransactionType !== undefined ? $(options.nameTransactionType).val() : '';
    var description = options.descriptionTransactionType !== undefined ? $(options.descriptionTransactionType).val() : '';
    var modal = options.modal !== undefined ? options.modal : '';
    var tableName = options.tableName !== undefined ? options.tableName : '';
    $.post(updateTransactionTypeRoute, {id: id, name: name, description: description, status: status, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
        $(options.idTransactionType).val('');
        $(options.nameTransactionType).val('');
        $(options.descriptionTransactionType).val('');
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
    });
}
