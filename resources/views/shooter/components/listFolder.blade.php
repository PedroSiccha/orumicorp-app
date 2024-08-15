@foreach ($folders as $folder)
    <li style="display: flex; justify-content: space-between; align-items: center;">
        <a onclick="" style="flex: 1;"><i class="fa fa-folder"></i> {{ $folder->name }}</a>
        <a class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></a>
        <ul class="dropdown-menu dropdown-user">
            <li><a href="#" class="dropdown-item">Cambiar Nombre</a></li>
            <li><a href="#" class="dropdown-item">Eliminar</a></li>
            <li><a href="#" class="dropdown-item">Agregar Cliente</a></li>
            <li><a href="#" class="dropdown-item">Agregar Varios Clientes</a></li>
        </ul>
    </li>
@endforeach
