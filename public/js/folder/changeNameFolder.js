function changeNameFolder(options) {
    var inputFolderId = options.inputFolderId !== undefined ? options.inputFolderId: '';
    var folderId = options.folderId !== undefined ? options.folderId: '';
    var inputNameFolder = options.inputNameFolder !== undefined ? options.inputNameFolder: '';
    var folderName = options.folderName !== undefined ? options.folderName: '';

    $(inputFolderId).val(folderId);
    $(inputNameFolder).val(folderName);

    var modal = options.modal !== undefined ? options.modal : '';

    $(modal).modal('show');
}

function editNameFolder(options) {
    var name = options.nameFolder !== undefined ? $(options.nameFolder).val(): '';
    var folderId = options.folderId !== undefined ? $(options.folderId).val(): '';
    var modal = options.modal !== undefined ? options.modal : '';
    var tableName = options.tableName !== undefined ? options.tableName : '';
    $.post(editFolderRoute, {name: name, folderId: folderId, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
        $(options.nameFolder).val('');
        $(options.folderId).val('');
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
    });
}
