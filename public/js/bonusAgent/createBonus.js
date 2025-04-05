// function createBonus(options) {

//     var amount = options.commission !== undefined ? $(options.commission).val() : '';
//     var observation = options.inputObservation !== undefined ? $(options.inputObservation).val() : '';
//     var dniAgent = options.dniAgent !== undefined ? $(options.dniAgent).val() : '';

//     var modal = options.modal !== undefined ? options.modal : '';
//     var table = options.table !== undefined ? options.table : '';

//     $.post(saveBonusRoute, {dniCustomer: 0, amount: amount, observation: observation, percent_id: 0, commission_id: 0, exchange_rate_id: 0, dniAgent: dniAgent, _token: token}).done(function(data) {
//         $(table).empty();
//         $(table).html(data.view);
//         $(modal).modal('hide');
//         mostrarMensaje(data.title, data.text, data.status);
//     });
// }

function createBonus(options) {
    const code = $(options.dniAgent).val();
    const name = $(options.inputName).val();
    const amount = $(options.commission).val();
    const observation = $(options.inputObservation).val();

    const $alert = $(options.alertError);
    const $alertText = $(options.alertErrorText);
    const $modal = $(options.modal);
    const $table = $(options.table);

    if (!code || !name || !amount || isNaN(amount) || parseFloat(amount) <= 0) {
        $alert.removeClass('d-none');
        $alertText.text('Completa todos los campos correctamente antes de guardar.');
        return;
    }

    $alert.addClass('d-none');

    const btn = $(`${options.modal} .btn-info`);
    btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Guardando');

    $.post(saveBonusRoute, {
        dniAgent: code,
        amount: amount,
        observation: observation,
        percent_id: 0,
        commission_id: 0,
        exchange_rate_id: 0,
        _token: token
    })
    .done(function (response) {
        mostrarMensaje(response.title, response.text, response.status);
        if (response.status === 'success') {
            $modal.modal('hide');
            filterBonus('#area', '#inputCode', '#date_added_init', '#date_added_end', '#tabBonus');
            // Limpieza manual
            resetAgentModalInputs({
                modalSelector: options.modal,
                inputCodeSelector: options.dniAgent,
                inputNameSelector: options.inputName,
                buttonSelector: '.ladda-button-agent-create-bonus',
                alertSelector: options.alertError
            });
            
            document.querySelector(options.commission).value = '';
            document.querySelector(options.inputObservation).value = '';
            
        }
    })
    .fail(function (xhr) {
        mostrarMensaje('Error', 'No se pudo guardar el descuento.', 'error');
        console.error(xhr);
    })
    .always(function () {
        btn.prop('disabled', false).html('<i class="fa fa-save"></i> Guardar');
    });
}

function resetAgentModalInputs({
    modalSelector,
    inputCodeSelector,
    inputNameSelector,
    buttonSelector,
    alertSelector
}) {
    const modal = document.querySelector(modalSelector);
    const inputCode = modal.querySelector(inputCodeSelector);
    const inputName = modal.querySelector(inputNameSelector);
    const button = modal.querySelector(buttonSelector);
    const alert = modal.querySelector(alertSelector);

    // Reset campos
    if (inputCode) {
        inputCode.value = '';
        inputCode.readOnly = false;
    }

    if (inputName) {
        inputName.value = '';
    }

    // Reset botón
    if (button) {
        button.classList.remove('btn-danger');
        button.classList.add('btn-primary');
        button.innerHTML = '<i class="fa fa-search"></i>';
        button.dataset.mode = 'search';
        button.disabled = false;
    }

    // Oculta alerta si hay
    if (alert) {
        alert.classList.add('d-none');
    }
}
