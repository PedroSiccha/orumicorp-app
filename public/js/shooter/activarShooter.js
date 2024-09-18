function activeShooter(options) {

    var folder_id = options.folder_id !== undefined ? $(options.folder_id).val() : '';
    var modal = options.modal !== undefined ? options.modal : '';
    var tableName = options.tableName !== undefined ? options.tableName : '';
    var secondTableName = options.secondTableName !== undefined ? options.secondTableName : '';
    $(modal).modal('hide');
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
            //mostrarMensaje('Shooter', 'Se activó correctamente', 'success');
            $.post(activeShooterRoute, {folder_id: folder_id, _token: token}).done(function(data) {
                $(tableName).empty();
                $(tableName).html(data.view);

                $(secondTableName).empty();
                $(secondTableName).html(data.viewClients);
                mostrarMensaje(data.title, data.text, data.status);
            });
        }
    });
}
