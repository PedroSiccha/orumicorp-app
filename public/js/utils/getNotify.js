function getNotify() {

    $.post(notiffyShooterRoute, {_token: token}).done(function(data) {

        toastr.options.onclick = function() {
            // handleNotificationClick({ phone: data.phone, modal: '#modalCrearComentario', input: '#idComunication' });
            initiateCall({phone: data.phone, modal: '#modalCrearComentario', input: '#idComunication'})
        };

        if (data.shooter === "1") {
            toastr[data.type](data.message);
        }
    });

}
setInterval(getNotify, 60000);
getNotify();

// Función personalizada que se ejecutará al hacer clic
function handleNotificationClick(options) {
    var phone = options.phone !== undefined ? options.phone : '';
    alert("¡Hiciste clic en la notificación! " + phone);

    // Aquí puedes ejecutar cualquier acción personalizada
    // Por ejemplo, redirigir a otra página o llamar a una API
    console.log("Notificación clickeada");
}
