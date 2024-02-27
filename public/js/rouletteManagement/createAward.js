function createAward(inputName, inputDesription, inputValue, inputOrder, modal, tableName) {
    var nombre = $(inputName).val();
    var descripcion = $(inputDesription).val();
    var valor = $(inputValue).val();
    var orden = $(inputOrder).val();
    $.post(savePremioRoute, {nombre: nombre, descripcion: descripcion, valor: valor, orden: orden, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
    });
}
