function nuevoCliente(modal) {
    $(modal).modal('show');
}

function guardarNuevoCliente(inputName, inputLastname, inputPhone, inputOptionalPhone, inputEmail, inputCountry, inputProvide, modal, tableName) {

    // var code = $(inputCode).val();
    var name = $(inputName).val().trim().toUpperCase();;
    var lastname = $(inputLastname).val().trim().toUpperCase();;
    var phone = $(inputPhone).val();
    var optionalPhone = $(inputOptionalPhone).val();
    var email = $(inputEmail).val();
    // var city = $(inputCity).val();
    var country = $(inputCountry).val();
    var provide_id = $(inputProvide).val();
    // var traiding_id = $(inputTraiding).val();
    // var platform_id = $(inputPlatform).val();
    var limit = $('#limit').val();

    $.post(saveCustomerRoute, {name: name, lastname: lastname, phone: phone, optionalPhone: optionalPhone, email: email, country: country, provide_id: provide_id, limit: limit, _token: token}).done(function(data) {

        $(tableName).empty();
        $(tableName).html(data.view);
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);

    });
}
