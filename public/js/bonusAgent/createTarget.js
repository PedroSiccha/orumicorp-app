function createTarget(inputTarget, inputDni, modal, tableName) {
    var amount = $(inputTarget).val();
    var dni = $(inputDni).val();
    $.post(saveTargetRoute, {amount: amount, dni: dni, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
    });
}
