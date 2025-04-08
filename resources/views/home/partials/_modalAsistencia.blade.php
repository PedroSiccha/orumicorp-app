{{-- resources/views/home/partials/_modalAsistencia.blade.php --}}
<div class="modal fade show" id="myModal" tabindex="-1" role="dialog" aria-modal="true" data-backdrop="static" data-keyboard="false" style="display: block;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content shadow-lg">
            <div class="modal-header bg-light border-bottom">
                <h4 class="modal-title font-weight-bold">Marque su asistencia</h4>
            </div>

            <div class="modal-body">
                <div class="form-group row align-items-center">
                    <label class="col-lg-3 col-form-label">Hora de Ingreso</label>
                    <div class="col-lg-9">
                        <div id="clock" class="clock-style text-center skeleton"></div>
                    </div>
                </div>

                <div class="form-group row d-none">
                    <label class="col-lg-3 col-form-label">Comentario</label>
                    <div class="col-lg-9">
                        <input type="text" id="comentario" class="form-control" placeholder="Comentario (opcional)">
                    </div>
                </div>
            </div>

            <div class="modal-footer d-flex justify-content-end">
                <button 
                    type="button" 
                    class="btn btn-info" 
                    id="btnMarcarAsistencia"
                    data-fecha="{{ date('Y-m-d') }}"
                >
                    <i class="fa fa-save"></i> MARCAR
                </button>
            </div>
        </div>
    </div>
</div>
