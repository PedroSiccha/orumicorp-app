function editCustomenStatus(options) { 

    var modal = options.modal !== undefined ? options.modal : '';
    var id = options.id !== undefined ? options.id : '';
    var name = options.name !== undefined ? options.name : '';
    var inputId = options.inputId !== undefined ? options.inputId : '';
    var inputName = options.inputName !== undefined ? options.inputName : '';

    $(inputId).val(id);
    $(inputName).val(name);

    $(modal).modal('show');
}

function updateCustomerStatus(options) {
    var modal = options.modal !== undefined ? options.modal : '';
    var tableName = options.tableName !== undefined ? options.tableName : '';
    var id = options.idCustomerStatus !== undefined ? $(options.idCustomerStatus).val() : '';
    var name = options.editNameCustomerStatus !== undefined ? $(options.editNameCustomerStatus).val() : '';
    $.post(updateCustomerStatusRoute, { id: id, name: name, _token: token }).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
    })
}
