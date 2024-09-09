document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('task');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        headerToolbar: {
            left: 'prev, next, today',
            center: 'title',
            right: 'dayGridMonth, timeGridWeek, listWeek'
        },
        dateClick: function(info) {

            var today = new Date();
            var selectedDate = new Date(info.dateStr);

            if (selectedDate > today) {
                $("#modalRegistrarEvento").modal("show");
                $("#dateEvent").val(info.dateStr);
            } else {
                mostrarMensaje("Error", "No se puede programar en una fecha anterior a la actual", "error");
            }

        },
        eventClick: function (info) {
            //mostrarMensaje("Event", info.event, "success");
            getEventById(info.event.id, 'modalRegistrarEvento');
            //console.log(info.event.id);
            //$("#modalRegistrarEvento").modal("show");
        },
        events: '/obtenerEventos',
        eventContent: function(arg) {

            var today = new Date();
            var eventDate = new Date(arg.event.start);
            var eventBackgroundColor = eventDate > today ? arg.event.backgroundColor : 'btn-default';
                if (eventBackgroundColor == 'btn-default') {
                    mostrarMensaje("Alert", "Tiene eventos vencidos", "info");
                }

            return {
                html: '<div class="fc-event-start fc-event-end fc-event-today fc-daygrid-event fc-daygrid-dot-event ' + eventBackgroundColor + '" style="width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;">'+ arg.event.title +'</div>'
            };
        }
    });
    calendar.render();
});
