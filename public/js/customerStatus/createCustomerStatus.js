function createCustomerStatus(options) {
    var name = options.nameCustomerStatus !== undefined ? $(options.nameCustomerStatus).val(): '';
    var tableName = options.tableName !== undefined ? options.tableName : '';
    var modal = options.modal !== undefined ? options.modal : '';
    $.post(saveCustomerStatusRoute, {name: name, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
        $(options.nameCustomerStatus).val('');
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
    })
}
