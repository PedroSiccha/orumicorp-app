@extends('layouts.app')

@section('title')
      Task
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row mb-5" id="tabCategoria">
      <div class="container">
        <div class="left">
          <div class="calendar">
            <div class="month">
              <i class="fa fa-angle-left prev"></i>
              <div class="date">Mayo 2023</div>
              <i class="fa fa-angle-right next"></i>
            </div>
            <div class="weekdays">
              <div>Dom</div>
              <div>Lun</div>
              <div>Mar</div>
              <div>Mie</div>
              <div>Jue</div>
              <div>Vie</div>
              <div>Sab</div>
            </div>
            <div class="days"></div>
            <div class="goto-today">
              <div class="goto">
                <input type="text" placeholder="mm/yyyy" class="date-input" />
                <button class="goto-btn">Ir</button>
              </div>
              <button class="today-btn">Hoy</button>
            </div>
          </div>
        </div>
        <div class="right">
          <div class="today-date">
            <div class="event-day">Mie</div>
            <div class="event-date">27 mayo 2023</div>
          </div>
          <div class="events"></div>
          <div class="add-event-wrapper">
            <div class="add-event-header">
              <div class="title">Agregar Evento</div>
              <i class="fa fa-times close"></i>
            </div>
            <div class="add-event-body">
              <div class="add-event-input">
                <input type="text" placeholder="Nombre del evento" class="event-name" id="nombreEvento"/>
              </div>
              <div class="add-event-input">
                <input type="text" placeholder="Descripción del evento" class="event-descripcion" id="descripcionEvento"/>
              </div>
              <div class="add-event-input">
                <input type="file" placeholder="Imagen del evento" class="event-img" id="imgEvento"/>
              </div>
              <div class="add-event-input">
                <input type="text" placeholder="Desde" class="event-time-from" id="horaInicio"/>
              </div>
              <div class="add-event-input">
                <input type="text" placeholder="Hasta" class="event-time-to" id="horaFin"/>
              </div>
            </div>
            <div class="add-event-footer">
              <button class="add-event-btn" onclick="guardarEvento()">Agregar Evento</button>
            </div>
          </div>
        </div>
        <button class="add-event">
          <i class="fa fa-plus"></i>
        </button>
      </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('js/calendar/script.js') }}"></script>
<script>

    function guardarEvento() {
      var formData = new FormData();
      var fecha = $(".event-date").text();
      var titulo = $("#nombreEvento").val();
      var descripcion = $("#descripcionEvento").val();
      var horaInicio = $("#horaInicio").val();
      var horaFin = $("#horaFin").val();
      var imgFile = $("#imgEvento")[0].files[0]; // Obtén el archivo de imagen seleccionado

      // Agrega los datos al objeto FormData
      formData.append('fecha', fecha);
      formData.append('titulo', titulo);
      formData.append('descripcion', descripcion);
      formData.append('horaInicio', horaInicio);
      formData.append('horaFin', horaFin);
      formData.append('imgEvento', imgFile);

       // Obtén el token CSRF del campo meta en tu página
      var token = $('meta[name="csrf-token"]').attr('content');
      // Agrega el token CSRF al objeto FormData
      formData.append('_token', token);

      // Realiza la solicitud POST utilizando AJAX
      $.ajax({
        url: "{{ Route('guardarTask') }}",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        success: function(data) {
          if (data.resp == 1) {
            alert('Task registrada correctamente');
          }else{
            alert('Hubo un error');
          }
        },
        error: function(xhr, status, error) {
          //alert(error);
        }
      });
    }
  </script>
@endsection
