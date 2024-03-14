function searchClient(inputDni, inputName) {
    var dni = $(inputDni).val();
    $.post(searchClientRoute, {dni: dni, _token: token}).done(function(data) {
        $(inputName).val(data.name);
    });
}
