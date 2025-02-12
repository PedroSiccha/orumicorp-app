function createDiscount(options) {

    var amount = options.commission !== undefined ? $(options.commission).val()*(-1) : '';
    var observation = options.inputObservation !== undefined ? $(options.inputObservation).val() : '';
    var dniAgent = options.dniAgent !== undefined ? $(options.dniAgent).val() : '';
    // alert(amount);

    var modal = options.modal !== undefined ? options.modal : '';
    var table = options.table !== undefined ? options.table : '';

    $.post(saveBonusRoute, {dniCustomer: 0, amount: amount, observation: observation, percent_id: 0, commission_id: 0, exchange_rate_id: 0, dniAgent: dniAgent, _token: token}).done(function(data) {
        $(table).empty();
        $(table).html(data.view);
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
    });
}
