function createSales(options) {
    var dniCustomer = options.dniCustomer !== undefined ? $(options.dniCustomer).val() : '';
    var dniAgent = options.dniAgent !== undefined ? $(options.dniAgent).val() : '';
    var amount = options.amount !== undefined ? $(options.amount).val() : '';
    var percent = options.percent !== undefined ? $(options.percent).val() : '';
    var exchange_rate = options.exchange_rate !== undefined ? $(options.exchange_rate).val() : '';
    var commission = options.commission !== undefined ? $(options.commission).val() : '';
    var observation = options.observation !== undefined ? $(options.observation).val() : '';
    var modal = options.modal !== undefined ? options.modal : '';
    var tableName = options.tableName !== undefined ? options.tableName : '';
    var typeSales = options.typeSales !== undefined ? options.typeSales : '';
    $.post(saveSaleRoute, {dniCustomer: dniCustomer, dniAgent: dniAgent,  amount: amount, percent: percent, exchange_rate: exchange_rate, commission: commission, observation: observation, typeSales: typeSales, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
    });
}
/*
function createSales(inputDniCustomer, inputDniAgent, inputAmount, inputPercent, inputExchangeRate, inputCommission, inputObservation, modal, tableName, typeSales) {
    var dniCustomer = $(inputDniCustomer).val();
    var dniAgent = $(inputDniAgent).val();
    var amount = $(inputAmount).val();
    var percent = $(inputPercent).val();
    var exchange_rate = $(inputExchangeRate).val();
    var commission = $(inputCommission).val();
    var observation = $(inputObservation).val();
    $.post(saveSaleRoute, {dniCustomer: dniCustomer, dniAgent: dniAgent,  amount: amount, percent: percent, exchange_rate: exchange_rate, commission: commission, observation: observation, typeSales: typeSales, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
    });
}
*/
