function searchClient(inputDni, inputName) {
    var dni = $(inputDni).val();
    var l = Ladda.create(document.querySelector('.ladda-button'));
    l.start();
    $.post(searchClientRoute, {dni: dni, _token: token})
        .done(function(data) {
            if (data.name) {
                $(inputName).val(data.name);
                $('#alertError').addClass('d-none');
            } else {
                $('#alertErrorText').text(data.text);
                $('#alertError').removeClass('d-none');
            }
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            $('#alertErrorText').text('Ocurrió un error en la búsqueda. Por favor, inténtalo de nuevo.');
            $('#alertError').removeClass('d-none');
        })
        .always(function() {
            l.stop();
        });
}
