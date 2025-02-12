function saveFolder(params) {
    var name = params.nameFolder !== undefined ? $(params.nameFolder).val(): '';
    var categoryId = params.categoryId !== undefined ? $(params.categoryId).val(): '';
    var modal = params.modal !== undefined ? params.modal : '';
    var tableName = params.tableName !== undefined ? params.tableName : '';
    $.post(saveFolderRoute, {name: name, categoryId: categoryId, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
        $(params.nameFolder).val('');
        $(params.categoryId).val('');
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
    });
}
