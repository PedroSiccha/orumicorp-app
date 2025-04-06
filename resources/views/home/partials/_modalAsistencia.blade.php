{{-- resources/views/home/partials/_modalAsistencia.blade.php --}}
<div class="modal inmodal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Marque su asistencia</h4>
                <input type="hidden" id="aId" placeholder="Nombre del cliente" class="form-control" readonly hidden>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Hora de Ingreso</label>
                    <div class="input-group col-lg-9">
                        <div class="input-group-append">
                            <div id="clock" class="clock-style"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button id="btnMarcarAsistencia"
                        class="btn btn-info"
                        data-fecha="{{ date('Y-m-d') }}"
                        type="button">
                    <i class="fa fa-save"></i> MARCAR
                </button>
            </div>
        </div>
    </div>
</div>
