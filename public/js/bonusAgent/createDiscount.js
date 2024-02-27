function createDiscount(inputAmount, inputObservation, inputDniAgent, modal, tableName) {
    var amount = $(inputAmount).val()*(-1);
    var observation = $(inputObservation).val();
    var dniAgent = $(inputDniAgent).val();
    $.post(saveBonusRoute, {dniCustomer: 0, amount: amount, observation: observation, percent_id: 0, commission_id: 0, exchange_rate_id: 0, dniAgent: dniAgent, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
    });
}
