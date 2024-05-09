function editarCliente(id, code, name, lastname, phone, optional_phone, city, country, comment, email, modal, inputId, inputCode, inputName, inputLastName, inputPhone, inputOptionalPhone, inputCity, inputCountry, inputComment, inputEmail) {
    $(inputId).val(id);
    $(inputCode).val(code);
    $(inputName).val(name);
    $(inputLastName).val(lastname);
    $(inputPhone).val(phone);
    $(inputOptionalPhone).val(optional_phone);
    $(inputCity).val(city);
    $(inputCountry).val(country);
    $(inputComment).val(comment);
    $(inputEmail).val(email);
    $(modal).modal('show');
}

function updateClient(inputId, inputCode, inputName, inputLastName, inputPhone, inputOptionalPhone, inputEmail, inputCity, inputCountry, inputComment, inputRol, modal, tableName) {
    var id = $(inputId).val();
    var code = $(inputCode).val();
    var name = $(inputName).val();
    var lastname = $(inputLastName).val();
    var phone = $(inputPhone).val();
    var optionalPhone = $(inputOptionalPhone).val();
    var email = $(inputEmail).val();
    var city = $(inputCity).val();
    var country = $(inputCountry).val();
    var comment = $(inputComment).val();
    var rol_id = $(inputRol).val();

    $.post(updateClientRoute, {id: id, code: code, name: name, lastname: lastname, phone: phone, optionalPhone: optionalPhone, email: email, city: city, country: country, comment: comment, rol_id: rol_id, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
    });
}
