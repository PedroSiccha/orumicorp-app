function nuevoCliente(modal) {
    $(modal).modal('show');
}

function guardarNuevoCliente(inputCode, inputName, inputLastname, inputPhone, inputOptionalPhone, inputEmail, inputCity, inputCountry, inputProvide, inputTraiding, inputPlatform, modal, tableName) {

    var code = $(inputCode).val();
    var name = $(inputName).val();
    var lastname = $(inputLastname).val();
    var phone = $(inputPhone).val();
    var optionalPhone = $(inputOptionalPhone).val();
    var email = $(inputEmail).val();
    var city = $(inputCity).val();
    var country = $(inputCountry).val();
    var provide_id = $(inputProvide).val();
    var traiding_id = $(inputTraiding).val();
    var platform_id = $(inputPlatform).val();

    $.post(saveCustomerRoute, {code: code, name: name, lastname: lastname, phone: phone, optionalPhone: optionalPhone, email: email, city: city, country: country, provide_id: provide_id, traiding_id: traiding_id, platform_id: platform_id, _token: token}).done(function(data) {

        $(tableName).empty();
        $(tableName).html(data.view);
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);

    });
}
