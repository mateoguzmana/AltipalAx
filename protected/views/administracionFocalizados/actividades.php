  
<div class="pageheader">
    <h2>        
        <img src="images/home.png" alt="Ir al menu" class="cursorpointer saliractividad" id=""  style="width: 38px; margin-right: 15px; margin-left: 15px;"/> 
        Menu Actividades <span></span></h2>      
</div>



<div class="contentpanel">

    <div class="panel panel-default">



        <div class="panel-body" style="min-height: 450px;">
            <div class="widget widget-blue">
                <div class="widget-content">

                    <div class="mb40"></div>

                    <div class="col-sm-8 col-sm-offset-2">

                        <div class="panel-body">

                            <div class="row">

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Fecha Inicial:</label>
                                    <div class="col-sm-6">
                                        <input type="text"  class="form-control" id="fechaini"/>
                                    </div>
                                </div>
                                <div id="ErroFechaini" class="col-md-offset-5"></div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Fecha Final:</label>
                                    <div class="col-sm-6">
                                        <input type="text"  class="form-control" id="fechafin"/>
                                    </div>
                                </div>
                                <div id="ErroFechaFin" class="col-md-offset-5"></div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Agencia:</label>
                                    <div class="col-sm-6">
                                        <select id="agencia" class="form-control chosen-select  ChangeZonasVentas">
                                            <option value="0">Seleccione una agencia</option>
                                            <?php foreach ($Agencias as $itemAgencia): ?> 
                                                <option value="<?php echo $itemAgencia['CodAgencia'] ?>"><?php echo $itemAgencia['Nombre'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div id="ErroAgencia" class="col-md-offset-5"></div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Zona Ventas :</label>
                                    <div class="col-sm-6">
                                        <div id="zonaventas" class="CargarClientes">
                                            <select id="zonaVentas" class="form-control chosen-select">
                                                <option value="0">Seleccione una zona ventas</option>

                                            </select>
                                        </div>
                                    </div>  
                                </div>
                                <div id="ErrozonaVentas" class="col-md-offset-5"></div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Clientes:</label>
                                    <div class="col-sm-6">
                                        <div id="cuentacliente" class="CargarActividad">
                                            <select id="clientes" class="form-control chosen-select">
                                                <option value="0">Seleccione un cliente</option>
                                            </select>
                                        </div>                                            
                                    </div>
                                </div>
                                <div id="Errocliente" class="col-md-offset-5"></div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Descripcion:</label>
                                    <div class="col-sm-6">
                                        <textarea id="descripcion" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div id="Errordescripcion" class="col-md-offset-5"></div>


                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Inversion Actividad:</label>
                                    <div class="col-sm-6">
                                        <input type="text" id="inversionactividad" class="form-control">
                                    </div>
                                </div>
                                 <div id="Errorinversion" class="col-md-offset-5"></div>




                                <div  class="row">
                                    <div class="col-sm-6 col-sm-offset-5">
                                        <input type="button" class="btn btn-primary" id="btnGuardarActividad" value="Guardar Actividad"> 
                                    </div>
                                </div>
                            </div> 
                            <br>
                            <div class="row">
                                <div class="table-responsive">
                                    <table  id="DatosActividades" class="table table-bordered">
                                        <thead>
                                            <tr style="background-color: #8DB4E2; font-size: 14px;">
                                                <th class="text-center">Codigo Zona Ventas</th>
                                                <th class="text-center">Cuenta Cliente</th>
                                                <th class="text-center">Fecha Inicio</th>
                                                <th class="text-center">Fecha Final</th>
                                                <th class="text-center">Descripcion</th>
                                                <th class="text-center">Inversion</th>
                                                <th class="text-center">Ejecucion</th>
                                            </tr>        
                                        </thead>
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

<?php $this->renderPartial('//mensajes/_alerta');?>
<?php $this->renderPartial('//mensajes/_alertConfirmarSemana');?>
<?php $this->renderPartial('//mensajes/_alertaSuccesPermisosPaginaWeb');?>