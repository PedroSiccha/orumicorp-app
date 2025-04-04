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

function searchAgentV2({ inputcodeVoiso, inputName, alertError, alertErrorText, btnLadda }) {
    const $inputCode = $(inputcodeVoiso);
    const $inputName = $(inputName);
    const $btn = $(btnLadda);
    const code = $inputCode.val();

    const isClearMode = $btn.data('mode') === 'clear';

    if (isClearMode) {
        // Resetear
        $inputCode.prop('readonly', false).val('');
        $inputName.val('');
        $btn.removeClass('btn-danger').addClass('btn-primary');
        $btn.html('<i class="fa fa-search"></i>');
        $btn.data('mode', 'search');
        $btn.prop('disabled', false);

         // Asegurarse que la alerta también desaparezca si estaba visible
        $(alertError).addClass('d-none');
        $(alertErrorText).text('');
        return;
    }

    // Mostrar loader y desactivar botón
    $btn.prop('disabled', true);
    $btn.html('<i class="fa fa-spinner fa-spin"></i>');

    // Buscar agente
    $.post(searchAgentRoute, { codeVoiso: code, _token: token })
        .done(function (data) {
            if (data.status === "success") {
                $(alertError).addClass('d-none');
                $inputName.val(data.name);
                $inputCode.prop('readonly', true);

                $btn.removeClass('btn-primary').addClass('btn-danger');
                $btn.html('<i class="fa fa-close"></i>');
                $btn.data('mode', 'clear');
            } else {
                $(alertError).removeClass('d-none');
                $(alertErrorText).text(data.text || 'Agente no encontrado.');
                $inputName.val('');

                $btn.removeClass('btn-danger').addClass('btn-primary');
                $btn.html('<i class="fa fa-search"></i>');
                $btn.data('mode', 'search');
                $btn.prop('disabled', false);
            }
        })
        .fail(function () {
            $(alertError).removeClass('d-none');
            $(alertErrorText).text('Error al buscar el agente.');
            $btn.html('<i class="fa fa-search"></i>');
            $btn.prop('disabled', false);
        })
        .always(function () {
            // Habilitar de nuevo si no se va a limpiar
            // if ($btn.data('mode') !== 'clear') {
                $btn.prop('disabled', false);
            // }
        });
}
