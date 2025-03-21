// function filterAgent(inputArea, inputCode, inputDateInit, inputDateEnd, tableName) {
//     var area = $(inputArea).val();
//     var dateInit = $(inputDateInit).val();
//     var dateEnd = $(inputDateEnd).val();
//     var code = $(inputCode).val();
//     $.post(filterAgentRoute, {area: area, code: code, dateInit: dateInit,  dateEnd: dateEnd, _token: token}).done(function(data) {
//         $(tableName).empty();
//         $(tableName).html(data.view); 
//     });
// }
let filterTimeout; // Variable para evitar múltiples ejecuciones

function filterAgent(inputArea, inputCode, inputDateInit, inputDateEnd, tableName) {
    clearTimeout(filterTimeout); // Cancela ejecuciones previas

    filterTimeout = setTimeout(function () {
        var area = $(inputArea).val();
        var dateInit = $(inputDateInit).val();
        var dateEnd = $(inputDateEnd).val();
        var code = $(inputCode).val();

        console.log("Ejecutando filterAgent con filtros:", { area, code, dateInit, dateEnd });

        $.post(filterAgentRoute, {
            area: area,
            code: code,
            dateInit: dateInit,
            dateEnd: dateEnd,
            _token: token
        }).done(function (data) {
            $(tableName).empty();
            $(tableName).html(data.view);
        });
    }, 300); // Solo se ejecuta después de 300ms sin actividad
}

