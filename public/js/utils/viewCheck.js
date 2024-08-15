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
        } else {
            $('#asignarBtn').hide();
            $('#changeStatusBtn').hide();
        }
    });
});
