
<div class="panel-body">
    <div class="row">
        <div class="form-group">
            <label class="col-sm-4 control-label">Nombre:</label>
            <div class="col-sm-6">
                <input type="text"  class="form-control" id="nombreEditado" value="<?php echo $Nombre ?>" />
            </div>
        </div>
        <div id="ErrorNombre" class="col-md-offset-5" style="color: red"></div>

        <div class="form-group">
            <label class="col-sm-4 control-label">Apellido:</label>
            <div class="col-sm-6">
                <input type="text"  class="form-control" id="apellidoEditado" value="<?php echo $Apellido ?>"/>
            </div>
        </div>
        <div id="ErrorApell" class="col-md-offset-5" style="color: red"></div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Correo Electronio:</label>
            <div class="col-sm-6">
                <input type="text"  class="form-control" id="correoEditado" value="<?php echo $Correo ?>"/>
            </div>
        </div>
        <div id="ErrorCorreo" class="col-md-offset-5" style="color: red"></div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Agencia:</label>
            <div class="col-sm-6">
                <select id="SelectAgenciaEditado" name="Agencia" class="form-control chosen-select" data-placeholder="Seleccione una agencia" value="<?php echo $agencia ?>">
                    <?php foreach ($Agencias as $tiem) { ?>
                        <option value="<?php echo $tiem['CodAgencia'] ?>"><?php echo $tiem['Nombre'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-sm-4 control-label">Estado:</label>
            <div class="col-sm-6">
                <select id="SelectEstadoEditado" name="Agencia" class="form-control chosen-select" data-placeholder="Seleccione un Estado" value="<?php echo $estado ?>">
                        <option value="<?php echo "1" ?>"><?php echo "ACTIVO" ?></option>
                        <option value="<?php echo "0" ?>"><?php echo "INACTIVO" ?></option>
                </select>
            </div>
        </div>
        <div id="ErroEstado" class="col-md-offset-5" style="color: red"></div>
        <div  class="row">
            <div class="col-sm-6 col-sm-offset-5">
                <input type="button" class="btn btn-primary" id="btnGuardarEdicionCorreo" value="Editar Correo" data-id="<?php echo $id ?>"> 
            </div>
        </div>
    </div> 
    <br>
</div>


<?php $this->renderPartial('//mensajes/_alerta'); ?>
<?php $this->renderPartial('//mensajes/_alertaSueccesCorreoVentaDirecta'); ?>
<?php $this->renderPartial('//mensajes/_alertCarg'); ?>
<?php $this->renderPartial('//mensajes/_alertConfirmarAdminUsuario'); ?>

