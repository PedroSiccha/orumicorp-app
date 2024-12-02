@extends('layouts.app')
@section('title')
    Mail
@endsection
@section('content')
<div class="row">
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-content mailbox-content">
                <div class="file-manager">
                    <a class="btn btn-block btn-primary compose-mail" onclick="mostrarNuevoModal('#modalCrearMail')">Crear</a>
                    <div class="space-25"></div>
                    <h5>Folders</h5>
                    <ul class="folder-list m-b-md" style="padding: 0">
                        <li><a href="{{ route('mail') }}"> <i class="fa fa-inbox "></i> Inbox
                            {{-- <span class="label label-warning float-right">16</span>  --}}
                        </a></li>
                        <li><a onclick="verEnviados({ tableName: '#mailDetails' })"> <i class="fa fa-envelope-o"></i> Enviados</a></li>
                        {{-- <li><a href="{{ route('mail') }}"> <i class="fa fa-certificate"></i> Importantes</a></li> --}}
                        {{-- <li><a href="{{ route('mail') }}"> <i class="fa fa-file-text-o"></i> Documentos --}}
                            {{-- <span class="label label-danger float-right">2</span></a> --}}
                        </li>
                        {{-- <li><a href="{{ route('mail') }}"> <i class="fa fa-trash-o"></i> Basura</a></li> --}}
                    </ul>
                    {{-- <h5>Categories</h5>
                    <ul class="category-list" style="padding: 0">
                        <li><a href="#"> <i class="fa fa-circle text-navy"></i> Work </a></li>
                        <li><a href="#"> <i class="fa fa-circle text-danger"></i> Documents</a></li>
                        <li><a href="#"> <i class="fa fa-circle text-primary"></i> Social</a></li>
                        <li><a href="#"> <i class="fa fa-circle text-info"></i> Advertising</a></li>
                        <li><a href="#"> <i class="fa fa-circle text-warning"></i> Clients</a></li>
                    </ul> --}}

                    {{-- <h5 class="tag-title">Labels</h5>
                    <ul class="tag-list" style="padding: 0">
                        <li><a href=""><i class="fa fa-tag"></i> Family</a></li>
                        <li><a href=""><i class="fa fa-tag"></i> Work</a></li>
                        <li><a href=""><i class="fa fa-tag"></i> Home</a></li>
                        <li><a href=""><i class="fa fa-tag"></i> Children</a></li>
                        <li><a href=""><i class="fa fa-tag"></i> Holidays</a></li>
                        <li><a href=""><i class="fa fa-tag"></i> Music</a></li>
                        <li><a href=""><i class="fa fa-tag"></i> Photography</a></li>
                        <li><a href=""><i class="fa fa-tag"></i> Film</a></li>
                    </ul> --}}
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-9 animated fadeInRight" id="mailDetails">
        <div class="mail-box-header"></div>
        <div class="mail-box"></div>
    </div>
</div>
@include('mail.modal.modalCrearMail')
@endsection
@section('script')
<script>
    var sendMailRoute = '{{ route("sendMail") }}';
    var searchClientRoute = '{{ route("searchCustomer") }}';
    var verEnviadosRoute = '{{ route("verEnviados") }}';

    $(document).ready(function(){

    $('.summernote').summernote();

    $('.enviar-correo').on('click', function(e) {
            e.preventDefault();
            let email = $('#inputEmail').val();
            let subject = $('#inputAsunto').val();
            let text = $('#inputMensaje').val();

            // Aquí puedes capturar datos si es necesario
            let data = {
                email: email, // Cambia este valor dinámicamente si es necesario
                subject: subject,
                body: text
            };

            // Hacer la petición AJAX
            $.ajax({
                url: '{{ route("enviarCorreo") }}',  // Ruta definida en web.php
                type: 'POST',
                data: data,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'  // Token CSRF de Laravel
                },
                success: function(response) {
                    alert('Correo enviado con éxito.');
                },
                error: function(response) {
                    alert('Error al enviar el correo.');
                }
            });
        });

    });

    function sendMail() {
        mostrarMensaje("Enviando...", "Mensaje enviado", "success");
    }
</script>
<script src="{{ asset('js/utils/mostrarNuevoModal.js') }}"></script>
<script src="{{ asset('js/utils/mostrarMensaje.js') }}"></script>
<script src="{{ asset('js/plugins/summernote/summernote-bs4.js') }}"></script>
<script src="{{ asset('js/utils/mostrarMensaje.js') }}"></script>
<script src="{{ asset('js/mail/mail.js') }}"></script>
<script src="{{ asset('js/customer/searchClient.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        markNotificationsAsSeen('mail');
    });
</script>

@endsection
