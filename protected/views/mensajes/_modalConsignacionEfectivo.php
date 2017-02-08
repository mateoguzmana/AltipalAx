<?php
$codagencia = Yii::app()->user->_Agencia;
$formasPagoEfectivoConsig = Consultas::model()->getFormasPagoConsigEfectivo($codagencia);
?>
<div class="modal fade" id="_modalConsignacionEfectivo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Forma pago consignación efectivo</h4>
            </div>
            <div class="modal-body">

                <div class="row">

                    <div class="tab-pane" id="about">

                        <div class="col-sm-12">
                            <input type="hidden"  id="txtFacturaCef" class="form-control facturaRecibo">
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label text-right">Forma de
                                    pago</label>
                                <div class="col-sm-6">
                                    <select name="formas_pago" id="formas_pago">
                                        <option disabled selected>Selecciona forma</option>
                                        <?php foreach ($formasPagoEfectivoConsig as $itemFormasPagoEfec){?>
                                        <option value="<?php echo $itemFormasPagoEfec['CodigoFormadePago'];?>"><?php echo $itemFormasPagoEfec['Descripcion'];?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">Número/Voucher</label>
                                <div class="col-sm-6">
                                    <input type="text" placeholder="Máximo 20 caracteres" class="form-control txtLenghtnumero" id="txtNumeroEc"/>
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
                                        'onchange' => '
                                        $("#txtCodBancoEc").val("");
                                        $("#txtBanco").val("");
                                        $("#txtCuenta").attr("disabled", "disabled");
                                    ',
                                        'class' => 'form-control',
                                        'id' => 'txtBancoEc',
                                        'ajax' => array(
                                            'type' => 'POST',
                                            'url' => Yii::app()->createUrl('Recibos/AjaxCuentasBancarias'), //or $this->createUrl('loadcities') if '$this' extends CController
                                            'update' => '#txtCuenta', //or 'success' => 'function(data){...handle the data in the way you want...}',
                                            'data' => array('CodBanco' => 'js:this.value'),
                                    )));
                                    ?>                       

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">Cod Banco</label>
                                <div class="col-sm-6">
                                    <input type="text" placeholder="" class="form-control txtLenghtCodBanco" id="txtCodBancoEc" />
                                </div>
                                <div class="col-sm-3" style="display:none">
                                    <button type="button" class="btn btn-primary btn-block" id="btnCodBandoEc" >Verificar Código</button>
                                </div>     

                            </div>     

                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">Banco</label>
                                <div class="col-sm-6">
                                    <input type="text" placeholder="" class="form-control" id="txtBanco" readonly="readonly"/>
                                </div>          
                            </div>   



                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">Cuenta</label>

                                <div class="col-sm-6">

                                    <?php
                                    echo CHtml::dropDownList('txtCuenta', '', array(), array("disabled" => "disabled", 'prompt' => 'Selecione una cuenta', ' class' => 'form-control'));
                                    ?>  

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">Fecha</label>
                                <div class="col-sm-6">
                                    <input type="text" placeholder="" class="form-control" id="txtFechaEc"  readonly="readonly" style="width: 85%"/>
                                    <!--<img class="ui-datepicker-trigger" src="images/calendar.png" alt="Seleccione una fecha" title="Seleccione una fecha">-->
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">Valor</label>
                                <div class="col-sm-6">
                                    <input type="text" placeholder="" class="form-control" id="txtValorEcSaldo"/>
                                </div>
                            </div>

                            <div class="form-group text-center">
                                <a class="btn btn-default" id="btnAgregarConEfecDetalle">Agregar <img src="images/AgregarNew.png" style="width: 30px;"/></a>                          
                            </div>  

                            <div class="mb30"></div>

                            <div  id="datosConsignacionEfectivoRecibos"></div>

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