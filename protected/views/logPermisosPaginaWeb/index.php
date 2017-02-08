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
            LOG PERMISOS PAGINA WEB</h2>      
    </div>
    <title>LOG PERMISOS PAGINA WEB</title>
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
                                <th>Agencia</th>
                                <th>Zona de ventas</th>
                                <th>Fecha Inicio de activacion</th>
                                <th>Fecha final de activacion</th>
                                <th>Motivo de activacion</th>
                            </tr>
                        </thead>
                        <tbody id="ListSummary">                            
                            <?php
                            $cont = 1;
                            foreach ($LogPermissions as $LogPermission) {
                                ?>
                                <tr>
                                    <td><?php echo $cont; ?></td>
                                    <td><?php echo $LogPermission['Cedula']; ?></td>
                                    <td><?php echo $LogPermission['Nombre']; ?></td>
                                    <td><?php echo $LogPermission['Fecha']; ?></td>
                                    <td><?php echo $LogPermission['Agencia']; ?></td>
                                    <td><?php echo $LogPermission['CodZonaVentas']; ?></td>
                                    <td><?php echo $LogPermission['FechaInicial']; ?></td>
                                    <td><?php echo $LogPermission['FechaFinal']; ?></td>
                                    <td><?php echo $LogPermission['Observacion']; ?></td>
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
    </div>
</body>
<script src="js/logPermisosPaginaWeb/LogPermisosPaginaWeb.js"></script>
<?php $this->renderPartial('//mensajes/_alerta'); ?>
<?php $this->renderPartial('//mensajes/_alertaCargando'); ?>
<?php $this->renderPartial('//mensajes/_modalGeneric'); ?>
<?php $this->renderPartial('//mensajes/_modalGeneric2'); ?>