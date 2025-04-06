// resources/js/partTime/registerAssitance.js
import toastr from 'toastr';

export default function registerAssitance(fecha, inputComentario, tipo, panelButton, tabAssistance, modalId) {
  const comentario = document.querySelector(inputComentario)?.value || '';

  const data = {
    fecha,
    comentario,
    tipo,
    _token: window.token,
  };

  fetch(window.registerAssitanceRoute, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': window.token,
    },
    body: JSON.stringify(data),
  })
    .then(async res => {
      if (!res.ok) {
        const error = await res.text();
        throw new Error(error || 'Error al registrar asistencia');
      }
      return res.json();
    })
    .then(res => {
      if (res.status) {
        toastr.success(res.message);

        // Ocultar modal si aplica
        if (modalId) {
          const modal = bootstrap.Modal.getInstance(document.querySelector(modalId));
          if (modal) modal.hide();
        }

        // Actualizar contenido si se requiere
        if (panelButton && document.querySelector(panelButton)) {
          document.querySelector(panelButton).classList.add('d-none');
        }

        if (tabAssistance && document.querySelector(tabAssistance)) {
          document.querySelector(tabAssistance).innerHTML = res.html ?? '';
        }

      } else {
        toastr.error(res.message || 'Ocurrió un error');
      }
    })
    .catch(error => {
      console.error('Error al registrar asistencia:', error);
      toastr.error('No se pudo registrar la asistencia');
    });
}
