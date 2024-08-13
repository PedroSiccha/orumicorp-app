function assignGroupAgent(inputId, inputDni, modal, tableName) {
    var idGroupClientes = [];
    var dni_agent = $(inputDni).val();
    $('.chekboxses:checked').each(
        function() {
            idGroupClientes.push($(this).val());
        }
    );
    // console.log('idGroupClientes', idGroupClientes);
    $.post(assignGroupAgentRoute, {idGroupClientes: idGroupClientes, dni_agent: dni_agent, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
    });
}
