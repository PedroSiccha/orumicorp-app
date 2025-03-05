document.getElementById("typeRange").addEventListener("change", function() {
    this.classList.remove("border-danger");
});

function filterAdvanced(options) {
    var filterFor = options.buttonFilter !== undefined ? $(options.buttonFilter).text(): '';
    var inputName = options.inputFilter !== undefined ? $(options.inputFilter).val(): '';
    var statusId = options.selectStatus !== undefined ? $(options.selectStatus).val(): '';
    var typeRange = options.selectTypeRange !== undefined ? $(options.selectTypeRange).val(): '';
    var dateInit = options.dateInit !== undefined ? $(options.dateInit).val(): '';
    var dateEnd = options.dateEnd !== undefined ? $(options.dateEnd).val(): '';
    var tableName = options.tableName !== undefined ? options.tableName : '';

    var formattedDateInit = convertDateFormat(dateInit);
    var formattedDateEnd = convertDateFormat(dateEnd);
    let elemtnTypeRange = document.getElementById("typeRange");

    if (dateInit || dateEnd) {
        if (elemtnTypeRange.value === "Seleccione Rango:") {
            elemtnTypeRange.classList.add("border-danger");
            return;
        }
    }

    var limit = $('#limit').val();

     // ✅ 1. Mostrar el Skeleton Loader antes de realizar la petición
     $("#skeleton-loader").show();  // Mostrar el esqueleto
     $(tableName).hide();  // Ocultar la tabla real mientras se cargan los datos
     $(tableName).closest('.ibox-content').addClass('sk-loading');

    $.post(filterAdvancedRoute, {filterFor: filterFor, inputName: inputName, statusId: statusId, typeRange: typeRange, dateInit: formattedDateInit, dateEnd: formattedDateEnd, limit: limit, _token: token}).done(function(data) {
        // $(tableName).empty();
        // $(tableName).html(data.view);
        $("#skeleton-loader").hide();  
        $(tableName).empty().html(data.view).show();
    }).fail(function() {
        // Mostrar un mensaje de error si falla
        // $(tableName).empty();
        // $(tableName).html('<p style="text-align: center; color: red;">SIN DATOS.</p>');
        $("#skeleton-loader").hide();
        $(tableName).empty().html('<p style="text-align: center; color: red;">SIN DATOS.</p>').show();
    }).always(function() {
        // Desactivar spinner al completar la petición
        $(tableName).closest('.ibox-content').removeClass('sk-loading');
    });

}

// 🔹 Función para convertir fechas de DD/MM/YYYY a YYYY-MM-DD
function convertDateFormat(dateStr) {
    if (!dateStr) return ''; // Si la fecha está vacía, devolver una cadena vacía

    var parts = dateStr.split('/');
    if (parts.length !== 3) return ''; // Verificar que la fecha tenga el formato correcto

    return `${parts[2]}-${parts[1]}-${parts[0]}`; // Formato YYYY-MM-DD
}
