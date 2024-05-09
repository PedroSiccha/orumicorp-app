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
            $("#modalRegistrarEvento").modal("show");
            $("#dateEvent").val(info.dateStr);
        },
        events: '/obtenerEventos',
        eventContent: function(arg) {
            console.log("Event", arg.event);
            return {
                html: '<div class="fc-event-start fc-event-end fc-event-today fc-daygrid-event fc-daygrid-dot-event '+arg.event.backgroundColor+'" style="width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;">'+ arg.event.title +'</div>'
            };
        }
    });
    calendar.render();
});
