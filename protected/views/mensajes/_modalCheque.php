<?php
$session = new CHttpSession;
$session->open();
if ($session['ChequeDetalle']) {
    $datosDetalle = $session['ChequeDetalle'];
} else {
    $datosDetalle = array();
}
?>


<div class="modal fade" id="_modalCheque" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Forma pago cheque</h4>
            </div>
            <div class="modal-body">

                <div class="row">

                    <div class="tab-pane" id="contact">
                        <div class="col-sm-12">
                            <input type="hidden"  id="txtFacturaCh" class="form-control facturaRecibo">
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">Número</label>
                                <div class="col-sm-6">
                                    <input type="text" placeholder="Máximo 20 caracteres" id="txtNumeroCheque" class="form-control txtLenghtnumero">
                                </div>
                            </div>

                            <div class="form-group">
                                 <label class="col-sm-3 control-label text-right">Banco</label>
                                <div class="col-sm-6">                    
                                    <?php
                                    $models = Bancos::model()->findAll();
                                    $list = CHtml::listData($models, 'CodBanco', 'Nombre');
                                    echo CHtml::dropDownList('region_id', '', $list, array(
                                        'prompt' => 'Seleccione un banco',
                                        'class' => 'form-control',
                                        'id' => 'txtBancoChe'
                                    ));
                                    ?>        

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">Cod Banco</label>
                                <div class="col-sm-6">
                                    <input type="text" placeholder="" class="form-control txtLenghtCodBanco txtPagoCheque" id="txtBancoCheque" />
                                </div>
                                <div class="col-sm-4" style="display:none">
                                    <input type="button" value="Validar Banco" class="btn btn-primary" id="btnBancoCheque"/>
                                </div>
                            </div>

                            <div class="col-sm-offset-3">
                                <label id="MsgBanco"></label> 
                            </div>


                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">Cuenta</label>
                                <div class="col-sm-6">
                                    <input type="text"  id="txtCuentaCheque" class="form-control txtLenghtnumero" placeholder="Máximo 20 caracteres">
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">Fecha</label>
                                <div class="col-sm-6">
                                    <input type="text" placeholder="" id="txtFechaCheque" class="form-control" readonly="readonly" style="width: 85%"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">Girado a</label>
                                <div class="col-sm-6">                  
                                    <select class="form-control" id="txtGirado">
                                        <option value="">Seleccionar girado:</option>
                                        <option value="1">Altipal</option>
                                        <option value="2">Otro</option>

                                    </select>
                                </div>
                            </div>  

                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">Otro</label>
                                <div class="col-sm-6">                  
                                    <textarea id="txtOtro" readonly="readonly" cols="5" placeholder="Maximo 50 caracteres" class="form-control txtAreaObservaciones" style="height: 45px;"></textarea>
                                </div>
                            </div>      

                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">Valor</label>
                                <div class="col-sm-6">
                                    <input type="text" placeholder="" id="txtValorChequeSaldo" class="form-control">
                                </div>
                            </div>


                            <div class="form-group text-center">
                                <a class="btn btn-default" id="btnAgregarChequeDetalle">Agregar <img src="images/AgregarNew.png" style="width: 30px;"/></a>                          
                            </div>    

                            <div id="datosChequesRecibos">

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