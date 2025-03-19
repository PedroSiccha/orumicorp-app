function searchGeneral(options) {
    var customerStatusId = options.customerStatusId !== undefined ? $(options.customerStatusId).val(): '';
    var dateInit = options.dateInit !== undefined ? $(options.dateInit).val(): '';
    var dateEnd = options.dateEnd !== undefined ? $(options.dateEnd).val(): '';
    var data = options.data !== undefined ? $(options.data).val(): '';
    var tableName = options.tableName !== undefined ? options.tableName: '';

    var dateInitInput = $(options.dateInit);
    var limit = $('#limit').val();

    // Restablecer el borde por si se corrige el error después
    dateInitInput.css('border', '');

    if (dateEnd != '' && dateInit == '') {
        dateInitInput.css('border', '2px solid red');
        dateInitInput.focus();
        return;
    }

    $('#dateInitSearchGeneral').on('input', function() {
        if ($(this).val() !== '') {
            $(this).css('border', ''); // Elimina el borde rojo si hay un valor
        }
    });

    $.post(searchGeneralRoute, {customerStatusId: customerStatusId, dateInit: dateInit, dateEnd: dateEnd, data: data, limit: limit, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
    });

}

//Registrar Evento desde perfil del cliente
function saveEventClient(options) {
    var date = options.inputDateEvent !== undefined ? $(options.inputDateEvent).val(): '';
    var nameEvent = options.inputNombreEvent !== undefined ? $(options.inputNombreEvent).val(): '';
    var description = options.inputDescriptionEvent !== undefined ? $(options.inputDescriptionEvent).val(): '';
    var dniClient = options.inputDniClient !== undefined ? $(options.inputDniClient).val(): '';
    var codeAgent = options.inputCodeAgent !== undefined ? $(options.inputCodeAgent).val(): '';
    var hourInit = options.inputHourInit !== undefined ? $(options.inputHourInit).val(): '';
    var hourEnd = options.inputHourEnd !== undefined ? $(options.inputHourEnd).val(): '';
    var idPriority = options.inputIdPriority !== undefined ? $(options.inputIdPriority).val(): '';
    var tableName = options.tableName !== undefined ? options.tableName: '';
    var modal = options.modal !== undefined ? options.modal: '';

    var urlPath = window.location.pathname; // Obtiene "/profileClient/285"
    var idClient = urlPath.split('/').pop();

    // ✅ Obtener fecha actual en la zona horaria "America/Lima"
    let today = new Date();
    let limaTime = new Intl.DateTimeFormat("es-PE", {
        timeZone: "America/Lima",
        year: "numeric",
        month: "2-digit",
        day: "2-digit"
    }).format(today);

    // 🔥 Convertir formato "DD/MM/YYYY" a "YYYY-MM-DD" para comparación
    let [day, month, year] = limaTime.split('/');
    let todayStr = `${year}-${month}-${day}`;

    console.log("📅 selectedDate:", date);
    console.log("📌 today (America/Lima):", todayStr);

    // ✅ Validación de Fecha
    if (date < todayStr) {
        $(modal).modal('hide');
        mostrarMensaje("Error", "No se pueden registrar eventos en una fecha anterior a la actual", "error");
        return;
    }

    $.post(saveEventClientRoute, {idClient: idClient, date: date, nameEvent: nameEvent, description: description, dniClient: dniClient, codeAgent: codeAgent, hourInit: hourInit, hourEnd: hourEnd, idPriority: idPriority, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
    });
}

function updateClientProfile(inputCode, inputName, inputLastName, inputEmail, inputPhone, inputOptionalPhone, inputCountry, tableName) {
    var clientId = getClientIdFromURL();
    var code = $(inputCode).val();
    var name = $(inputName).val();
    var lastname = $(inputLastName).val();
    var email = $(inputEmail).val();
    var phone = $(inputPhone).val();
    var optionalPhone = $(inputOptionalPhone).val();
    var country = $(inputCountry).val();

    $.post(updateClientProfileRoute, {id: clientId, code: code, name: name, lastname: lastname, email: email, phone: phone, optionalPhone: optionalPhone, country: country, _token: token}).done(function(data) {
        $(tableName).empty();
        $(tableName).html(data.view);
        mostrarMensaje(data.title, data.text, data.status);
    });
}

function getClientIdFromURL() {
    var pathArray = window.location.pathname.split('/'); // Divide la URL en partes
    return pathArray[pathArray.length - 1]; // Toma el último elemento (el ID)
}
