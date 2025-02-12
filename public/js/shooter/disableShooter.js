function disableShooter(options) {
    var shooter_id = options.shooter_id !== undefined ? options.shooter_id : '';
    var tableName = options.tableName !== undefined ? options.tableName : '';
    var secondTableName = options.secondTableName !== undefined ? options.secondTableName : '';

    $.post(disableShooterRoute, {shooter_id: shooter_id, _token: token}).done(function(data) {
        mostrarMensaje(data.title, data.text, data.status);
        $(tableName).empty();
        $(tableName).html(data.view);

        $(secondTableName).empty();
        $(secondTableName).html(data.viewClients);
    });

}
