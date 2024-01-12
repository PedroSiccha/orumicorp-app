@extends('layouts.app')

@section('title')
      Clientes
@endsection

@section('content')
<div class="row">
      <div class="col-lg-12">
          <div class="ibox ">
              <div class="ibox-title">
                  <h5>Tabla Clientes </h5>
                  <button type="button" class="btn btn-default" type="button"><i class="fa fa-plus"></i> Nuevo Cliente</button>
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
  
                  <table class="table table-striped">
                      <thead>
                      <tr>
                          <th>Fecha de Ingreso</th>
                          <th>ID de Cliente</th>
                          <th>Nombre del Cliente</th>
                          <th>Acción</th>
                      </tr>
                      </thead>
                      <tbody>
                      <tr>
                          <td>21-07-2023</td>
                          <td>18372</td>
                          <td>Jose Pelaez Cruz</td>
                          <td>
                              <button class="btn btn-info " type="button"><i class="fa fa-check"></i></button>
                              <button class="btn btn-warning " type="button"><i class="fa fa-pencil"></i></button>
                              <button class="btn btn-danger " type="button"><i class="fa fa-trash"></i></button>
                          </td>
                      </tr>
                      <tr>
                          <td>21-07-2023</td>
                          <td>18373</td>
                          <td>Pepe Pelaez Cruz</td>
                          <td>
                              <button class="btn btn-info " type="button"><i class="fa fa-check"></i></button>
                              <button class="btn btn-warning " type="button"><i class="fa fa-pencil"></i></button>
                              <button class="btn btn-danger " type="button"><i class="fa fa-trash"></i></button>
                          </td>
                      </tr>
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
  </div>
@endsection