function asignarAgentePorPerfil(id, cliente, modal, inputId, inputName) {
    $(inputId).val(id);
    $(inputName).val(cliente);
    $(modal).modal('show');
}

function guardarAsignacionAgentePorPerfil(inputId, inputDni, modal, tableName) {
    var id = $(inputId).val();
    var dni_agent = $(inputDni).val();
    $.post(asignAgentByProfileRoute, {id: id, dni_agent: dni_agent, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
    });
}
