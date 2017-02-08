
<div class="modal fade" id="_modalChequeConsignacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content" style="width: 700px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Forma pago cheque consignación </h4>
            </div>
            <div class="modal-body">

                <div class="row">

                    <div class="tab-pane" id="chequeConsignacion">

                        <div>

                            <h5 class="text-primary">Datos Consignación</h5>


                            <div class="row" style="margin: 5px;">

                                <input type="hidden"  id="txtFacturaChc" class="form-control facturaRecibo">
                                <div class="col-sm-6">                    
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label text-right">Número</label>
                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Máximo 20 caracteres" name="" id="txtNumeroECc" class="col-sm-6 form-control txtLenghtnumero">
                                        </div>
                                    </div>
                                </div><!-- col-sm-6 -->
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-4 text-right">Banco</label>
                                        <div class="col-sm-8">                    
                                            <?php
                                            $models = Bancos::model()->findAll();
                                            $list = CHtml::listData($models, 'CodBanco', 'Nombre');
                                            echo CHtml::dropDownList('region_id', '', $list, array(
                                                'prompt' => 'Seleccione un banco',
                                                'class' => 'form-control',
                                                'onchange' => '
                                                $("#txtCodBancoECc").val("");  
                                                $("#txtNombreBancoECc").val("");
                                                $("#txtCuentaECc").attr("disabled", "disabled");
                                            ',
                                                'id' => 'txtBancoECc',
                                                'ajax' => array(
                                                    'type' => 'POST',
                                                    'url' => Yii::app()->createUrl('Recibos/AjaxCuentasBancarias'), //or $this->createUrl('loadcities') if '$this' extends CController
                                                    'update' => '#txtCuentaECc', //or 'success' => 'function(data){...handle the data in the way you want...}',
                                                    'data' => array('CodBanco' => 'js:this.value'),
                                            )));
                                            ?>        

                                        </div>
                                    </div>
                                </div><!-- col-sm-6 -->
                            </div>

                            <div class="row" style="margin: 5px;">
                                <div class="col-sm-6"> 
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label text-right">Cod Banco</label>
                                        <div class="col-sm-8">
                                            <input type="text" placeholder="" class="form-control txtLenghtCodBanco" id="txtCodBancoECc" />
                                        </div>
                                        <div class="col-sm-5" style="display:none">
                                            <button type="button" class="btn btn-primary btn-block" id="btnCodBancoECc" style="margin-top: 3px;">Verificar Código</button>
                                        </div> 
                                    </div>  
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label text-right">Banco</label>
                                        <div class="col-sm-8">
                                            <input type="text" placeholder="" class="form-control" id="txtNombreBancoECc" readonly="readonly"/>
                                        </div>          
                                    </div> 
                                </div> 

                            </div>     

                            <div class="row" style="margin: 5px;">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-4 text-right">Cuenta</label>
                                        <div class="col-sm-8">
                                            <?php
                                            echo CHtml::dropDownList('txtCuentaECc', '', array(), array("disabled" => "disabled", 'prompt' => 'Selecione una cuenta', ' class' => 'form-control'));
                                            ?>  
                                        </div>
                                    </div>
                                </div><!-- col-sm-6 -->
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-4 text-right">Fecha</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="lastname" id="txtFechaECc" class="form-control" readonly="readonly" style="width: 85%"/>
                                        </div>
                                    </div>
                                </div><!-- col-sm-6 -->
                            </div>




                            <hr/>
                            <h5 class="text-primary">Datos Cheque</h5>

                            <div class="row" style="margin: 5px;">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-4 text-right">Número</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="firstname" placeholder="Máximo 20 caracteres" id="txtNumeroDCc" class="form-control txtLenghtnumero">
                                        </div>
                                    </div>
                                </div><!-- col-sm-6 -->
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label text-right">Cod Banco</label>
                                        <div class="col-sm-8">
                                            <input type="text" placeholder="" class="form-control txtLenghtCodBanco" id="txtCodBancoDCc"/>
                                        </div>
                                        <div class="col-sm-5" style="display: none;">
                                            <button type="button" class="btn btn-primary btn-block" id="btnCodBancoDCc" style="margin-top: 3px;">Validar Banco</button>
                                        </div>
                                    </div> 

                                    <label id="MsgBancoCc"></label>
                                </div> 
                            </div>



                            <div class="row" style="margin: 5px;">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-4 text-right">Cuenta</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="firstname" id="txtCuentaDCc" class="form-control txtLenghtnumero" placeholder="Máximo 20 caracteres">
                                        </div>
                                    </div>
                                </div><!-- col-sm-6 -->
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-4 text-right">Fecha</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="lastname" id="txtFechaDCc" class="form-control" readonly="readonly" style="width: 85%"/>
                                        </div>
                                    </div>
                                </div><!-- col-sm-6 -->
                            </div>   

                            <div class="row" style="margin: 5px;">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-4 text-right">Valor</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="firstname" id="txtValorDCcSaldo" class="form-control">
                                        </div>
                                    </div>
                                </div><!-- col-sm-6 -->

                            </div>     

                            <div class="form-group text-center">
                                <a class="btn btn-default" id="btnAgregarChequeConsignadoDetalle">Agregar <img src="images/AgregarNew.png" style="width: 30px;"/></a>                          
                            </div> 
                            
                            <div id="datosChequeConsignacionRecibos"></div>


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