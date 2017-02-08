  
<div class="pageheader">
    <h2>        
        <img src="images/home.png" alt="Ir al menu" class="cursorpointer salircorreo" style="width: 38px; margin-right: 15px; margin-left: 15px;"/> 
        Correo Pedidos Cliente-Nuevo <span></span></h2>      
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
                                    <label class="col-sm-4 control-label">Nombre:</label>
                                    <div class="col-sm-6">
                                        <input type="text"  class="form-control" id="nombre"/>
                                    </div>
                                </div>
                                <div id="ErrorNombre" class="col-md-offset-5" style="color: red"></div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Apellido:</label>
                                    <div class="col-sm-6">
                                        <input type="text"  class="form-control" id="apellido"/>
                                    </div>
                                </div>
                                <div id="ErrorApell" class="col-md-offset-5" style="color: red"></div>


                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Correo Electronio:</label>
                                    <div class="col-sm-6">
                                        <input type="text"  class="form-control" id="correo"/>
                                    </div>
                                </div>
                                <div id="ErrorCorreo" class="col-md-offset-5" style="color: red"></div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Agencia:</label>
                                    <div class="col-sm-6">
                                        <select id="SelectAgencia" name="Agencia" class="form-control chosen-select" data-placeholder="Seleccione una agencia">
                                            <option value=""></option>
                                            <?php foreach ($Agencias as $tiem) { ?>
                                                <option value="<?php echo $tiem['CodAgencia'] ?>"><?php echo $tiem['Nombre'] ?></option>

                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div id="ErroAgencia" class="col-md-offset-5" style="color: red"></div>

                                <div  class="row">
                                    <div class="col-sm-6 col-sm-offset-5">
                                        <input type="button" class="btn btn-primary" id="btnGuardarCorreo" value="Agregar Correo"> 
                                    </div>
                                </div>
                            </div> 
                            <br>
                            <br>
                            <hr/>
                            <h4> Configuracion de correos</h4>
                            <br>
                            <div class="row">
                                <div class="table-responsive">
                                    <table  id="DatosCorreo" class="table table-bordered">
                                        <thead>
                                            <tr style="background-color: #8DB4E2; font-size: 14px;">
                                                <th class="text-center">Nombres</th>
                                                <th class="text-center">Apellidos</th>
                                                <th class="text-center">Correo Electronico</th>
                                                <th class="text-center">Estado</th>
                                               <!-- <th class="text-center">Nombre Proveedor</th>-->
                                                <th class="text-center">Agencia</th>
                                                <th></th>
                                                <th></th>
                                            </tr>        
                                        </thead>
                                    </table> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="widget-content">                 
                    <div class="mb30"></div>
                    <div class="col-sm-8 col-sm-offset-2">
                        <div class="panel-body">
                            <br>
                            <br>
                            <hr/>
                            <h4> Valor pedido minimo Cliente-Nuevo</h4>
                            <br>
                            <div class="row">
                                <div class="table-responsive">
                                    <table  id="DatosPedidoMaximo" class="table table-bordered">
                                        <thead>
                                            <tr style="background-color: #8DB4E2; font-size: 14px;">
                                                <th class="text-center">Valor</th>
                                                <th class="text-center">Fecha Registro</th>
                                                <th></th>
                                            </tr>        
                                        </thead>
                                        <tbody>
                                            <?php foreach ($pedidoMaximo as $itemPedidoMaximo) { ?>
                                                <tr>
                                                    <td class="text-center"> <?php echo $itemPedidoMaximo['Valor'] ?></td>
                                                    <td class="text-center"> <?php echo $itemPedidoMaximo['Fecha'] . " " . $itemPedidoMaximo['Hora'] ?></td>
                                                    <td class="text-center"> <input type="button" class="btn btn editarpedidomaximo"  value="EDITAR"  data-id="<?php echo $itemPedidoMaximo['Id'] ?>">
                                                </tr>
                                            <?php } ?>
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

<div class="modal fade draggable-modal" id="Modaleditar" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Editar </h4>
            </div>
            <div class="modal-body" id="editarInfo"></div>
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<?php $this->renderPartial('//mensajes/_alerta'); ?>
<?php $this->renderPartial('//mensajes/_alertaSueccesCorreoVentaDirecta'); ?>
<?php $this->renderPartial('//mensajes/_alertCarg'); ?>
<?php $this->renderPartial('//mensajes/_alertConfirmarAdminUsuario'); ?>

