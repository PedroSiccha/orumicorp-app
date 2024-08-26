function searchAgent(options) {

    var inputcodeVoiso = options.inputcodeVoiso !== undefined ? options.inputcodeVoiso: '';
    var inputName = options.inputName !== undefined ? options.inputName: '';
    var alertError = options.alertError !== undefined ? options.alertError: '';
    var alertErrorText = options.alertErrorText !== undefined ? options.alertErrorText: '';
    var btnLadda = options.btnLadda !== undefined ? options.btnLadda: '';

    var codeVoiso = $(inputcodeVoiso).val();
    var l = Ladda.create(document.querySelector(btnLadda));
    l.start();
    $.post(searchAgentRoute, {codeVoiso: codeVoiso, _token: token}).done(function(data) {

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
