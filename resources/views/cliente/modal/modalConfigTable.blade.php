<div class="modal inmodal fade" id="modalConfigTable" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title">Configurar la tabla</h4>
                <small id="nameRol" class="font-bold">Seleccione las columnas que quiere visualizar</small>
                <input type="text" placeholder="Ingrese el nombre del rol" class="form-control" id='idRol'
                    value="{{ $myRolesId }}" hidden>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-hover">

                    <tbody>
                        <tr>
                            <td>
                                <input type="checkbox" class="i-checks flat chekboxses" name="configTablesDateInit"
                                    id="configTablesDateInit" {{ $configTablesDateInit->status == 'active' ?
                                'checked' : '' }}>
                            </td>
                            <td> {{ $configTablesDateInit->name }}</td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="i-checks flat chekboxses" name="configTablesCode" value=""
                                    id="configTablesCode" {{ $configTablesCode->status == 'active' ?
                                'checked' : '' }}>
                            </td>
                            <td> {{ $configTablesCode->name }}</td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="i-checks flat chekboxses" name="configTablesPhone"
                                    value="" id="configTablesPhone" {{ $configTablesPhone->status == 'active' ?
                                'checked' : '' }}>
                            </td>
                            <td> {{ $configTablesPhone->name }}</td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="i-checks flat chekboxses" name="configTablesOptionalPhone"
                                    value="" id="configTablesOptionalPhone" {{ $configTablesOptionalPhone->status ==
                                'active' ? 'checked' : '' }}>
                            </td>
                            <td> {{ $configTablesOptionalPhone->name }}</td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="i-checks flat chekboxses" name="configTablesEmail"
                                    value="" id="configTablesEmail" {{ $configTablesEmail->status == 'active' ?
                                'checked' : '' }}>
                            </td>
                            <td> {{ $configTablesEmail->name }}</td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="i-checks flat chekboxses" name="configTablesCity" value=""
                                    id="configTablesCity" {{ $configTablesCity->status == 'active' ?
                                'checked' : '' }}>
                            </td>
                            <td> {{ $configTablesCity->name }}</td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="i-checks flat chekboxses" name="configTablesCountry"
                                    value="" id="configTablesCountry" {{ $configTablesCountry->status == 'active' ?
                                'checked' : '' }}>
                            </td>
                            <td> {{ $configTablesCountry->name }}</td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="i-checks flat chekboxses" name="configTablesComment"
                                    value="" id="configTablesComment" {{ $configTablesComment->status == 'active' ?
                                'checked' : '' }}>
                            </td>
                            <td> {{ $configTablesComment->name }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button class="btn btn-info " type="button"
                    onclick="saveConfigTable('#configTablesDateInit', '#configTablesCode', '#configTablesPhone', '#configTablesOptionalPhone', '#configTablesEmail', '#configTablesCity', '#configTablesCountry', '#configTablesComment', '#modalConfigTable', '#tabClient')"><i
                        class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i>
                    Cancelar</button>
            </div>
        </div>
    </div>
</div>
