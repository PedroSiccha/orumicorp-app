function searchAgent(inputDni, inputName) {
    var dni = $(inputDni).val();
    $.post(searchAgentRoute, {dni: dni, _token: token}).done(function(data) {
        $(inputName).val(data.name);
    });
}
