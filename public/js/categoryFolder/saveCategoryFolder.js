function saveCategoryFolder(params) {
    var name = params.nameCategoryFolder !== undefined ? $(params.nameCategoryFolder).val(): '';
    var modal = params.modal !== undefined ? params.modal : '';
    var tableName = params.tableName !== undefined ? params.tableName : '';

    $.post(saveCategoryFolderRoute, {name: name, _token: token}).done(function(data) {
        $(params.nameCategoryFolder).val('');
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
        setTimeout(function() {
            location.reload();
        }, 1000);
    });
}
