function changePassword(inputPassword, modal) {

    var password = $(inputPassword).val();
    $.post(changePasswordRoute, {password: password, _token: token}).done(function(data) {
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
    });

}
