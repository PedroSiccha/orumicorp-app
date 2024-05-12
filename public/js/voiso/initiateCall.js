function initiateCall(options) {
    var phone = options.phone !== undefined ? options.phone : '';

    $.post(initiateCallRoute, {phone: phone, _token: token}).done(function(data) {
        if (data.errorMessage === 'Agent logged off') {
            alert('Por favor active su sesión');
            window.open('https://cc-dal01.voiso.com/users/sign_in', '_blank');
        } else {
            openOrFocusCallPage();
        }
    });
}

var callPage = null;

function openOrFocusCallPage() {
    if (!callPage || callPage.closed) {
        callPage = window.open('https://cc-dal01.voiso.com/stats', '_blank');
    } else {
        callPage.focus();
    }
}
