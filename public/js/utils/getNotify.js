function getNotify() {
    if (typeof notiffyShooterRoute === "undefined" || typeof token === "undefined") {
        console.error("Error: notiffyShooterRoute o token no están definidos.");
        return;
    }

    $.post(notiffyShooterRoute, { _token: token }).done(function(data) {
        toastr.options.onclick = function() {
            initiateCall({ phone: data.phone, modal: '#modalCrearComentario', input: '#idComunication' });
        };

        if (data.shooter === "1") {
            toastr[data.type](data.message);
        }
    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.error("Error en la petición AJAX:", textStatus, errorThrown);
    });
}
setInterval(getNotify, 15000);
getNotify();

// Función personalizada que se ejecutará al hacer clic
function handleNotificationClick(options) {
    var phone = options.phone !== undefined ? options.phone : '';
    alert("¡Hiciste clic en la notificación! " + phone);

    // Aquí puedes ejecutar cualquier acción personalizada
    // Por ejemplo, redirigir a otra página o llamar a una API
    console.log("Notificación clickeada");
}
