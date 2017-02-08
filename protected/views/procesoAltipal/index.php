<style>
    .table-responsive {
        width: 100%;
        max-width: 90%;
        margin-bottom: 20px;
    }
</style>
<body>
    <div class="pageheader">
        <h2>
            <img src="images/home.png" alt="Ir al menu" class="cursorpointer" id="" style="width: 38px; margin-right: 15px; margin-left: 15px;"/> 
            EJECUTAR PROCESO DE ACTUALIZACION</h2>      
    </div>
    <title>PROCESO DE ACTUALIZACION</title>
    <div class="panel panel-default" style="padding: 10px;">
        <!--<div class="panel-heading"><h4>PROCESO DE ACTUALIZACION</h4></div>-->
        <!--<p><a class="btn btn-primary btn-lg" role="button" id="btnExecuteCompleteProcess" style="padding-bottom: 10px;">Ejecutar proceso completo</a></p>-->
        <div class="form-actions">
            <button class="btn btn-primary btn-lg" id="btnExecuteCompleteProcess">Ejecutar proceso completo</button>
            <div class="pull-right">
                <button class="btn btn-primary btn-lg" id="btnWatchProcess">Ver proceso ejecutando</button>
            </div>
        </div>
        <!--<div class="container" style="padding: 10px;">
            <button type="button" id="btnExecuteCompleteProcess" class="btn btn-primary btn-lg">Ejecutar proceso completo</button>
            <!--<a href="#" class="btn btn-primary btn-success"><span class="glyphicon glyphicon-plus-sign"></span></a>-->
        <!--</div>-->
        <div class="panel-body">
            <div class="container">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <strong><label class="col-sm-4 control-label" style="font-size:16px">Seleccione el servicio que quiere ejecutar: </label></strong>
                        <select class="selectpicker" id="Methods" data-live-search="true" data-actions-box="true" data-width="30%" data-selected-text-format="count" title="Seleccione un servicio...">
                            <option value="">Seleccione un servicio...</option>
                            <?php
                            $cont = 1;
                            foreach ($Methods as $Method) {
                                ?>
                                <option value="<?php echo $Method['Id']; ?>"><?php echo $cont . ". " . $Method['NombreClase']; ?></option>
                                <?php
                                $cont++;
                            }
                            ?>
                        </select>
                        <button type="button" id="btnAddControllerToList" class="btn btn-success btn-number" data-type="plus" style="padding: 5px;"><i class="fa fa-plus"></i></button>
                        <label>
                            <input type="checkbox" id="check"> Ejecutar proceso completo
                        </label>
                    </div>
                    <div class="form-group DynamicSelectAgency">
                    </div>                    
                    <div class="form-group DynamicSelectParam">
                    </div>
                    <div class="container" style="padding-bottom: 10px;">
                        <button type="button" id="btnExecuteProcess" class="btn btn-primary">Ejecutar</button>
                    </div>
                    <div class="container">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Servicio</th>
                                        <th>Agencia(s)</th>
                                        <th>Parametro(s)</th>
                                        <th>Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody id="ListSummary">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="panel-footer">
            <small>Altipal - <?php echo date("Y"); ?></small>
        </div>
    </div>
</body>
<script src="js/procesoAltipal/ProcesoAltipal.js"></script>
<?php $this->renderPartial('//mensajes/_alerta'); ?>
<?php $this->renderPartial('//mensajes/_alertaCargando'); ?>
<?php $this->renderPartial('//mensajes/_alertSuccessGeneric'); ?>
<?php $this->renderPartial('//mensajes/_alertConfirmationGeneric'); ?>