
function changeFolder(options) {
    var modal = options.modal !== undefined ? options.modal: '';
    var customerId = options.customerId !== undefined ? options.customerId: '';
    var folderId = options.folderId !== undefined ? options.folderId: '';
    $('#idCustomerChangeFolder').val(customerId);
    $('#oldFolderChangeId').val(folderId);

    $(modal).modal('show');
}

function assignNewFolder(options) {

    var clienteId = options.clienteId !== undefined ? $(options.clienteId).val(): '';
    var folderId = options.folderId !== undefined ? $(options.folderId).val(): '';
    var modal = options.modal !== undefined ? options.modal : '';
    var tableName = options.tableName !== undefined ? options.tableName : '';
    $.post(changeFolderRoute, {folderId: folderId, clienteId: clienteId, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
        $(options.folderId).val('');
        $(options.clienteId).val('');
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
    });
}
