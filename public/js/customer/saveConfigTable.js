function asignarPermisoRol() {

    var rol_id = $('#idRol').val();
    var idPermiso=[];

    $('.chekboxses:checked').each(
        function() {
            idPermiso.push($(this).val());
        }
    );

    $.post( "{{ Route('asignarPermisoRol') }}", {idPermiso: idPermiso, rol_id: rol_id, _token:'{{csrf_token()}}'}).done(function(data) {});
}
