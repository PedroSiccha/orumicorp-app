function createVacations(options) {
    var dateInitVacations = options.dateInitVacations !== undefined ? $(options.dateInitVacations).val() : '';
    var dateEndVacations = options.dateEndVacations !== undefined ? $(options.dateEndVacations).val() : '';
    var modal = options.modal !== undefined ? options.modal : '';
    var tabAssistance = options.tabAssistance !== undefined ? options.tabAssistance : '';

    $.post(registerVacationsRoute, {dateInitVacations: dateInitVacations, dateEndVacations: dateEndVacations, _token: token}).done(function(data) {
        $(tabAssistance).empty();
        $(tabAssistance).html(data.view);
        $(modal).modal('hide');
        mostrarMensaje(data.title, data.text, data.status);
    });
}
