function createBonus(inputDniCustomer, inputAmount, inputObservation, inputPercent, inputExchangeRate, inputCommission, modal, tableName) {
    var dniCustomer = $(inputDniCustomer).val();
    var amount = $(inputAmount).val();
    var observation = $(inputObservation).val();
    var percent_id = $(inputPercent).val();
    var commission_id = $(inputCommission).val();
    var exchange_rate_id = $(inputExchangeRate).val();
    $.post(saveBonusRoute, {dniCustomer: dniCustomer, amount: amount, observation: observation, percent_id: percent_id, commission_id: commission_id, exchange_rate_id: exchange_rate_id, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
    });
}
