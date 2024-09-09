function createPlatform(options) {
    var name = options.namePlatform !== undefined ? $(options.namePlatform).val() : '';
    var description = options.descriptionPlatform !== undefined ? $(options.descriptionPlatform).val() : '';
    var modal = options.modal !== undefined ? options.modal : '';
    var tableName = options.tableName !== undefined ? options.tableName : '';
    $.post(savePlatformRoute, {name: name, description: description, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
        $(options.namePlatform).val('');
        $(options.descriptionPlatform).val('');
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
    });
}
