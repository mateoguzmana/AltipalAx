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
            LOG PROCESO DE ACTUALIZACION</h2>      
    </div>
    <title>LOG PROCESO DE ACTUALIZACION</title>
    <div class="panel panel-default" style="padding: 10px;">
        <div class="panel-body">
            <div class="panel-heading">
                <div align="center">
                    <div class="row">
                        <div class="col-md-3 col-md-offset-2 text-center">
                            <div class="form-group">
                                <label>Fecha Inicial</label>
                                <div aling="center">
                                    <input style="height: 36px;" type="text" class="form-control" id="fechaini" value = "<?php echo date('Y-m-d') ?>"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="form-group">
                                <label>Fecha Final</label>
                                <div>
                                    <input style="height: 36px;" type="text" class="form-control" id='fechafin' value = "<?php echo date('Y-m-d') ?>"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="form-group">
                                <label></label>
                                <div>
                                    <input type="button" class="btn btn-primary" onclick="Search()" style="height: 25px; width: 100px;" value="Buscar" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <div class="table-responsive" id="tablaerrores">
                    <table class="table table-bordered" id="tbllogproceso">
                        <thead>
                            <tr style="background-color: #8DB4E2;">
                                <th>#</th>
                                <th>Cedula</th>
                                <th>Nombre</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Tipo de ejecucion</th>
                                <th>Detalles</th>
                            </tr>
                        </thead>
                        <tbody id="ListSummary">                            
                            <?php
                            $cont = 1;
                            foreach ($Methods as $Method) {
                                ?>
                                <tr>
                                    <td><?php echo $cont; ?></td>
                                    <td><?php echo $Method['Cedula']; ?></td>
                                    <td><?php echo $Method['Nombre']; ?></td>
                                    <td><?php echo $Method['FechaInicio']; ?></td>
                                    <td><?php echo $Method['HoraInicio']; ?></td>
                                    <td><?php if ($Method['NombreClase'] == "") {echo "Servicio(s) con parametros"; }else if($Method['IdControlador'] == 0){echo "Proceso Completo";}else{echo "Servicio Completo: ".$Method['NombreClase'];} ?></td>
                                    <td><?php if ($Method['NombreClase'] == "") {?><a onclick="LogDetails(<?php echo $Method['Id']; ?>)" class="btn btn-default"><span class="glyphicon glyphicon-list"></span></a><?php } ?></td>
                                </tr>
                                <?php
                                $cont++;
                            }
                            ?>                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <small>Altipal - <?php echo date("Y"); ?></small>
        </div>
    </div>
</body>
<script src="js/logEjecucionProcesos/LogEjecucionProcesos.js"></script>
<?php $this->renderPartial('//mensajes/_alerta'); ?>
<?php $this->renderPartial('//mensajes/_alertaCargando'); ?>
<?php $this->renderPartial('//mensajes/_modalGeneric'); ?>
<?php $this->renderPartial('//mensajes/_modalGeneric2'); ?>