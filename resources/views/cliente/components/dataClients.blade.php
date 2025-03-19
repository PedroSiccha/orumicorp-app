<div class="ibox-content" id="componentDataClient">
    <h3>Datos Personales</h3>
    @can('Perfil Cliente - Ver Codigo')
        <div class="form-group">
            <label>Código</label>
            <input type="text" class="form-control" placeholder="Ingrese su código" id="code" value="{{ $dataCustomer->code }}" readonly>
        </div>
    @endcan
    @can('Perfil Cliente - Ver Nombre')
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" class="form-control" placeholder="Ingrese su nómbre" id="name" value="{{ $dataCustomer->name }}">
        </div>
    @endcan
    @can('Perfil Cliente - Ver Apellido')
        <div class="form-group">
            <label>Apellido</label>
            <input type="text" class="form-control" placeholder="Ingrese su apellido" id="lastname" value="{{ $dataCustomer->lastname }}">
        </div>
    @endcan
    @can('Perfil Cliente - Ver Correo')
        <div class="form-group">
            <label>Corréo</label>
            <input type="email" class="form-control" placeholder="Ingrese su corréo" id="email" value="{{ $dataCustomer->email }}">
        </div>
    @endcan
    @can('Perfil Cliente - Ver Telefono')
        <div class="form-group">
            <label>Teléfono</label>
            <input type="text" class="form-control" placeholder="Ingrese su teléfono" id="phone" value="{{ $dataCustomer->phone }}">
        </div>
    @endcan
    @can('Perfil Cliente - Ver Telefono Opcional')
        <div class="form-group">
            <label>Teléfono Opcional</label>
            <input type="text" class="form-control" placeholder="Ingrese su teléfono opcional" id="optionalPhone" value="{{ $dataCustomer->optional_phone }}">
        </div>
    @endcan
    {{-- @can('Perfil Cliente - Ver Ciudad')
        <div class="form-group">
            <label>Ciudad</label>
            <input type="text" class="form-control" placeholder="Ingrese su ciudad" id="city" value="{{ $dataCustomer->city }}">
        </div>
    @endcan --}}
    @can('Perfil Cliente - Ver Pais')
        <div class="form-group">
            <label>País</label>
            <input type="text" class="form-control" placeholder="Ingrese su país" id="country" value="{{ $dataCustomer->country }}">
        </div>
    @endcan
    <button class="btn btn-primary btn-block" onclick="updateClientProfile(
        '#code',
        '#name',
        '#lastname',
        '#email',
        '#phone',
        '#optionalPhone',
        '#country',
        '#componentDataClient')">Actualizar</button> 
</div>