@extends('layouts.app')

@section('title')
      Task
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div id="task"></div>

    <button class="btn btn-info " type="button" data-toggle="modal" data-target="#modalRegistrarEvento"><i class="fa fa-calendar"></i> Crear Evento</button>

    @include('task.modal.modalRegistrarEvento')
</div>
@endsection
@section('script')
<script src="{{ asset('js/calendar/script.js') }}"></script>
<script src="{{ asset('js/customer/searchClient.js') }}"></script>
<script src="{{asset('js/agent/searchAgent.js')}}"></script>
<script src="{{ asset('js/customer/uploadExcel.js') }}"></script>
<script src="{{ asset('js/task/saveEvent.js') }}"></script>
<script src="{{ asset('js/task/editEvent.js') }}"></script>
<script src="{{ asset('js/task/deleteEvent.js') }}"></script>
<script src="{{ asset('js/utils/mostrarMensaje.js') }}"></script>
<script src="{{ asset('js/task/getEventById.js') }}"></script>
<script>
    var searchClientRoute = '{{ route("searchCustomer") }}';
    var uploadExcelRoute = '{{ route("uploadExcel") }}';
    var saveEventRoute = '{{ route("saveEvent") }}';
    var editEventRoute = '{{ route("editEvent") }}'; 
    var deleteEventRoute = '{{ route("deleteEvent") }}';
    var getEventByIdRoute = '{{ route("getEventById") }}';
    var searchAgentRoute = '{{ route("searchAgent") }}';
    var token = '{{ csrf_token() }}';
  </script>
  <script src='https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js'></script>
  <script src="{{ asset('js/task/task.js') }}" defer></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
        markNotificationsAsSeen('task');
    });
</script>
@endsection
