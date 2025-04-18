function createTarget(inputTarget, inputDni, modal, tableName) {
    var amount = $(inputTarget).val();
    var dni = $(inputDni).val();
    $.post(saveTargetRoute, {amount: amount, dni: dni, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
    });
}

function createTargetV2({ inputDni, inputName, inputAmount, alertError, alertErrorText, modal, divTarget, tabTarget, tabTotalTarget }) {
    const code = document.querySelector(inputDni).value.trim();
    const name = document.querySelector(inputName).value.trim();
    const amount = parseFloat(document.querySelector(inputAmount).value);

    const $alert = document.querySelector(alertError);
    const $alertText = document.querySelector(alertErrorText);
    const $modal = $(modal); // sigue siendo necesario para cerrar modal
    const $btn = document.querySelector(`${modal} .btn-info`);

    // Validaciones
    if (!code || !name || !amount || isNaN(amount) || amount <= 0) {
        $alert.classList.remove('d-none');
        $alertText.textContent = 'Completa todos los campos correctamente antes de guardar.';
        return;
    }
    $alert.classList.add('d-none');

    // Loader en botón
    $btn.disabled = true;
    $btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Guardando...';

    fetch(saveTargetRoute, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({
            dni: code,
            amount: amount
        })
    })
    .then(response => response.json())
    .then(data => {
        mostrarMensaje(data.title, data.text, data.status);

        if (data.status === 'success') {
            $modal.modal('hide');

            // Actualizar parciales
            // document.querySelector(divTarget).innerHTML = data.viewDiv;
            // document.querySelector(tabTarget).innerHTML = data.viewTable;
            // document.querySelector(tabTotalTarget).innerHTML = data.viewTotal;

            // Limpiar campos
            document.querySelector(inputDni).value = '';
            document.querySelector(inputName).value = '';
            document.querySelector(inputAmount).value = '';

            const btnSearch = document.querySelector('.ladda-button-agent-registrar-target');
            btnSearch.classList.remove('btn-danger');
            btnSearch.classList.add('btn-primary');
            btnSearch.innerHTML = '<i class="fa fa-search"></i>';
            btnSearch.setAttribute('data-mode', 'search');
            document.querySelector(inputDni).readOnly = false;
            filterBonus('#area', '#inputCode', '#date_added_init', '#date_added_end', '#tabBonus');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarMensaje('Error', 'Ocurrió un error al registrar el target.', 'error');
    })
    .finally(() => {
        $btn.disabled = false;
        $btn.innerHTML = '<i class="fa fa-save"></i> Guardar';
    });
}
