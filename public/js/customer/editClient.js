function editarCliente(id, code, name, lastname, phone, optional_phone, country, email, provider_id, status_id, modal, inputId, inputCode, inputName, inputLastName, inputPhone, inputOptionalPhone, inputCountry, inputEmail, inputProvider, inputStatus) {
    $(inputId).val(id);
    $(inputCode).val(code);
    $(inputName).val(name);
    $(inputLastName).val(lastname);
    $(inputPhone).val(phone);
    $(inputOptionalPhone).val(optional_phone);
    $(inputCountry).val(country);
    $(inputEmail).val(email);
    $(inputProvider).val(provider_id);
    $(inputStatus).val(status_id);
    $(modal).modal('show');
}

function updateClient(inputId, inputCode, inputName, inputLastName, inputPhone, inputOptionalPhone, inputEmail, inputCountry, inputComment, inputRol, modal, tableName) {
    var id = $(inputId).val();
    var name = $(inputName).val();
    var lastname = $(inputLastName).val();
    var phone = $(inputPhone).val();
    var optionalPhone = $(inputOptionalPhone).val();
    var email = $(inputEmail).val();
    var country = $(inputCountry).val();
    var comment = $(inputComment).val();
    var rol_id = $(inputRol).val();

    $.post(updateClientRoute, {id: id, name: name, lastname: lastname, phone: phone, optionalPhone: optionalPhone, email: email, country: country, comment: comment, rol_id: rol_id, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
    });
}
