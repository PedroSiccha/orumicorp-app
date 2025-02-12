function editarProvider(options) {

    var id = options.id !== undefined ? options.id : '';
    var name = options.name !== undefined ? options.name : '';
    var phone = options.phone !== undefined ? options.phone : '';
    var email = options.email !== undefined ? options.email : '';
    var modal = options.modal !== undefined ? options.modal : '';
    var inputId = options.inputId !== undefined ? options.inputId : '';
    var inputName = options.inputName !== undefined ? options.inputName : '';
    var inputPhone = options.inputPhone !== undefined ? options.inputPhone : '';
    var inputEmail = options.inputEmail !== undefined ? options.inputEmail : '';

    $(inputId).val(id);
    $(inputName).val(name);
    $(inputPhone).val(phone);
    $(inputEmail).val(email);
    $(modal).modal('show');
}

function updateProvider(options) {
    var id = options.idProvider !== undefined ? $(options.idProvider).val() : '';
    var name = options.nameProvider !== undefined ? $(options.nameProvider).val() : '';
    var phone = options.phoneProvider !== undefined ? $(options.phoneProvider).val() : '';
    var email = options.emailProvider !== undefined ? $(options.emailProvider).val() : '';
    var modal = options.modal !== undefined ? options.modal : '';
    var tableName = options.tableName !== undefined ? options.tableName : '';
    $.post(updateProviderRoute, {id: id, name: name, phone: phone, email: email, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
        $(options.idProvider).val('');
        $(options.nameProvider).val('');
        $(options.phoneProvider).val('');
        $(options.emailProvider).val('');
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
    });
}
