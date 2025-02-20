function createTarget(inputTarget, modal, divTarget, tableName, tableTotal) { 
    var amount = $(inputTarget).val();
    var userId = getUserIdFromUrl(); // Captura el ID de la URL
    $.post(saveTargetRoute, {amount: amount, user_id: userId, _token: token}).done(function(data) {
        $(divTarget).empty();
        $(divTarget).html(data.viewDiv);
        $(tableName).empty();
        $(tableName).html(data.viewTable);
        $(tableTotal).empty();
        $(tableTotal).html(data.viewTotal);
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
    });
}

function getUserIdFromUrl() {
    var pathArray = window.location.pathname.split('/');
    return pathArray[pathArray.length - 1]; // Obtiene el último segmento de la URL
}
