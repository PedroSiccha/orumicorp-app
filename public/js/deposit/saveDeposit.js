function saveDeposit(options) {
    var codeClient = options.codeClient !== undefined ? $(options.codeClient).val(): '';
    var codeAgent = options.codeAgent !== undefined ? $(options.codeAgent).val(): '';
    var amount = options.amount !== undefined ? $(options.amount).val(): '';
    var codeReceipt = options.codeReceipt !== undefined ? $(options.codeReceipt).val(): '';
    var transaction_type_id = options.transaction_type_id !== undefined ? $(options.transaction_type_id).val(): '';
    var modal = options.modal !== undefined ? options.modal : '';
    var tableName = options.tableName !== undefined ? options.tableName : '';

    $.post(saveDepositRoute, {codeClient: codeClient, codeAgent: codeAgent, transaction_type_id: transaction_type_id, codeReceipt: codeReceipt, amount: amount, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
        $(options.codeClient).val('');
        $(options.codeAgent).val('');
        $(options.amount).val('');
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
    });
}
