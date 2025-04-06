// resources/js/features/getNotify.js
import toastr from 'toastr';

function initiateCall({ phone, modal, input }) {
  console.log('Llamando a:', phone);
  // Aquí va tu lógica real (puedes abrir modal, setear input, etc.)
  if (modal) $(modal).modal('show'); // o usa alternativa sin jQuery si migras todo
  if (input) document.querySelector(input).value = phone;
}

export function getNotifyShooter() {
  if (typeof notiffyShooterRoute === 'undefined' || typeof token === 'undefined') {
    console.error('Error: notiffyShooterRoute o token no están definidos.');
    return;
  }

  fetch(notiffyShooterRoute, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': token,
    },
    body: JSON.stringify({}),
  })
    .then(res => res.json())
    .then(data => {
      if (data.shooter === '1') {
        toastr.options.onclick = () => {
          initiateCall({
            phone: data.phone,
            modal: '#modalCrearComentario',
            input: '#idComunication',
          });
        };

        toastr[data.type](data.message);
      }
    })
    .catch(err => {
      console.error('Error en la petición AJAX:', err);
    });
}

// Llamada inicial e intervalo cada 15 segundos
export function initNotifyShooterPolling() {
  getNotifyShooter();
  setInterval(getNotifyShooter, 15000);
}
