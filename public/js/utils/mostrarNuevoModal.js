function mostrarNuevoModal(modal) {
    $(modal).modal('show');
    const baja = document.querySelector('#priority_id option[value="1"]');
    if (baja) baja.disabled = false;
}
