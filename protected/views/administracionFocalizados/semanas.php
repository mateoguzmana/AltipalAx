  
<div class="pageheader">
    <h2>        
        <img src="images/home.png" alt="Ir al menu" class="cursorpointer salirsemana" style="width: 38px; margin-right: 15px; margin-left: 15px;"/> 
        Menu Semanas <span></span></h2>      
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
                                        <label class="col-sm-offset-1 control-label"> * El rango para la semana no debe ser menor a 1 dia ni mayor a 15 dias</label>
                                    </div>
                                    <br>

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
                                        <label class="col-sm-4 control-label">Semana:</label>
                                        <div class="col-sm-6">
                                            <select id="semana" class="form-control chosen-select">
                                                <option value="0">Seleccione una semana</option>
                                                <option value="1">Semana 1</option>
                                                <option value="2">Semana 2</option>
                                                <option value="3">Semana 3</option>
                                                <option value="4">Semana 4</option>
                                                <option value="5">Semana 5</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="ErroFechaFin" class="col-md-offset-5"></div>

                                    <div  class="row">
                                        <div class="col-sm-6 col-sm-offset-5">
                                            <input type="button" class="btn btn-primary" id="btnGuardarSemanas" value="Agregar Semana"> 
                                        </div>
                                    </div>
                                </div> 
                                <br>

                                <!--<div class="row">-->
                                    <!--<div class="col-md-12">-->
                                         <div class="row">
                                            <select id="ano" class="form-control chosen-select" style="width: 200px;">
                                                <option value='0'>Seleccione un año</option>
                                                <option value='2015'>2015</option>
                                                <option value='2016'>2016</option>
                                            </select>
                                        </div>
                                    <br>
                                        <div class="row">
                                            <select id="mes" class="form-control chosen-select Buscar" style="width: 200px;">
                                                <option value='0'>Seleccione un mes</option>
                                                <option value='1'>Enero</option>
                                                <option value='2'>Febrero</option>
                                                <option value='3'>Marzo</option>
                                                <option value='4'>Abril</option>
                                                <option value='5'>Mayo</option>
                                                <option value='6'>Junio</option>
                                                <option value='7'>Julio</option>
                                                <option value='8'>Agosto</option>
                                                <option value='9'>Septiembre</option>
                                                <option value='10'>Octubre</option>
                                                <option value='11'>Noviembre</option>
                                                <option value='12'>Diciembre</option>
                                            </select>
                                        </div>
                                    <!--</div>-->
                                <!--</div>-->
                                <br>

                                <div class="row">
                                    <div class="table-responsive">
                                        <table  id="DatosSemana" class="table table-bordered">
                                            <thead>
                                                <tr style="background-color: #8DB4E2; font-size: 14px;">
                                                     <th class="text-center">Año</th>
                                                    <th class="text-center">Mes</th>
                                                    <th class="text-center"># Semana</th>
                                                    <th class="text-center">Fecha Inicio</th>
                                                    <th class="text-center">Fecha Final</th>
                                                    <th class="text-center">Hora</th>
                                                    <th class="text-center">Fecha</th>
                                                    <th class="text-center">Usuario</th>
                                                    <th class="text-center"></th>
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


