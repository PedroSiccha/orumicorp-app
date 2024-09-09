function addGroupClientFolder(params) {
    var folderId = params.folderId !== undefined ? $(params.folderId).val(): '';
    var idGroupClientes = [];
    var modal = params.modal !== undefined ? params.modal : '';
    var tableName = params.tableName !== undefined ? params.tableName : '';
    $('.chekboxses:checked').each(function() {
        var val = $(this).val();
        if (val && val !== "on") {
            idGroupClientes.push(val);
        }
    });
    $.post(addGroupClientFolderRoute, {folderId: folderId, idGroupClientes: idGroupClientes, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
    });
}
