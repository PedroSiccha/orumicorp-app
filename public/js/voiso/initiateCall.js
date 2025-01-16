function initiateCall(options) {
    var phone = options.phone !== undefined ? options.phone : '';
    var modal = options.modal !== undefined ? options.modal : '';
    var input = options.input !== undefined ? options.input : '';

    $.post(initiateCallRoute, {phone: phone, _token: token}).done(function(data) {
        if (data.errorMessage === 'Agent logged off') {
            alert('Por favor active su sesión');
            mostrarMensaje('VOISO', 'Por favor active su sesión', 'error');
            window.open('https://cc-dal01.voiso.com/users/sign_in', '_blank');
        } else {
            openOrFocusCallPage(data.data, modal, input);
        }
    });
}

var callPage = null;

function openOrFocusCallPage(comunicationId, modal, input) {
    $(input).val(comunicationId);
    $(modal).modal('show');
    if (!callPage || callPage.closed) {
        callPage = window.open('https://cc-dal01.voiso.com/stats', '_blank');
    } else {
        callPage.focus();
    }
}
