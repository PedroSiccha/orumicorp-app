function changePassword(inputPassword, modal) {

    const path = window.location.pathname; // "/perfilUsuario/85"
    const segments = path.split("/"); // ["", "perfilUsuario", "85"]
    const id = segments[2];

    var password = $(inputPassword).val();
    $.post(changePasswordRoute, {password: password, userId: id, _token: token}).done(function(data) {
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
    });

}
 