$(document).ready(function () {
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });

    $('.i-checks input').on('ifChanged', function () {
        var anyChecked = $('.i-checks input:checked').length > 0;

        if (anyChecked) {
            $('#asignarBtn').show();
            $('#changeStatusBtn').show();
            $('#liberarClienteBtn').show();
            $('#asignarFolderBtn').show();
            $('#changeFolderBtn').show();
        } else {
            $('#asignarBtn').hide();
            $('#changeStatusBtn').hide();
            $('#liberarClienteBtn').hide();
            $('#asignarFolderBtn').hide();
            $('#changeFolderBtn').hide();
        }
    });

    $('#selectAllCheckboxes').on('ifClicked', function () {
        var isChecked = $(this).is(':checked');
        if (isChecked) {
            $('.chekboxses').iCheck('uncheck');
        } else {
            $('.chekboxses').iCheck('check');
        }
    });

    // Sincronización del checkbox principal cuando se seleccionan o deseleccionan checkboxes individuales
    $('.chekboxses').on('ifChanged', function () {
        var allChecked = $('.chekboxses:checked').length === $('.chekboxses').length;
        $('#selectAllCheckboxes').iCheck(allChecked ? 'check' : 'uncheck');
    });
});
