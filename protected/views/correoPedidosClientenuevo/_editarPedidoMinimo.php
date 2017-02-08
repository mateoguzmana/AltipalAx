<div class="panel-body">
    <div class="row">
        <div class="form-group">
            <label class="col-sm-4 control-label">Valor Minimo:</label>
            <div class="col-sm-6">
                <input type="text"  class="form-control" id="valorMinimo"  value="<?php echo $valorPedidoMinimo ?>"/>
            </div>
        </div>
        <div id="ErrorNombre" class="col-md-offset-5" style="color: red"></div>
    </div>
    <div  class="row">
        <div class="col-sm-6 col-sm-offset-5">
            <input type="button" class="btn btn-primary" id="btnGuardarEdicionValor" value="Editar Pedido Minimo" data-id="<?php echo $id ?>"> 
        </div>
    </div>
</div>

<?php /*$this->renderPartial('//mensajes/_alerta'); ?>
<?php $this->renderPartial('//mensajes/_alertaSueccesCorreoVentaDirecta'); ?>
<?php $this->renderPartial('//mensajes/_alertCarg'); ?>
<?php $this->renderPartial('//mensajes/_alertConfirmarAdminUsuario'); ?>*/

