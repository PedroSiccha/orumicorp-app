if (typeof window.calendar === 'undefined') {
    window.calendar = null;
}
document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('task');
    window.calendar = new FullCalendar.Calendar(calendarEl, {
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

    window.calendar.render();
});

function limpiarModalEvento() {
    const campos = [
        '#id', '#dateEvent', '#nombreEvento', '#descripcionEvento',
        '#dniCustomer', '#nameCustomer', '#codeAgent', '#nameAgent',
        '#horaInicio', '#horaFin', '#priority_id'
    ];

    campos.forEach(selector => {
        const el = document.querySelector(selector);
        if (el) el.value = '';
    });

    // Restaurar botón visible solo para nuevo evento
    document.getElementById('btnGuardarEvento').style.display = 'inline-block';
    document.getElementById('btnEditarEvento').style.display = 'none';
}

// Mostrar modal para NUEVO evento
function mostrarModalNuevoEvento(fecha) {
    limpiarModalEvento();
    document.getElementById('dateEvent').value = fecha;
    $('#modalRegistrarEvento').modal('show');
}

// Mostrar modal para EDITAR evento existente
function mostrarModalEditarEvento(evento) {
    limpiarModalEvento();
    // Cargar valores desde el evento
    document.getElementById('id').value = evento.id;
    document.getElementById('dateEvent').value = evento.date;
    document.getElementById('nombreEvento').value = evento.name;
    document.getElementById('descripcionEvento').value = evento.description;
    document.getElementById('dniCustomer').value = evento.customer_code;
    document.getElementById('nameCustomer').value = evento.customer_name;
    document.getElementById('codeAgent').value = evento.agent_code;
    document.getElementById('nameAgent').value = evento.agent_name;
    document.getElementById('horaInicio').value = evento.timeStart;
    document.getElementById('horaFin').value = evento.timeEnd;
    document.getElementById('priority_id').value = evento.priority_id;

    // ✅ Mostrar solo botón de editar
    document.getElementById('btnGuardarEvento').style.display = 'none';
    document.getElementById('btnEditarEvento').style.display = 'inline-block';

    $('#modalRegistrarEvento').modal('show');
}

// Limpiar modal al cerrarse
$('#modalRegistrarEvento').on('hidden.bs.modal', limpiarModalEvento);
