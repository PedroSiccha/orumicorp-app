document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('task');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        headerToolbar: {
            left: 'prev, next, today',
            center: 'title',
            right: 'dayGridMonth, timeGridWeek, listWeek'
        },
        dateClick: function (info) {
            // ✅ Obtener fecha actual con zona horaria "America/Lima"
            let today = new Date();
            let limaTime = new Intl.DateTimeFormat("es-PE", {
                timeZone: "America/Lima",
                year: "numeric",
                month: "2-digit",
                day: "2-digit"
            }).format(today);

            // 🔥 Convertir formato de "DD/MM/YYYY" a "YYYY-MM-DD" para comparar correctamente
            let [day, month, year] = limaTime.split('/');
            let todayStr = `${year}-${month}-${day}`;

            let selectedDate = info.dateStr; // FullCalendar ya lo da en "YYYY-MM-DD"

            console.log("selectedDate:", selectedDate);
            console.log("today (America/Lima):", todayStr);

            // ✅ Comparar correctamente las fechas
            if (selectedDate >= todayStr) {
                $("#modalRegistrarEvento").modal("show");
                $("#dateEvent").val(info.dateStr);
            } else {
                mostrarMensaje("Error", "No se puede programar en una fecha anterior a la actual", "error");
            }
        },
        eventClick: function (info) {
            getEventById(info.event.id, 'modalRegistrarEvento');
        },
        events: '/obtenerEventos',
        eventContent: function (arg) {
            // ✅ Obtener fecha actual en zona horaria "America/Lima"
            let today = new Date();
            let limaTime = new Intl.DateTimeFormat("es-PE", {
                timeZone: "America/Lima",
                year: "numeric",
                month: "2-digit",
                day: "2-digit"
            }).format(today);

            let [day, month, year] = limaTime.split('/');
            let todayStr = `${year}-${month}-${day}`;

            let eventDate = arg.event.start.toISOString().split('T')[0];

            let eventBackgroundColor = eventDate >= todayStr ? arg.event.backgroundColor : 'btn-default';

            if (eventBackgroundColor == 'btn-default') {
                mostrarMensaje("Alert", "Tiene eventos vencidos", "info");
            }

            return {
                html: `<div class="fc-event-start fc-event-end fc-event-today fc-daygrid-event fc-daygrid-dot-event ${eventBackgroundColor}" 
                style="width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;">
                    ${arg.event.title}
                </div>`
            };
        }
    });

    calendar.render();
});
