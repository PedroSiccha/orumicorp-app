// resources/js/partTime/registerAssitance.js
import Swal from 'sweetalert2';

export default function registerAssistance(date, inputObservation, type, tabButton, tableName, modalId) {
    const now = new Date();
    const timeString = now.toLocaleTimeString('es-PE', { hour12: false });
    const observation = document.querySelector(inputObservation)?.value || '';

    const data = {
        hour: timeString,
        date,
        type,
        observation,
    };

    fetch(window.registerAssitanceRoute, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json', // <- Esto le dice a Laravel que espere JSON
            'X-CSRF-TOKEN': window.token
        },
        body: JSON.stringify(data)
    })
    .then(async (res) => {
        if (!res.ok) throw await res.json();
        return res.json();
    })
    .then(response => {
        if (tabButton && response.view)
            document.querySelector(tabButton).innerHTML = response.view;

        if (tableName && response.viewTable)
            document.querySelector(tableName).innerHTML = response.viewTable;

        const modal = document.querySelector(modalId);
        if (modal) {
        const modalInstance = bootstrap.Modal.getInstance(modal) || new bootstrap.Modal(modal);

        // Escuchar cuando termine de ocultarse
        modal.addEventListener('hidden.bs.modal', function onModalHidden() {
            Swal.fire({
            title: response.title,
            text: response.text,
            icon: response.status
            });

            modal.removeEventListener('hidden.bs.modal', onModalHidden); // Limpieza del listener
        });

        modalInstance.hide(); // Cierra el modal con animación
        }

    })
    .catch(error => {
        const modal = document.querySelector(modalId);
        if (modal) {
        const modalInstance = new bootstrap.Modal(modal);
        modalInstance.hide();
        }

        Swal.fire({
            title: error?.title || 'Error inesperado',
            text: error?.text || 'No se pudo registrar tu asistencia. Intenta nuevamente.',
            icon: error?.status || 'error'
        });
    });
}