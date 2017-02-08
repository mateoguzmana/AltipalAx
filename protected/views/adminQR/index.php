<div class="pageheader">
    <h2>        
        <img src="images/home.png" alt="Ir al menu" class="cursorpointer salircorreo" style="width: 38px; margin-right: 15px; margin-left: 15px;"/> 
        Asignaci&#243;n de Unidades de Negocio <span></span></h2>      
</div>
<div class="contentpanel">
    <div class="panel panel-default">
        <div class="panel-body" style="min-height: 450px;">
            <div class="widget widget-blue">
                <div class="widget-content">                 
                    <div class="mb30"></div>
                    <div class="col-sm-8 col-sm-offset-2">
                        <div class="panel-body">
                            <div class="row">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Seleccione una agencia:</label>
                                    <div class="col-sm-6">
                                        <select id="Agencia" name="Agencia" class="form-control chosen-select" data-placeholder="Seleccione una agencia">
                                            <option value=""></option>
                                            <?php foreach ($Agencias as $item) { ?>
                                                <option value="<?php echo $item['CodAgencia'] ?>"><?php echo $item['CodAgencia'] . " - " . $item['Nombre'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <br>
                            <hr/>
                            <h4>Grupo(s) de ventas</h4>
                            <br>
                            <div class="row">
                                <div class="table-responsive">
                                    <table  id="tabla" class="table table-bordered">
                                        <thead>
                                            <tr style="background-color: #8DB4E2; font-size: 14px;">
                                                <th class="text-center">Codigo</th>
                                                <th class="text-center">Nombre</th>
                                                <th class="text-center">Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody id="ListSummary">
                                        </tbody>
                                    </table> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="js/AdminQR/AdminQR.js"></script>
<?php $this->renderPartial('//mensajes/_alerta'); ?>
<?php $this->renderPartial('//mensajes/_alertaCargando'); ?>
<?php $this->renderPartial('//mensajes/_alertSuccessGeneric'); ?>
<?php $this->renderPartial('//mensajes/_alertConfirmationGeneric'); ?>