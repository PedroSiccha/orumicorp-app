// notifications.js
function markNotificationsAsSeen(module) {
    if (!module) {
        console.error("El módulo no está definido");
        return;
    }

    fetch(`/notifications/mark-as-seen/${module}`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
            "Content-Type": "application/json",
        },
        body: JSON.stringify({}),
    })
    .then(response => {
        if (response.ok) {
            console.log(`Notificaciones para el módulo "${module}" marcadas como vistas`);
        } else {
            console.error("Error al marcar las notificaciones como vistas");
        }
    })
    .catch(error => {
        console.error("Error en la solicitud de notificaciones:", error);
    });
}
