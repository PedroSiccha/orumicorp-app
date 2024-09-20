function modalCargaMasiva(options) {

    var folder_id = options.folderId !== undefined ? options.folderId : '';
    var modal = options.modal !== undefined ? options.modal : '';
    var inputFolderId = options.inputFolderId !== undefined ? options.inputFolderId : '';

    $(inputFolderId).val(folder_id);
    $(modal).modal('show');
}
