function getEventById(id, modal) {
    $.post(getEventByIdRoute, {id: id, _token: token}).done(function(data) {
        var start = new Date(data.start);
        var end = new Date(data.end);
        var horaStart = start.getHours();
        var minutosStart = start.getMinutes();
        var horaEnd = end.getHours();
        var minutosEnd = end.getMinutes();
        var timeStart = horaStart + ':' + minutosStart;
        var timeEnd = horaEnd + ':' + minutosEnd;
        console.log(timeStart);
        $('#id').val(data.id);
        $('#dateEvent').val(data.date);
        $('#nombreEvento').val(data.name);
        $('#descripcionEvento').val(data.description);
        $('#dniCustomer').val(data.customer.code);
        $('#nameCustomer').val(data.customer.name + ' ' + data.customer.lastname);
        $('#horaInicio').val(timeStart);
        $('#horaFin').val(timeEnd);
        $('#priority_id').val(data.priority_id);
        console.log('STAR ' + data.start);
        $("#modalRegistrarEvento").modal("show");

    });

}
