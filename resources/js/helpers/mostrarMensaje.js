// resources/js/helpers/mostrarMensaje.js
import Swal from 'sweetalert2';

export function mostrarMensaje({ tipo = 'success', mensaje = 'Operación exitosa' } = {}) {
  if (tipo === 'toast') {
    // Opción tipo Toast con Toastr o SweetAlert2
    Swal.fire({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000,
      icon: 'success',
      title: mensaje,
    });
  } else {
    // Modal normal con icono
    Swal.fire({
      icon: tipo,
      title: mensaje,
    });
  }
}
