function createRetirement(inputDni, inputRetirement, modal, tableName) {
    var dni = $(inputDni).val();
    var amount = $(inputRetirement).val();
    $.post(saveRetiroRoute, {amount: amount, dni: dni, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
    });
}
