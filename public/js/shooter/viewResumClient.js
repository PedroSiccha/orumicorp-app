function viewResumClient(options) {
    var clientId = options.clientId !== undefined ? options.clientId: '';
    var tableName = options.tableName !== undefined ? options.tableName: '';
    $.post(viewResumClientRoute, {clientId: clientId, _token: token}).done(function (data) {
        $(tableName).empty();
        $(tableName).html(data.view);
     });
}
