$(document).ready(function () {
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });

    $('.i-checks input').on('ifChanged', function () {
        // Verifica si alguna checkbox está seleccionada
        var anyChecked = $('.i-checks input:checked').length > 0;

        if (anyChecked) {
            $('#asignarBtn').show(); // Muestra el botón "Asignar"
        } else {
            $('#asignarBtn').hide(); // Oculta el botón "Asignar"
        }
    });
});
