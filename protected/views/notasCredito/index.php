<?php
$CodAgencia = Yii::app()->user->_Agencia;
?> 
<div class="pageheader">
    <h2>        
        <img src="images/home.png" alt="Ir al menu" class="cursorpointer" id="retornarMenuNotaCredito"  style="width: 38px; margin-right: 15px; margin-left: 15px;"/> 
        Nota Crédito <span></span></h2>      
</div>

<div class="contentpanel">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-btns">
            </div>
        </div>
        <div class="panel-body" style="min-height: 450px;">
            <div class="widget widget-blue">
                <div class="widget-content">
                    <form id="form1" class="form-horizontal" enctype="multipart/form-data">
                        <div class="mb30"></div>
                        <div id="img-cargar"></div>
                        <div class="col-sm-8 col-sm-offset-2">
                            <div class="panel panel-primary panel-alt widget-newsletter">
                                <div class="panel-body">
                                    <input type="hidden" value="<?php echo $CodAgencia ?>" id="codagencia">
                                    <input type="hidden" value="<?php echo $Responsable ?>" id="Responsable">
                                    <input type="hidden" value="<?php echo $CodigoCanal ?>" id="canal">
                                    <input type="hidden" value="<?php echo $asesor['CodAsesor'] ?>" id="codasesor">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Código Zona de Ventas:</label>
                                        <div class="col-sm-3">
                                            <input type="text" style="width: 150px;"  class="form-control" disabled="true" value="<?php echo $zonaVenta['CodZonaVentas']; ?>" id="codzona"/>
                                        </div>
                                        <label class="col-sm-3 control-label">Nombre Zona Ventas:</label>
                                        <div class="col-sm-3">
                                            <input type="text" style="width: 180px; height: 26px;" class="form-control" disabled="true" value="<?php echo $zonaVenta['NombreZonadeVentas']; ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Cuenta Cliente:</label>
                                        <div class="col-sm-3">
                                            <input type="text" style="width: 170px;" class="form-control" disabled="true" value="<?php echo $clien['CuentaCliente']; ?>" id="cuenta"/>
                                        </div>
                                        <label class="col-sm-3 control-label">Nombre Cliente:</label>
                                        <div class="col-sm-3">
                                            <input type="text" style="width: 180px;" class="form-control" disabled="true" value="<?php echo $clien['NombreCliente']; ?>"/>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Subir Foto:</label>
                                        <div class="col-sm-8">
                                            <input type="file" style="width: 250px;" id="foto" name="foto"  onchange="control(this)">
                                        </div>
                                        <div class="col-sm-offset-6">
                                            <div id="ErrorFT"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label"></label>
                                        <div class="col-sm-8">
                                            <input type="file" style="width: 250px;" id="foto1" name="foto1"  onchange="control(this)">
                                        </div>
                                        <div class="col-sm-offset-6">
                                            <div id="ErrorFT"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label"></label>
                                        <div class="col-sm-8">
                                            <input type="file" style="width: 250px;" id="foto2" name="foto2"  onchange="control(this)">
                                        </div>
                                        <div class="col-sm-offset-6">
                                            <div id="ErrorFT"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Responsable Nota:</label>
                                        <div class="col-sm-8">
                                            <?php
                                            $models = Responsablenota::model()->findAll();
                                            $list = CHtml::listData($models, 'Interfaz', 'Descripcion');
                                            echo CHtml::dropDownList('region_id', '', $list, array(
                                                'prompt' => ' Seleccione un responsable de la nota credito',
                                                'class' => 'form-control limp',
                                                'id' => 'txtResponNota',
                                                'ajax' => array(
                                                    'type' => 'POST',
                                                    'url' => Yii::app()->createUrl('NotasCredito/Consceptos'), //or $this->createUrl('loadcities') if '$this' extends CController
                                                    'update' => '#txtConcepto', //or 'success' => 'function(data){...handle the data in the way you want...}',
                                                    'data' => array('Interfaz' => 'js:this.value'),
                                            )));
                                            ?>
                                        </div>
                                        <div class="col-sm-offset-6">
                                            <div id="ErrorRESPO" ></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Concepto:</label>
                                        <div class="col-sm-8">
                                            <?php
                                            echo CHtml::dropDownList('txtConcepto', '', array(), array('prompt' => 'Seleccione un concepto', ' class' => 'form-control limpConcep'));
                                            ?>
                                        </div>
                                        <div class="col-sm-offset-6">
                                            <div id="ErrorCONCP" ></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Factura:</label>
                                        <div class="col-sm-8">
                                            <?php
                                            $models = Notascredito::model()->getFacClie($cli);
                                            $list = CHtml::listData($models, 'NumeroFactura', 'NumeroFactura');
                                            echo CHtml::dropDownList('region_id', '', $list, array(
                                                'prompt' => 'Seleccione una factura',
                                                'class' => 'form-control limpFactu',
                                                'id' => 'txtFactura',
                                                'onchange' => 'valorfac()',
                                                'ajax' => array(
                                                    'type' => 'POST',
                                                    'url' => Yii::app()->createUrl('NotasCredito/Fabricantes'), //or $this->createUrl('loadcities') if '$this' extends CController
                                                    'update' => '#txtFabricante', //or 'success' => 'function(data){...handle the data in the way you want...}',
                                                    'data' => array('NumeroFactura' => 'js:this.value'),
                                            )));
                                            ?>    
                                        </div>
                                        <div class="col-sm-offset-6">
                                            <div id="ErrorFAC" ></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Fabricante:</label>
                                        <div class="col-sm-8">
                                            <?php
                                            echo CHtml::dropDownList('txtFabricante', '', array(), array('prompt' => 'Seleccione un fabricante', ' class' => 'form-control limpFabri', 'onchange' => 'valorfacproveedor()'));
                                            ?>
                                        </div>
                                        <div class="col-sm-offset-6">
                                            <div id="ErrorFABR" ></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Ver Detalle:</label>
                                        <div class="col-sm-8">
                                            <input type="button" class="btn btn-primary-alt" data-toggle="modal"  value="Detalle Factura" onclick="verdetalle()">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Valor:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" value="<?php echo $total2; ?>" id="valor" onkeypress="return FilterInput(event)">
                                        </div>
                                        <div class="col-sm-offset-6">
                                            <div id="ErrorVAL" ></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Observación:</label>
                                        <div class="col-sm-8">
                                            <textarea rows="5" class="form-control" id="observacion" maxlength="50" placeholder="Máximo 50 caracteres" onkeypress="FilterInput(event)"></textarea>
                                        </div>
                                        <div class="col-sm-offset-6">
                                            <div id="ErrorOBSER" ></div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-5">
                                            <a href="javascript:guardarnotascredito()" class="btn btn-primary" style="width: 120px;">Guardar
                                                <span class="glyphicon glyphicon-floppy-saved"></span>
                                            </a>
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

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <?php
                $numerofactura = Consultas::model()->getNumeroCuenta($cli, $zona);
                ?>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Detalle Factura #:<?php echo $numerofactura['NumeroFactura']; ?></h4>
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
                        <p id="mensaje-error" class="text-modal-body">Nota credito enviada satisfactoriamente!</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">                 
                <!--<button id="btnclos" class="btn btn-primary btn-small-template" data-dismiss="modal" onclick="recargar()">OK</button>-->
                <a  class="btn btn-primary" href="index.php?r=NotasCredito/index&cliente=<?php echo $clien['CuentaCliente'] ?>&zonaVentas=<?php echo $zonaVenta['CodZonaVentas'] ?>">OK</a>
            </div>
        </div> <!--modal-content -->
    </div> <!--modal-dialog  -->
</div>

<?php $this->renderPartial('//mensajes/_alerta'); ?>
<?php $this->renderPartial('//mensajes/_alertConfirmationMenu', array('zonaVentas' => $zonaVenta['CodZonaVentas'], 'cuentaCliente' => $clien['CuentaCliente'])); ?>
<?php $this->renderPartial('//mensajes/_alertNotasCredito'); ?>
<?php $this->renderPartial('//mensajes/_alertaRecargarPagina'); ?>