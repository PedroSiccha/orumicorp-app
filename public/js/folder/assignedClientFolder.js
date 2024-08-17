function mostrarAddClient(options) {

    var inputFolderId = options.inputFolderId !== undefined ? options.inputFolderId: '';
    var folderId = options.folderId !== undefined ? options.folderId: '';
    var inputNameFolder = options.inputNameFolder !== undefined ? options.inputNameFolder: '';
    var folderName = options.folderName !== undefined ? options.folderName: '';

    $(inputFolderId).val(folderId);
    $(inputNameFolder).val(folderName);

    var modal = options.modal !== undefined ? options.modal : '';

    $(modal).modal('show');
}

function addClientFolder(params) {
    var folderId = params.folderId !== undefined ? $(params.folderId).val(): '';
    var codeClient = params.codeClient !== undefined ? $(params.codeClient).val(): '';
    var modal = params.modal !== undefined ? params.modal : '';
    var tableName = params.tableName !== undefined ? params.tableName : '';
    $.post(addClientFolderRoute, {folderId: folderId, codeClient: codeClient, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
        $(params.folderId).val('');
        $(params.codeClient).val('');
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
    });
}
