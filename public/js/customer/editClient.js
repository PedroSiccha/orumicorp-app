function editarCliente(id, code, name, lastname, phone, email, modal, inputId, inputCode, inputName, inputLastName, inputPhone, inputEmail) {
    $(inputId).val(id);
    $(inputCode).val(code);
    $(inputName).val(name);
    $(inputLastName).val(lastname);
    $(inputPhone).val(phone);
    $(inputEmail).val(email);
    $(modal).modal('show');
}

function updateClient(modal, inputId, inputCode, inputName, inputLastName, inputPhone, inputEmail, inputRol, tableName) {
    var id = $(inputId).val();
    var name = $(inputName).val();
    var lastname = $(inputLastName).val();
    var phone = $(inputPhone).val();
    var email = $(inputEmail).val();
    var code = $(inputCode).val();
    var rol_id = $(inputRol).val();

    $.post(updateClientRoute, {id: id, code: code, name: name, lastname: lastname, phone: phone, email: email, rol_id: rol_id, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
    });
}
