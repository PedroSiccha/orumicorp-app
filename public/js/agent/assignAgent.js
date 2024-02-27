function asignarAgente(id, cliente, modal, inputId, inputName) {
    $(inputId).val(id);
    $(inputName).val(cliente);
    $(modal).modal('show');
}

function guardarAsignacionAgente(inputId, inputDni, modal, tableName) {
    var id = $(inputId).val();
    var dni_agent = $(inputDni).val();
    $.post("{{ Route('asignAgent') }}", {id: id, dni_agent: dni_agent, _token: '{{ csrf_token() }}'}).done(function(data) {
        $(modal).modal('hide');
        $(tableName).empty();
        $(tableName).html(data.view);
        if (data.resp == 1) {
            Swal.fire({
                title: "Correcto",
                text: "Se asginó el agente correctamente",
                icon: "success"
            });
        } else {
            Swal.fire({
                title: "Error",
                text: "No se pudo asignar el agente",
                icon: "error"
            });
        }
    });
}
