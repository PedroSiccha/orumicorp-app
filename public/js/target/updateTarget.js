function updateTarget(inputTarget, modal, divTarget, tableName, tableTotal) {
    var amount = $(inputTarget).val();
    $.post(updateTargetRoute, {amount: amount, _token: token}).done(function(data) {
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
