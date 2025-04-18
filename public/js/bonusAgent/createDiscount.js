function createDiscount({ dniAgent, commission, inputObservation, modal, table, typeSales }) {
    const $dni = $(dniAgent);
    const $amount = $(commission);
    const $comment = $(inputObservation);
    const $modal = $(modal);
    const $table = $(table);

    const $alert = $('#alertErrorCreateDescuento');
    const $alertText = $('#alertErrorTextCreateDescuento');

    const code = $dni.val();
    const amount = parseFloat($amount.val()) || 0;
    const observation = $comment.val().trim();

    // Validaciones frontend
    if (!$dni.val()) {
        $alert.removeClass('d-none');
        $alertText.text('Debe ingresar el código del agente.');
        return;
    }

    if (!$dni.prop('readonly')) {
        $alert.removeClass('d-none');
        $alertText.text('Debe buscar y confirmar al agente antes de continuar.');
        return;
    }

    if (!$amount.val()) {
        $alert.removeClass('d-none');
        $alertText.text('Debe ingresar un monto.');
        return;
    }

    $alert.addClass('d-none'); // Oculta el error si pasa las validaciones

    // Estado de carga
    const $btn = $(`${modal} .btn-info`);
    $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Guardando...');

    $.post(saveRetiroRoute, {
        dniAgent: code,
        amount: amount * -1,
        observation: observation,
        _token: token,
        typeSales: typeSales,
    })
    .done(function (response) {
        mostrarMensaje(response.title, response.text, response.status);
        if (response.status === 'success') {
            $modal.modal('hide');
            filterBonus('#area', '#inputCode', '#date_added_init', '#date_added_end', '#tabBonus');
            // Limpieza manual
            resetAgentModalInputs({
                modalSelector: modal,
                inputCodeSelector: dniAgent,
                inputNameSelector: '#nameDiscountAgent',
                buttonSelector: '.ladda-button-agent-create-descuento',
                alertSelector: '#alertErrorCreateDescuento'
            });

            document.querySelector(commission).value = '';
            document.querySelector(inputObservation).value = '';
        }
    })
    .fail(function (xhr) {
        mostrarMensaje('Error', 'No se pudo guardar el descuento.', 'error');
        console.error(xhr);
    })
    .always(function () {
        $btn.prop('disabled', false).html('<i class="fa fa-save"></i> Guardar');
    });
}

