function saveVista(options) {
    var id = options.client_id !== undefined ? options.client_id : '';
    $.post(saveViewsRoute, { id: id, _token: token}).done(function(data) {
        // var profileClientUrl = "{{ route('profileClient', ['id' => ':id']) }}".replace(':id', id);
        // window.location.href = profileClientUrl;
    });
}
