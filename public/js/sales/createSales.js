function createSales(inputDniCustomer, inputDniAgent, inputAmount, inputPercent, inputExchangeRate, inputCommission, inputObservation, modal, tableName) {
    var dniCustomer = $(inputDniCustomer).val();
    var dniAgent = $(inputDniAgent).val();
    var amount = $(inputAmount).val();
    var percent = $(inputPercent).val();
    var exchange_rate = $(inputExchangeRate).val();
    var commission = $(inputCommission).val();
    var observation = $(inputObservation).val();
    $.post(saveSaleRoute, {dniCustomer: dniCustomer, dniAgent: dniAgent,  amount: amount, percent: percent, exchange_rate: exchange_rate, commission: commission, observation: observation, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
    });
}
