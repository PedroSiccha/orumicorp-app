function activarShooter() {
    Swal.fire({
        title: "¿Desea activar el shooter?",
        text: "SHOOTER ",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, activar",
        cancelButtonText: "Cancelar"
    }).then((result) => {

        if (result.isConfirmed) {
            mostrarMensaje('Shooter', 'Se activó correctamente', 'success');
            // $.post(deleteClientRoute, {id: id, _token: token}).done(function(data) {
            //     $(tableName).empty();
            //     $(tableName).html(data.view);
            //     mostrarMensaje(data.title, data.text, data.status);
            // });
        }
    });
}
