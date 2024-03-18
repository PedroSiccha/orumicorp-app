function editarSale(id, client_id, name_client, amount, percent, exchange_rate, comission, agent_id, code_agent, name_agent, observation, modal, inputId, inputIdClient, inputNameClient, inputAmount, inputPercent, inputExchangeRate, inputComission, inputIdAgent, inputCodeAgent, inputNameAgent, inputObservation) {
    $(inputId).val(id);
    $(inputIdClient).val(client_id);
    $(inputNameClient).val(name_client);
    $(inputAmount).val(amount);
    $(inputPercent).val(percent);
    $(inputExchangeRate).val(exchange_rate);
    $(inputComission).val(comission);
    $(inputIdAgent).val(agent_id);
    $(inputNameAgent).val(name_agent);
    $(inputObservation).val(observation);
    $(inputCodeAgent).val(code_agent);
    $(modal).modal('show');
}

function updateSale(options) {
    var eId = options.eId !== undefined ? $(options.eId).val() : '';
    var eIdClient = options.eIdClient !== undefined ? $(options.eIdClient).val() : '';
    var eIdAgent = options.eIdAgent !== undefined ? $(options.eIdAgent).val() : '';
    var eCodAgent = options.eCodAgent !== undefined ? $(options.eCodAgent).val() : '';
    var eAmount = options.eAmount !== undefined ? $(options.eAmount).val() : '';
    var ePercent = options.ePercent !== undefined ? $(options.ePercent).val() : '';
    var eTypeChange = options.eTypeChange !== undefined ? $(options.eTypeChange).val() : '';
    var eComission = options.eComission !== undefined ? $(options.eComission).val() : '';
    var eObservation = options.eObservation !== undefined ? $(options.eObservation).val() : '';
    var modal = options.modal !== undefined ? options.modal : '';
    var tableName = options.tableName !== undefined ? options.tableName : '';
    var typeSales = options.typeSales !== undefined ? options.typeSales : '';
    $.post(updateSaleRoute, {eId: eId, eIdClient: eIdClient, eCodAgent: eCodAgent, eIdAgent: eIdAgent, eAmount: eAmount, ePercent: ePercent, eTypeChange: eTypeChange, eComission: eComission, eObservation: eObservation, typeSales: typeSales, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
    });
}
