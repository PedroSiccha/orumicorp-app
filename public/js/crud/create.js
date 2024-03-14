function create(...args) {
    createClientEntity = args;
    console.log("PARAMEROS ===> " + createClientEntity.code);
    var name = $(inputName).val();
    var lastname = $(inputLastname).val();
    var dni = $(inputDni).val();
    var email = $(inputEmail).val();
    var code = $(inputCode).val();
    var rol_id = $(inputRol).val();
    $.post(saveCustomerRoute, {code: code, name: name, lastname: lastname, dni: dni, email: email, rol_id: rol_id, _token: token}).done(function(data) {
        $(modal).modal('hide');
        $(tableName).empty();
        $(tableName).html(data.view);
        if (data.resp == 1) {
            mostrarMensaje("Correcto", "El cliente se guardó correctamente", "success");
        } else {
            mostrarMensaje("Error", "Hubo un error al guardar el cliente", "error");
        }
});
}
