<div class="modal inmodal fade" id="modalCrearMail" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Crear Mail</h4>
            </div>
            <div class="modal-body">
                <div class="mail-box">


                    <div class="mail-body">

                        <form method="get">
                            <div class="form-group row"><label class="col-sm-2 col-form-label">Para:</label>

                                <div class="col-sm-10"><input type="text" class="form-control" value="mail@orumicorp.com"></div>
                            </div>
                            <div class="form-group row"><label class="col-sm-2 col-form-label">Asunto:</label>

                                <div class="col-sm-10"><input type="text" class="form-control" value=""></div>
                            </div>
                            </form>

                    </div>

                        <div class="mail-text h-200">

                            <div class="summernote">
                                {{-- <h3>Hello Jonathan! </h3>
                                dummy text of the printing and typesetting industry. <strong>Lorem Ipsum has been the industry's</strong> standard dummy text ever since the 1500s,
                                when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic
                                typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with
                                <br/>
                                <br/> --}}

                            </div>
    <div class="clearfix"></div>
                            </div>
                        <div class="mail-body text-right tooltip-demo">
                            {{-- <a data-dismiss="modal" onclick="sendMail()" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Send"><i class="fa fa-reply"></i> Enviar</a> --}}
                            <a href="#" class="btn btn-sm btn-primary enviar-correo" data-toggle="tooltip" data-placement="top" title="Send">
                                <i class="fa fa-reply"></i> Enviar
                            </a>
                            <a data-dismiss="modal" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Discard email"><i class="fa fa-times"></i> Cancelar</a>
                            <a  class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Move to draft folder"><i class="fa fa-pencil"></i> Papeleria</a>
                        </div>
                        <div class="clearfix"></div>



                    </div>
            </div>
            <div class="modal-footer">
                {{-- <button class="btn btn-info " type="button" onclick="saveDeposit({ codeClient: '#dniCli', codeAgent: '#codeAgent', transaction_type_id: '#transaction_type_id', codeReceipt: '#codeReceipt', amount: '#amount', modal: '#modalNuevoDeposito', tableName: '#tabDeposit'})"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-default" data-dismiss="modal" type="button"><i class="fa fa-trash"></i> Cancelar</button> --}}
            </div>
        </div>
    </div>
</div>
