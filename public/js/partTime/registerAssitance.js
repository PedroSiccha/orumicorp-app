function registerAssitance(date, inputObservation, type, tabButton, tableName, modal) {
    const now = new Date();
    const hours = now.getHours().toString().padStart(2, '0');
    const minutes = now.getMinutes().toString().padStart(2, '0');
    const seconds = now.getSeconds().toString().padStart(2, '0');
    const timeString = `${hours}:${minutes}:${seconds}`;

    var observation = $(inputObservation).val();

    $.post(registerAssitanceRoute, {hour: timeString, date: date, type: type,  observation: observation, _token: token}).done(function(data) {
        $(tabButton).empty();
        $(tabButton).html(data.view);
        $(tableName).empty();
        $(tableName).html(data.viewTable);
        $(modal).modal('hide');
        Swal.fire({
            title: data.title,
            text: data.text,
            icon: data.status
        });
    });
}
