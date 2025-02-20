function deleteCustomerStatus(options) { 

    var id = options.id !== undefined ? options.id: '';
    var name = options.name !== undefined ? options.name: '';
    var tableName = options.tableName !== undefined ? options.tableName : '';

    Swal.fire({
        title: "¿Desea eliminar este estado?",
        text: "Estado: " + name,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            $.post(deleteCustomerStatusRoute, {id: id, _token: token}).done(function(data) {
                $(tableName).empty();
                $(tableName).html(data.view);
                mostrarMensaje(data.title, data.text, data.status);
            });
        }
    });
}
