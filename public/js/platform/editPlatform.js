function editarPlatform(options) {

    var id = options.id !== undefined ? options.id : '';
    var name = options.name !== undefined ? options.name : '';
    var description = options.description !== undefined ? options.description : '';
    var status = options.status !== undefined ? options.status : '';
    var modal = options.modal !== undefined ? options.modal : '';
    var inputId = options.inputId !== undefined ? options.inputId : '';
    var inputName = options.inputName !== undefined ? options.inputName : '';
    var inputDescription = options.inputDescription !== undefined ? options.inputDescription : '';
    var inputStatus = options.inputStatus !== undefined ? options.inputStatus : '';

    $(inputId).val(id);
    $(inputName).val(name);
    $(inputDescription).val(description);
    $(inputStatus).val(status);
    $(modal).modal('show');
}

function updatePlatform(options) {
    var id = options.idPlatform !== undefined ? $(options.idPlatform).val() : '';
    var name = options.namePlatform !== undefined ? $(options.namePlatform).val() : '';
    var description = options.descriptionPlatform !== undefined ? $(options.descriptionPlatform).val() : '';
    // var status = options.status !== undefined ? $(options.status).val() : '';
    var modal = options.modal !== undefined ? options.modal : '';
    var tableName = options.tableName !== undefined ? options.tableName : '';
    $.post(updatePlatformRoute, {id: id, name: name, description: description, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
        $(options.idPlatform).val('')
        $(options.namePlatform).val('')
        $(options.descriptionPlatform).val('')
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
    });
}
