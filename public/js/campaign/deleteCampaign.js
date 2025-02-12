function deleteCampaign(options) {

    var id = options.idCampaign !== undefined ? options.idCampaign : '';
    var name = options.name !== undefined ? options.name : '';
    var tableName = options.tableName !== undefined ? options.tableName : '';

    Swal.fire({
        title: "¿Desea eliminar esta Campaña?",
        text: "Campaña: " + name,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            $.post(deleteCampaignRoute, {id: id, _token: token}).done(function(data) {
                $(tableName).empty();
                $(tableName).html(data.view);
                mostrarMensaje(data.title, data.text, data.status);
            });
        }
    });
}
