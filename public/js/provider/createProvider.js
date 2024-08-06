function createProvider(options) {
    var name = options.nameProvider !== undefined ? $(options.nameProvider).val() : '';
    var phone = options.phoneProvider !== undefined ? $(options.phoneProvider).val() : '';
    var email = options.emailProvider !== undefined ? $(options.emailProvider).val() : '';
    var modal = options.modal !== undefined ? options.modal : '';
    var tableName = options.tableName !== undefined ? options.tableName : '';
    $.post(saveProviderRoute, {name: name, phone: phone,  email: email, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
        $(options.nameProvider).val('');
        $(options.phoneProvider).val('');
        $(options.emailProvider).val('');
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
    });
}
