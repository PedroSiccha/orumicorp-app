function saveConfigTable(inputDateInit, inputCode, inputPhone, inputOptionalPhone, inputEmail, inputCity, inputCountry, inputComment, modal, tableName) {

    var configTablesDateInit = $(inputDateInit).is(':checked');
    var configTablesCode = $(inputCode).is(':checked');
    var configTablesPhone = $(inputPhone).is(':checked');
    var configTablesOptionalPhone = $(inputOptionalPhone).is(':checked');
    var configTablesEmail = $(inputEmail).is(':checked');
    var configTablesCity = $(inputCity).is(':checked');
    var configTablesCountry = $(inputCountry).is(':checked');
    var configTablesComment = $(inputComment).is(':checked');

    $.post( saveConfigTableRoute, {configTablesDateInit: configTablesDateInit, configTablesCode: configTablesCode, configTablesPhone: configTablesPhone, configTablesOptionalPhone: configTablesOptionalPhone, configTablesEmail: configTablesEmail, configTablesCity: configTablesCity, configTablesCountry: configTablesCountry, configTablesComment: configTablesComment, _token: token}).done(function(data) {

        $(tableName).empty();
        $(tableName).html(data.view);
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);

    });
}
