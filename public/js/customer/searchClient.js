function searchClient(options) {
    var inputDni = options.inputDni !== undefined ? options.inputDni: '';
    var inputName = options.inputName !== undefined ? options.inputName: '';
    var alertError = options.alertError !== undefined ? options.alertError: '';
    var alertErrorText = options.alertErrorText !== undefined ? options.alertErrorText: '';
    var btnLadda = options.btnLadda !== undefined ? options.btnLadda: '';
    var limit = $('#limit').val();

    var dni = $(inputDni).val();
    var l = Ladda.create(document.querySelector(btnLadda));
    l.start();
    $.post(searchClientRoute, {dni: dni, limit: limit, _token: token})
        .done(function(data) {
            if (data.name) {
                $(inputName).val(data.name);
                $(alertError).addClass('d-none');
            } else {
                $(alertErrorText).text(data.text);
                $(alertError).removeClass('d-none');
            }
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            $(alertErrorText).text('Ocurrió un error en la búsqueda. Por favor, inténtalo de nuevo.');
            $(alertError).removeClass('d-none');
        })
        .always(function() {
            l.stop();
        });
}
