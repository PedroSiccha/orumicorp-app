@extends('layouts.app')

@section('title')
      Part Time
@endsection

@section('content')
<div class="row">

      <div class="col-lg-5">
          <div class="ibox ">
              <div class="ibox-title">
                  {{-- <h5>Data Picker <small>https://github.com/eternicode/bootstrap-datepicker</small></h5> --}}
                  <div class="ibox-tools">
                      <a class="collapse-link">
                          <i class="fa fa-chevron-up"></i>
                      </a>
                      <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                          <i class="fa fa-wrench"></i>
                      </a>
                      <ul class="dropdown-menu dropdown-user">
                          <li><a href="#" class="dropdown-item">Config option 1</a>
                          </li>
                          <li><a href="#" class="dropdown-item">Config option 2</a>
                          </li>
                      </ul>
                      <a class="close-link">
                          <i class="fa fa-times"></i>
                      </a>
                  </div>
              </div>
              <div class="ibox-content">
                  <h3>
                      Data picker
                  </h3>
                  <p>
                      Simple and easy select a time for a text input using your mouse.
                  </p>

                  <div class="form-group" id="data_1">
                      <label class="font-normal">Simple data input format</label>
                      <div class="input-group date">
                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="03/04/2014">
                      </div>
                  </div>

                  <div class="form-group" id="data_2">
                      <label class="font-normal">Entrada</label>
                      <input type="text" placeholder="Entrada" class="form-control">
                  </div>

                  <div class="form-group" id="data_3">
                      <label class="font-normal">Break</label>
                      <input type="text" placeholder="Break" class="form-control">
                  </div>

                  <div class="form-group" id="data_4">
                      <label class="font-normal">Salida</label>
                      <input type="text" placeholder="Salida" class="form-control">
                  </div>

                  <div class="form-group row"><label class="col-lg-2 col-form-label">Comentarios</label>
                        <div class="col-lg-10">
                              <input type="text" placeholder="Comentarios" class="form-control">
                        </div>
                    </div>
              </div>
          </div>
      </div>
      <div class="col-lg-7">
          <div class="ibox ">
              <div class="widget style1 navy-bg">
                  <div class="row">
                      <div class="col-4">
                          <i class="fa fa-clock-o fa-5x"></i>
                      </div>
                      <div class="col-8 text-right">
                        <div id="clock" class="clock-style"></div>
                      </div>
                  </div>
              </div>
          </div>
          </div>
          </div>

          
          <div class="row">
            <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Historial</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#" class="dropdown-item">Config option 1</a>
                            </li>
                            <li><a href="#" class="dropdown-item">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link" >
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">

                    <table class="table">
                        <thead>
                        <tr>
                            <td>Entrada</td>
                            <td> - </td>
                            <td>08:15:31 AM</td>
                            <td></td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Break</td>
                            <td> - </td>
                            <td>13:07:22 PM</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Observación</td>
                            <td> - </td>
                            <td>13:25:14</td>
                            <td>Permiso de emergencia</td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        
      </div>

      <style>
            .clock-style {
                font-size: 2em;
                font-weight: bold;
                text-align: center;
                margin: 50px;
                font-family: 'Arial', sans-serif;
            }
        </style>

      <script>
            function updateClock() {
                const now = new Date();
                const hours = now.getHours().toString().padStart(2, '0');
                const minutes = now.getMinutes().toString().padStart(2, '0');
                const seconds = now.getSeconds().toString().padStart(2, '0');
    
                const timeString = `${hours}:${minutes}:${seconds}`;
                document.getElementById('clock').innerText = timeString;
            }
    
            // Actualiza el reloj cada segundo
            setInterval(updateClock, 1000);
    
            // Llama a updateClock para mostrar la hora actual inmediatamente
            updateClock();
        </script>

@endsection