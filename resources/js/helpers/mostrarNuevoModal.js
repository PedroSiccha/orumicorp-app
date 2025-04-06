// resources/js/helpers/mostrarNuevoModal.js
export default function mostrarNuevoModal(selector) {
    const modalElement = document.querySelector(selector);
    if (!modalElement) {
      console.warn(`Modal no encontrado: ${selector}`);
      return;
    }
  
    const modal = new bootstrap.Modal(modalElement);
    modal.show();
  }
  