function sendMail(options) {
    var modal = options.modal !== undefined ? options.modal: '';
    var customerId = options.customerId !== undefined ? options.customerId: '';
    var email = options.email !== undefined ? options.email: '';

    $('#idCustomerSendMail').val(customerId);
    $('#imputMail').val(email);

    $(modal).modal('show');
}

function enviarCorreo(options) {
    var modal = options.modal !== undefined ? options.modal: '';
    var clienteId = options.clienteId !== undefined ? $(options.clienteId).val(): '';
    var email = options.email !== undefined ? $(options.email).val(): '';
    var mensaje = options.mensaje !== undefined ? $(options.mensaje).val(): '';
    var asunto = options.asunto !== undefined ? $(options.asunto).val(): '';

    $.post(sendMailRoute, {clienteId: clienteId, email: email, mensaje: mensaje, asunto: asunto, _token: token}).done(function(data) {
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
    });

}
