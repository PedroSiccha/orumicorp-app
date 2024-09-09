@if ($folders)
    @foreach ($folders as $folder)
    {{-- <li style="display: flex; justify-content: space-between; align-items: center;"> --}}
        <li style="display: flex; justify-content: space-between; align-items: center;" onclick="viewListClient({ folderId: '{{ $folder->id }}', tableName: '#listClientFolder' })">
            <a onclick="" style="flex: 1;"><i class="fa fa-folder"></i> {{ $folder->name }}</a>
            <a class="dropdown-toggle" data-toggle="dropdown"></a>
            <ul class="dropdown-menu dropdown-user">
                @can('Renombrar Carpeta')
                <li><a onclick="changeNameFolder({ inputFolderId: '#idFolderEdit', folderId: '{{ $folder->id }}', inputNameFolder: '#nameFolderEdit', folderName: '{{ $folder->name }}', modal: '#modalEditarFolder' })" class="dropdown-item">Cambiar Nombre</a></li>
                @endcan
                @can('Eliminar Carpeta')
                <li><a onclick="deleteFolder({ id: '{{ $folder->id }}', name: '{{ $folder->name }}', tableName: '#folders' })" class="dropdown-item">Eliminar</a></li>
                @endcan
                @can('Agregar Cliente a Carpeta')
                <li><a onclick="mostrarAddClient({ inputFolderId: '#idAssignFolderClient', folderId: '{{ $folder->id }}', inputNameFolder: '#nameFolderEdit', folderName: '{{ $folder->name }}', modal: '#modalAddClient' })" class="dropdown-item">Agregar Cliente</a></li>
                @endcan
                @can('Carga Masiva a Carpetas')
                <li><a onclick="mostrarNuevoModal('#modalCargaMasivaShooter')" class="dropdown-item">Agregar Varios Clientes</a></li>
                @endcan
            </ul>
        </li>
    @endforeach
@else
    <div class="widget  p-lg text-center">
        <div class="m-b-md">
            <i class="fa fa-folder-open-o fa-4x"></i>
            <h1 class="m-xs">0</h1>
            <h3 class="font-bold no-margins">
                No Data
            </h3>
            {{-- <small>amount</small> --}}
        </div>
    </div>
@endif

