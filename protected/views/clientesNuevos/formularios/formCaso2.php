<?php 
  
?>
<style>
   /* .tab-content > .tab-pane {
        display: block !important;
    }*/

</style>


<div class="row">          
    <div class="col-md-12">
        <form class="form-horizontal" action="" id="frm-cliente-nuevo" method="post" name="frm-cliente-nuevo">


            <div class="panel panel-primary ">             

                <div class="panel-heading text-center">                
                    <h4 class="panel-title">Crear Cliente</h4>               
                </div>
                <div class="panel-body">

                    <div class="col-md-8 col-md-offset-2"> 

                        <div class="tab-content">
                            <div class="widget-bloglist tab-pane active" id="frm-registrar">	              

                                <h4 class="text-center">Paso 1 - 3 Datos personales</h4>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Tipo de Documento <span class="asterisk">*</span></label>
                                    <div class="col-sm-6">
                                        <select required="" class="form-control " name="clienteNuevo[tipoIdentificacion]" id="tipoIdentificacion">
                                            <option value="">Tipo</option>
                                            <?php
                                            $tipoDocumento = Consultas::model()->getTipoDocumento();
                                            if ($tipoDocumento) {
                                                foreach ($tipoDocumento as $itemTipoDocumento) {
                                                    ?>
                                                    <option value="<?php echo $itemTipoDocumento['Codigo']; ?>"><?php echo $itemTipoDocumento['Nombre']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                        <label for="name" class="error" style="display: none" id="errorTipoIdentificacion"></label>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Nit/Cedula<span class="asterisk">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" required="" placeholder="" class="form-control" name="clienteNuevo[nitCedula]" id='nitCedula'>
                                        <label for="name" class="error" style="display: none" id="errorNitCedula"></label>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Código CIIU</label>
                                    <div class="col-sm-6">
                                        <select class="chosen-select" name="clienteNuevo[codigoCiuu]" data-placeholder="Codigo Ciiu" id="codigoCiiu">
                                            <option value=""></option>
                                        <?php
                                        $codigoCiiu = Ciiu::model()->findAll();
                                        if ($codigoCiiu) {
                                            foreach ($codigoCiiu as $item) {
                                                ?>   
                                                    <option value="<?php echo $item['CodigoCIIU'] ?>"><?php echo $item['NombreCIIU'] ?></option>                  
                                                    <?php
                                                }
                                            }
                                            ?>                 
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group" id="groupNombreRazonSocial">
                                    <label class="col-sm-4 control-label">Nombre y/o razón social<span class="asterisk">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" required="" placeholder="" class="form-control" name="clienteNuevo[nombreRazonSocial]" id="nombreRazonSocial">
                                        <label for="name" class="error" style="display: none" id="errorNombreRazonSocial"></label>
                                    </div>
                                </div>

                                <div class="form-group" id="groupEstablecimiento">
                                    <label class="col-sm-4 control-label">Establecimiento <span class="asterisk">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" required="" placeholder="" class="form-control" name="clienteNuevo[establecimiento]" id="establecimiento">
                                        <label for="name" class="error" style="display: none" id="errorNombreRazonSocial"></label>
                                    </div>
                                </div>

                                <div class="form-group" id="groupPrimerNombre">
                                    <label class="col-sm-4 control-label">Primer Nombre<span class="asterisk">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" required="" placeholder="" class="form-control" name="clienteNuevo[primerNombre]" id="primerNombre">
                                        <label for="name" class="error" style="display: none" id="errorPrimerNombre"></label>
                                    </div>
                                </div>

                                <div class="form-group" id="groupSegundoNombre">
                                    <label class="col-sm-4 control-label">Segundo Nombre</label>
                                    <div class="col-sm-6">
                                        <input type="text" required="" placeholder="" class="form-control" name="clienteNuevo[segundoNombre]" id="segundoNombre">
                                        <label for="name" class="error" style="display: none" id="errorSegundoNombre"></label>
                                    </div>
                                </div>

                                <div class="form-group" id="groupPrimerApellido">
                                    <label class="col-sm-4 control-label">Primer Apellido<span class="asterisk">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" required="" placeholder="" class="form-control" name="clienteNuevo[primerApellido]" id="primerApellido">
                                        <label for="name" class="error" style="display: none" id="errorPrimerApellido"></label>
                                    </div>
                                </div>

                                <div class="form-group" id="groupSegundoApellido">
                                    <label class="col-sm-4 control-label">Segundo Apellido<span class="asterisk">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" required="" placeholder="" class="form-control" name="clienteNuevo[segundoApellido]" id="segundoApellido">
                                        <label for="name" class="error" style="display: none" id="errorSegundoApellido"></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Departamento<span class="asterisk">*</span></label>
                                    <div class="col-sm-6">

                                        <select required="" class="form-control" id="Departamentos" name="clienteNuevo[departamentos]" data-zona-ventas="<?php echo $zonaVentas; ?>" data-ruta="<?php echo $rutaSeleccionada;?>">
                                            <option value="">Departamentos</option>
                                            <?php
                                           
                                            if ($departamentosZona) {
                                                foreach ($departamentosZona as $itemDepartamentos) {
                                                    ?>
                                                    <option value="<?php echo $itemDepartamentos['CodigoDepartamento']; ?>"><?php echo $itemDepartamentos['NombreDepartamento']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>                      
                                        </select> 
                                        <label for="name" class="error" style="display: none" id="errorDepartamentos"></label>                   
                                    </div>
                                    <div class="col-sm-1" id="img-cargar-departamento">

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Ciudad<span class="asterisk">*</span></label>
                                    <div class="col-sm-6">
                                        <select required="" class="form-control" id="Ciudades" name="clienteNuevo[ciudades]" data-zona-ventas="<?php echo $zonaVentas; ?>" data-ruta="<?php echo $rutaSeleccionada;?>">
                                            <option value="">Ciudades<span class="asterisk">*</span></option>                                         
                                        </select>
                                        <label for="name" class="error" style="display: none" id="errorCiudades"></label>
                                    </div>
                                    <div class="col-sm-1" id="img-cargar-ciudades">

                                    </div>
                                </div>     

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Barrio<span class="asterisk">*</span></label>
                                    <div class="col-sm-6">
                                        <select required="" class="form-control" id="Barrios" name="clienteNuevo[barrios]">
                                            <option value="">Barrios</option>                                      
                                        </select>
                                        <label for="name" class="error"style="display: none" id="errorBarrios"></label>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Dirección<span class="asterisk">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="clienteNuevo[direccion]" id="direccion">
                                        <label for="name" class="error" style="display: none" id="errorDireccion"></label>
                                    </div>
                                </div>  


                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Teléfono<span class="asterisk">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="clienteNuevo[telefono]" id="telefono">
                                        <label for="name" class="error" style="display: none" id="errorTelefono"></label>
                                    </div>
                                </div>  

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Teléfono 1</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="clienteNuevo[telefono1]" id="telefono1">
                                        <label for="name" class="error" style="display: none" id="errorTelefono1"></label>
                                    </div>
                                </div>                  


                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Teléfono Móvil<span class="asterisk">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="clienteNuevo[telefonoMovil]" id="telefonoMovil">
                                        <label for="name" class="error" style="display: none" id="errorTelefonoMovil"></label>
                                    </div>
                                </div>  


                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Correo Electrónico</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="clienteNuevo[correo]" id="">
                                        <label for="name" class="error" style="display: none" id="errorCorreo"></label>
                                    </div>
                                </div>  

                                <div class="panel-footer">
                                    <div class="row">
                                        <div class="col-sm-9 col-sm-offset-3 text-center"> 
                                            <!-- evento funciones.js -->                   	                
                                            <input type="button" id="cargar-formulario-segmentos" class="btn btn-primary" value="Siguiente" />                
                                        </div>
                                    </div>
                                </div>




                            </div><!-- tab-pane -->

                            <div class="widget-bloglist tab-pane" id="frm-segmentos">



                                <h4 class="text-center">Paso 2 - 3 Segmentos</h4>

                                <div class="form-group">

                                    <div class="cols-sm-12">
                                    <?php
                                    $pregunta = Consultas::model()->getPreguntasEncuestaId('1');
                                    ?>  
                                        <div id="contenido-pregunta">
                                            <h5 id="pregunta-titulo" data-pregunta="<?php echo $pregunta[0]['IdPregunta']; ?>"><?php echo $pregunta[0]['pregunta'] ?></h5>                                                  
                                            <table class="table table-striped" id="pregunta-respuesta">
                                        <?php foreach ($pregunta as $itemPreguntas) { ?>  
                                                    <tr>
                                                        <td>
                                                            <span class="glyphicon glyphicon-question-sign"></span>   
                                        <?php echo $itemPreguntas['respuesta']; ?>
                                                        </td>
                                                        <td><?php
                                                            if ($itemPreguntas['IdCampo'] == 1) {
                                                                ?>
                                                                <input data-respuesta="<?php echo $itemPreguntas['IdRespuesta']; ?>" data-siguiente-pregunta="<?php echo $itemPreguntas['IdSiguientePregunta']; ?>" type="radio" name="clienteNuevo[respuesta]" value="<?php echo $itemPreguntas['IdRespuesta']; ?>" class="item-respuestas" /><br>
                                                                <?php
                                                            }
                                                            ?>                                                          
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </table>                                                  
                                        </div>


                                        <input type="button" id="cargarPregunta" class="btn btn-primary" value="Siguiente" /> 
                                        <div id="resultadoAjaxSegmento"></div>
                                        <div id="resultadoAjaxPregunta"></div>
                                    </div>

                                </div>


                            </div>


                            <div class="widget-bloglist tab-pane" id="frm-enrutar">

                                <h4 class="text-center">Paso 3 - 3  Enrutar</h4>


                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Frecuencia de visita<span class="asterisk">*</span></label>
                                    <div class="col-sm-6">
                                        <select required="" class="form-control" id="frecuenciaVisita" name="clienteNuevo[frecuenciaVisita]">
                                            <option value="">Frecuencia</option> 
                                            <option value="S">Semanal</option>     
                                            <option value="Q">Quincenal</option>   
                                            <option value="M">Mensual</option>                                            
                                        </select>
                                        <label for="name" class="error" style="display: none" id="errorFrecuencia"></label>
                                    </div>
                                    <div class="col-sm-1" id="img-cargar-ciudades">

                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Día de visita:</label>
                                    <div class="col-sm-6">
                                        <div id=""></div>
                                        <input type="text" id="datepicker-inline" class="form-control"/>
                                    </div>			                  	
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Frecuencia visita<span class="asterisk">*</span></label>

                                    <div class="col-sm-6" id="">
                                        <table class="table table-hover">
                                            <tr>
                                                <th class="text-center">Número Visita</th>
                                                <th>R1</th>
                                                <th>R2</th>
                                                <th>R3</th>
                                                <th>R4</th>
                                            </tr>
                                            <tr>
                                                <td class="text-center" id="rs-numero-visita"></td>
                                                <td id="rs-r1"></td>
                                                <td id="rs-r2"></td>
                                                <td id="rs-r3"></td>
                                                <td id="rs-r4"></td>

                                            </tr>
                                        </table>
                                    </div>

                                    <input type="hidden" value="" name="clienteNuevo[numeroVisita]" id="numeroVisita"/>
                                    <div class="col-sm-2" id="img-cargar-rutas"></div>
                                </div>   


                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Hora de visita:<span class="asterisk">*</span></label>

                                    <div class="col-sm-6" id="">
                                        <div class="input-group mb15">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                            <div class="bootstrap-timepicker">
                                                <input type="text" class="form-control" id="timepicker">
                                                <div class="bootstrap-timepicker-widget dropdown-menu">
                                                    <table>
                                                        <tbody>
                                                            <tr>
                                                                <td><a data-action="incrementHour" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td><a data-action="incrementMinute" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a></td><td class="separator">&nbsp;</td><td class="meridian-column"><a data-action="toggleMeridian" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a></td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <input type="text" maxlength="2" class="form-control bootstrap-timepicker-hour" name="clienteNuevo[horas]">
                                                                </td><td class="separator">:</td><td>
                                                                    <input type="text" maxlength="2" class="form-control bootstrap-timepicker-minute" name="clienteNuevo[minutos]">
                                                                </td><td class="separator">&nbsp;</td><td>
                                                                    <input type="text" maxlength="2" class="form-control bootstrap-timepicker-meridian" name="clienteNuevo[meridian]">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><a data-action="decrementHour" href="#"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator"></td><td><a data-action="decrementMinute" href="#"><i class="glyphicon glyphicon-chevron-down"></i></a></td><td class="separator">&nbsp;</td><td><a data-action="toggleMeridian" href="#"><i class="glyphicon glyphicon-chevron-down"></i></a></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2" id="img-cargar-rutas"></div>
                                </div>  

                                <div class="panel-footer">
                                    <div class="row">
                                        <div class="col-sm-9 col-sm-offset-3 text-center">                    

                                            <input type="button" id="cargar-formulario-segmentos-back" class="btn btn-primary" value="Encuesta de Segmentación" />  
                                            <input type="button" name="crearClienteNuevo" id="crearClienteNuevo" class="btn btn-primary" value="Crear cliente" /> 


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>                  
                </div>
            </div><!-- panel-body -->    
         </form>    
    </div><!-- panel -->        

      

</div><!-- col-md-6 -->       



<!-------------------------Mensajes---------------------------------------------->

<!-- Modal -->

<div class="modal fade" id="alertaEnrutar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
  <div class="modal-dialog modal-dialog-message">
    <div class="modal-content">
      <div class="modal-header">
        
        <h5 class="modal-title" id="myModalLabel">Mensaje Cliente Nuevo</h5>
      </div>
      <div class="modal-body ">
      	<div class="row">
      		<div class="col-sm-2">      			
      			<span class="fa fa-exclamation-triangle" style="font-size: 40px; color: #D9534F;"></span>
      		</div>
      		<div class="col-sm-10">
      			<p class="text-modal-body">El cliente es atendido por un asesor del mismo grupo de ventas</p>
      		</div>
      	</div>
        
      </div>
      <div class="modal-footer">
      	
        <button type="button" class="btn btn-default btn-small-template" id="cerrarAlertaEnrutar">Aceptar</button>        
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->


<div class="modal fade" id="alertaEnrutarNuevo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id="myModalLabel">Mensaje Cliente Nuevo</h5>
            </div>
            <div class="modal-body ">
                <div class="row">
                    <div class="col-sm-2">  
                        <span class="glyphicon glyphicon-exclamation-sign" style="font-size: 40px; color: #F0AD4E;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body">"Recuerde que esta opción solo se debe utilizar para crear un nuevo establecimiento con una dirección diferente a los mostrados anteriormente" <br/> Desea continuar con la creación del establecimiento?</p>
                        
                    </div>
                </div>

            </div>
            <div class="modal-footer">         	
                <button type="button" class="btn btn btn-small-template" id="redirectClienteNuevo">Cancelar</button>  
                <button type="button" class="btn btn-primary btn-small-template" data-dismiss="modal">Crear Cliente</button> 
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="alertaFrecuenciaNoSeleccionada" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id="myModalLabel">Mensaje Crear Cliente</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: #D9534F;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body" id="mensaje-error">No se ha seleccionado una frecuencia para crear la ruta</p>
                    </div>
                </div>

            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-default btn-small-template" data-dismiss="modal">Cerrar</button>        
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->


<!-- Modal -->
<div class="modal fade" id="alertaPreguntaNoSeleccionada" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id="myModalLabel">Mensaje Encuesta Cliente</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: #D9534F;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body" id="mensaje-error">No se ha seleccionado una respuesta!</p>
                    </div>
                </div>

            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-default btn-small-template" data-dismiss="modal">Cerrar</button>        
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->
