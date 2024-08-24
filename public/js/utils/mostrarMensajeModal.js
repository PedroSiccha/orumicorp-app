function mostrarMensajeModal(title, text, status) {
    Swal.fire({
        title: title,
        text: text,
        icon: status,
        customClass: {
            popup: 'swal2-front' // Clases personalizadas para ajustar el z-index
        }
    });
}
