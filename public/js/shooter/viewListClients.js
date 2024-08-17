function viewListClient(params) {
    var folderId = params.folderId !== undefined ? params.folderId: '';
    var tableName = params.tableName !== undefined ? params.tableName: '';
    $.post(viewListClientsRoute, {folderId: folderId, _token: token}).done(function (data) {
        $(tableName).empty();
        $(tableName).html(data.view);
     });
}
