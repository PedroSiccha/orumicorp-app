function updateGiro() {
    $.post(updateGiroRoute, {_token: token}).done(function(data) {
        //$(tableName).empty();
        //$(tableName).html(data.view);
        //$(modal).modal('hide');
        //mostrarMensaje(data.title, data.text, data.status);
    });
}
