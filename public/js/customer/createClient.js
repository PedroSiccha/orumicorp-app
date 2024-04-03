function nuevoCliente(modal) {
    $(modal).modal('show');
}



function guardarNuevoCliente(inputName, inputLastname, inputDni, inputEmail, inputCode, inputRol, modal, tableName) {

    var l = $( '.ladda-button-demo' ).ladda();
    l.ladda( 'start' );

    var name = $(inputName).val();
    var lastname = $(inputLastname).val();
    var dni = $(inputDni).val();
    var email = $(inputEmail).val();
    var code = $(inputCode).val();
    var rol_id = $(inputRol).val();
    $.post(saveCustomerRoute, {code: code, name: name, lastname: lastname, dni: dni, email: email, rol_id: rol_id, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
        if (data.resp == 1) {
            $(modal).modal('hide');
            l.ladda( 'stop' );
            mostrarMensaje("Correcto", "El cliente se guardó correctamente", "success");
        } else {
            $(modal).modal('hide');
            l.ladda( 'stop' );
            mostrarMensaje("Error", "Hubo un error al guardar el cliente", "error");
        }
    });
}

function mostrarMensaje(title, text, icon) {
    Swal.fire({
        title: title,
        text: text,
        icon: icon
    });
}
