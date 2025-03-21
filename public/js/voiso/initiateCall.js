var callPage = null;
var checkCallInterval = null; // Variable para almacenar el intervalo

function initiateCall(options) {
    var phone = options.phone !== undefined ? options.phone : '';
    var modal = options.modal !== undefined ? options.modal : '';
    var input = options.input !== undefined ? options.input : '';
    var customerId = options.customerId !== undefined ? options.customerId : '';

    $.post(initiateCallRoute, {phone: phone, customerId: customerId, _token: token}).done(function(data) {
        if (data.errorMessage === 'Agent logged off') {
            mostrarMensaje('VOISO', 'Por favor active su sesión', 'error');
            window.open('https://cc-dal01.voiso.com/users/sign_in', '_blank');
        } else if (data.errorMessage === "Invalid agent's extension or agent login ID") {
            mostrarMensaje('VOISO', 'Revise su código de llamada', 'error');
        } else {
            console.log("DATA RESPONSE", data.data);
            openOrFocusCallPage(phone, token, data.data);
        }
    });
}

function openOrFocusCallPage(phone, token, comunicationId) { 
    var url = 'https://cc-dal01.voiso.com/stats'; // URL de Voiso

    if (!callPage || callPage.closed) {
        callPage = window.open(url, 'VoisoCall', 'width=400,height=600,top=100,left=100,scrollbars=no,resizable=no');
        setTimeout(() => {
            $.post(initiateCallRoute, { phone: phone, _token: token });
        }, 2000);
    } else {
        callPage.focus();
    }
    if (comunicationId) {
        mostrarComentarioModal(comunicationId);    
    }
}

// Función para mostrar el modal de comentario
function mostrarComentarioModal(comunicationId) { 
    $('#idComunication').val(comunicationId);
    $('#modalCrearComentario').modal('show');
}
