<?php
$CodAgencia = Yii::app()->user->_Agencia;
?>
<script>

</script>
<div class="pageheader">

    <h2>
        <a style="text-decoration: none;"  onclick="salir()">
            <img src="images/home.png" style="width: 38px; margin-right: 15px; margin-left: 15px;" class="cursorpointer"/> 
        </a>
        Consignación  Vendedor<span></span></h2>      
</div>

<div class="contentpanel">

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-btns">            

            </div>
            <!--            <h4 class="panel-title">Consignacion  Vendedor</h4>-->
            <a href="javascript:Consignaciones()" class="btn btn-primary">
                Ver Consignaciones
                <img src="images/Zoom.png" style="width: 24px; height: 24px;">

            </a>

        </div>


        <div class="panel-body" style="min-height: 450px;">

            <div class="widget widget-blue">

                <div class="widget-content">

                    <form id="form1" class="form-horizontal">

                        <div class="mb30"></div>

                        <div class="col-sm-8 col-sm-offset-2">

                            <div class="panel panel-primary panel-alt widget-newsletter">

                                <div class="panel-body">

                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <input type="hidden" style="width: 150px;"  class="form-control"  value="<?php echo $zonaVentas ?>" id="codzona"/>
                                            <input type="hidden" style="width: 150px;"  class="form-control"  value="<?php echo $CodAgencia ?>" id="codagencia"/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <input type="hidden" style="width: 150px;"  class="form-control"   value="<?php echo $Asesor['CodAsesor'] ?>" id="codasesor"/>
                                        </div>
                                    </div>


                                    <div class="form-group">

                                        <label class="col-sm-6 control-label">Número de Consignación:</label>
                                        <div class="col-sm-6">
                                            <input type="text"  class="form-control"  id="numconsignacion" name="numconsignacion" maxlength="20" placeholder="Máximo 20 digitos"  onkeypress="return FilterInput(event)" style="height: 26px;"/>
                                        </div>
                                        <div class="col-sm-offset-7">
                                            <div id="Errorng" ></div>
                                        </div>
                                    </div>


                                    <div class="form-group">

                                        <label class="col-sm-6 control-label">Banco:</label>
                                        <div class="col-sm-6">
                                            <?php
                                            $models = Bancos::model()->findAll();
                                            $list = CHtml::listData($models, 'CodBanco', 'Nombre');

                                            echo CHtml::dropDownList('region_id', '', $list, array(
                                                'prompt' => 'Seleccione un banco',
                                                'class' => 'form-control',
                                                'id' => 'txtBanco',
                                                'onchange' => 'limpiar()',
                                                'ajax' => array(
                                                    'type' => 'POST',
                                                    'url' => Yii::app()->createUrl('ConsignacionesVendedor/AjaxCuentas'), //or $this->createUrl('loadcities') if '$this' extends CController
                                                    'update' => '#txtCuenta', //or 'success' => 'function(data){...handle the data in the way you want...}',
                                                    'data' => array('CodBanco' => 'js:this.value'),
                                            )));
                                            ?>
                                        </div>
                                        <div class="col-sm-offset-7">
                                            <div id="ErrorBn" ></div>
                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label class="col-sm-6 control-label">Código Banco:</label>
                                        <div class="col-sm-3">
                                            <input type="text"  class="form-control"  id="codbanco" maxlength="5" placeholder="Máximo 5 digitos" style="height: 26px;"/>
                                        </div>
                                        <!--<div class="col-sm-3">
                                            <input type="button" class="btn btn-primary" id="verificarcod" onclick="validation()" value="Verificar Código" disabled="true">
                                        </div>-->
                                        <div class="col-sm-5">
                                            <div id="ErrorCod" ></div>
                                        </div>
                                    </div>


                                    <div class="form-group">

                                        <label class="col-sm-6 control-label">Nombre Banco:</label>
                                        <div class="col-sm-6">
                                            <input type="text"  class="form-control"  id="nombrebanco"  disabled="true" style="height: 26px;" />
                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label class="col-sm-6 control-label">Cuenta Bancaria:</label>
                                        <div class="col-sm-6">
                                            <?php
                                            echo CHtml::dropDownList('txtCuenta', '', array(), array('prompt' => 'Seleccione una cuenta bancaria', ' class' => 'form-control', 'disabled' => 'true'));
                                            ?>
                                        </div>
                                        <div class="col-sm-offset-7">
                                            <div id="ErrorCB" ></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-6">
                                        </div>
                                        
                                        <div class="col-sm-6">
                                            <a href="javascript:ChequesaldiaConsignaciones()" class="btn btn-primary" style="width: 120px;">Cheques al dia </a>
                                        </div>
                                    </div>
                                    
                                    

                                    <div class="form-group">

                                        <label class="col-sm-6 control-label">Fecha:</label>
                                        <div class="col-sm-6">
                                            <input type="text"  class="form-control"  id="datepicker" value = "<?php echo date('Y-m-d') ?>"/>
                                        </div>
                                        <div class="col-sm-offset-7">
                                            <div id="ErrorFCH" ></div>
                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label class="col-sm-6 control-label">Valor EFC:</label>
                                        <div class="col-sm-6">
                                            <input type="text"  class="form-control"  id="valorefectivo" value="<?php echo $sumaEfectivos; ?>" onkeypress="return numeros(event)"  onkeyup="format(this)"/>
                                        </div>
                                        <div class="col-sm-offset-7">
                                            <div id="ErrorEF" ></div>
                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label class="col-sm-6 control-label">Valor CHE:</label>
                                        <div class="col-sm-6">
                                            <input type="text"  class="form-control"  id="valorecheque" value="0"  onkeypress="return numeros(event)" onkeyup="format(this)"/>
                                        </div>
                                        <div class="col-sm-offset-7">
                                            <div id="ErrorCH" ></div>
                                        </div>

                                    </div>


                                    <div class="form-group">

                                        <label class="col-sm-6 control-label">Oficina:</label>
                                        <div class="col-sm-6">
                                            <input type="text"  class="form-control"  id="oficina" maxlength="50" placeholder="Máximo 50 Caracteres" style="height: 29px;" onkeypress="val()" />
                                        </div>
                                        <div class="col-sm-offset-7">
                                            <div id="ErrorOFI" ></div>
                                        </div>

                                    </div>


                                    <div class="form-group">

                                        <label class="col-sm-6 control-label">Ciudad:</label>
                                        <div class="col-sm-6">
                                            <input type="text"  class="form-control"  id="ciudad" maxlength="50" placeholder="Máximo 50 Caracteres" style="height: 29px;" onkeypress="val1()"/>
                                        </div>
                                        <div class="col-sm-offset-7">
                                            <div id="ErrorCIU" ></div>
                                        </div>

                                    </div>


                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-5">
                                            <a href="javascript:guardarConsignacion()" class="btn btn-primary" style="width: 120px;">Guardar
                                                <span class="glyphicon glyphicon-floppy-saved"></span>
                                            </a>

                                            <a href="javascript:chequenuevoConsigvendedor()" class="btn btn-primary" style="width: 120px;">Agregar cheque</a>

                                            <a href="javascript:formaspagos()" class="btn btn-primary" style="width: 120px;">Formas Pagos</a>

                                        </div>
                                    </div>

                                </div>

                            </div>


                        </div>



                    </form>

                </div>

            </div>

        </div>

    </div>

</div>


<div data-keyboard="false" data-backdrop="static" aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-2" id="mensaje" class="modal fade in" > 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">

                <h5 id="myModalLabel" class="modal-title">Mensaje</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span style="font-size: 40px; color: green;" class="glyphicon glyphicon-ok-sign"></span>
                    </div>
                    <div class="col-sm-10">
                        <p id="mensaje-error" class="text-modal-body">Consignacion guardada satisfactoriamente!</p>
                    </div>
                </div>

            </div>
            <div class="modal-footer">                 
                <button id="btnclos" class="btn btn-primary btn-small-template" data-dismiss="modal" onclick="recargar()">OK</button>        
            </div>
        </div> <!--modal-content -->
    </div> <!--modal-dialog  -->
</div>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 930px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Consignaciones</h4>
            </div>
            <div class="modal-body">



            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <!--<button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div>




<div data-keyboard="false" data-backdrop="static" aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-2" id="danger" class="modal fade in" > 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">

                <h5 id="myModalLabel" class="modal-title">Mensaje</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span style="font-size: 40px; color: red;" class="glyphicon glyphicon-warning-sign"></span>
                    </div>
                    <div class="col-sm-10">
                        <p id="mensaje-error" class="text-modal-body">Consignacion eliminada correctamente!</p>
                    </div>
                </div>

            </div>
            <div class="modal-footer">                 
                <button id="btnclos" class="btn btn-primary btn-small-template" data-dismiss="modal">OK</button>        
            </div>
        </div> <!--modal-content -->
    </div> <!--modal-dialog  -->
</div>


<div data-keyboard="false" data-backdrop="static" aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-2" id="dangerError" class="modal fade in" > 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">

                <h5 id="myModalLabel" class="modal-title">Mensaje</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span style="font-size: 40px; color: red;" class="glyphicon glyphicon-warning-sign"></span>
                    </div>
                    <div class="col-sm-10">
                        <p id="mensaje-error" class="text-modal-body">Consignación eliminada correctamente!</p>
                    </div>
                </div>

            </div>
            <div class="modal-footer">                 
                <button id="btnclos" class="btn btn-primary btn-small-template oko" data-dismiss="modal">OK</button>        
            </div>
        </div> <!--modal-content -->
    </div> <!--modal-dialog  -->
</div>


<div class="modal fade" id="_alertConfirmationConsignacion" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id=""></h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: orange;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body" id="confirm"></p>
                    </div>
                </div>

            </div>
            <div class="modal-footer">                 
                <button class="btn btn-primary" onclick="ok()">Si</button>    
                <button data-dismiss="modal" class="btn btn-primary" type="button">No</button>    
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->



<div class="modal fade" id="_formaPago" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 619px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Formas de Pago</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <div class="form-group">
                            <label>Fecha Inicial</label>
                            <div aling="center">
                                <input type="text" class="form-control" value="<?php echo date('Y-m-d') ?>" id="fechaini">
                            </div>

                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="form-group">
                            <label>Fecha Final</label>
                            <div>
                                <input type="text" class="form-control" value="<?php echo date('Y-m-d') ?>" id="fechafin" >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="form-group">
                            <div>
                                <br>
                                <input type="button" value="Generar" class="btn btn-primary GenrarFormasPago">
                            </div>
                        </div>
                    </div>


                </div>

                <div id="tablaformaspago"></div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <!--<button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div>

<div class="modal fade" id="alertChequealDiaConsignacionVendedor" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
      <div class="modal-dialog" style="width: 619px;">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id="myModalLabel">Cheques del dia</h5>
            </div>
            <div id="tablachedesdeldia" class="contentModal"></div>
            <div class="modal-footer">                 
                <button class="btn btn-primary" id="btnAgregarChequeConsignacionVendedor">AgregarCheque</button>    
                <button data-dismiss="modal" class="btn btn-primary" type="button">Cancelar</button>    
            </div>
        <!-- modal-content -->
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal --> 
 



<?php $this->renderPartial('//mensajes/_alerta'); ?>
<?php $this->renderPartial('//mensajes/_alertConVende'); ?>
<?php $this->renderPartial('//mensajes/_alertConsignacionVendedor'); ?>

<?php $this->renderPartial('//mensajes/_modalChqueConsignacionVendedor'); ?>
<?php $this->renderPartial('//mensajes/_alertChequealDiaConsignacionVendedor'); ?>

<?php $this->renderPartial('//mensajes/_alertaRecargarPagina'); ?>