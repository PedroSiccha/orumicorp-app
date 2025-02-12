function changeStatusGroup(inputId, inputStatus, modal, tableName) {
    var idGroupClientes = [];
    var statusId = $(inputStatus).val();

    $('.chekboxses:checked').each(function() {
        var val = $(this).val();
        if (val && val !== "on") {
            idGroupClientes.push(val);
        }
    });

    console.log('IdGroupClient ', idGroupClientes);
    $.post(changeStatusGroupRoute, {idGroupClientes: idGroupClientes, statusId: statusId, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
    });
}
