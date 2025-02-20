function saveVista(options) {
    var id = options.client_id !== undefined ? options.client_id : '';
    $.post(saveViewsRoute, { id: id, _token: token}).done(function(data) {});
}
