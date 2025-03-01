function liberarCliente(options) {

    var idGroupClientes = [];
    var tableName = options.tableName !== undefined ? options.tableName : '';
    var limit = $('#limit').val();

    $('.chekboxses:checked').each(function() {
        var val = $(this).val();
        if (val && val !== "on") {
            idGroupClientes.push(val);
        }
    });

    Swal.fire({
        title: "¿Desea liberar estos clientes?",
        text: "Confirme",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, liberar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            $.post(liberarClienteRoute, {idGroupClientes: idGroupClientes, limit: limit, _token: token}).done(function(data) {
                $(tableName).empty();
                $(tableName).html(data.view);
                mostrarMensaje(data.title, data.text, data.status);
            });
        }
    });
}
