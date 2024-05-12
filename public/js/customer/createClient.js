function nuevoCliente(modal) {
    $(modal).modal('show');
}

function guardarNuevoCliente(inputCode, inputName, inputLastname, inputPhone, inputOptionalPhone, inputEmail, inputCity, inputCountry, inputComment, inputRol, modal, tableName) {

    var code = $(inputCode).val();
    var name = $(inputName).val();
    var lastname = $(inputLastname).val();
    var phone = $(inputPhone).val();
    var optionalPhone = $(inputOptionalPhone).val();
    var email = $(inputEmail).val();
    var city = $(inputCity).val();
    var country = $(inputCountry).val();
    var comment = $(inputComment).val();
    var rol_id = $(inputRol).val();

    $.post(saveCustomerRoute, {code: code, name: name, lastname: lastname, phone: phone, optionalPhone: optionalPhone, email: email, city: city, country: country, comment: comment, rol_id: rol_id, _token: token}).done(function(data) {

        $(tableName).empty();
        $(tableName).html(data.view);
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);

    });
}
