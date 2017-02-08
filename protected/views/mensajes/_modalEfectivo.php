

<div class="modal fade" id="_modalEfectivo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Forma pago Efectivo</h4>
            </div>
            <div class="modal-body">

                <div class="row">

                    <div class="tab-pane" id="contact">
                        <div class="col-sm-12">
                            <input type="hidden"  id="txtFacturaEfectivo" class="form-control facturaRecibo">
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">Valor Efectivo</label>
                                <div class="col-sm-6">
                                    <input type="text"  id="txtValorEfectivo" class="form-control">
                                </div>
                            </div>
                            
                            <div class="form-group text-center">
                                <a class="btn btn-default" id="btnAgregarEfectivoDetalle">Agregar <img src="images/AgregarNew.png" style="width: 30px;"/></a>                          
                            </div>   

                            <div id="datosEfectivoRecibos">

                            </div>

                        </div>  
                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                <!--<button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div>