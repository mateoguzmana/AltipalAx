<style>
    /*.tab-content > .tab-pane {
        display: block !important;
    }*/

</style>



<div class="row">
        
          
          
        <div class="col-md-12">
          <form class="form-horizontal" action=""  method="post" id="frm-cliente-nuevo" novalidate="novalidate">
          
              
          <div class="panel panel-primary ">             
              
              <div class="panel-heading text-center">                
                <h4 class="panel-title">Crear Existente</h4>               
              </div>
              <div class="panel-body">
                  
                  <div class="col-md-8 col-md-offset-2">  
                  	
       
                  	
			    <div class="tab-content">
			    <div class="widget-bloglist tab-pane active" id="frm-registrar">
			              
			          <h4 class="text-center">Paso 1 - 3 Datos personales</h4>       
			           
                              <div class="form-group">
                                    <label class="col-sm-4 control-label">Tipo<span class="asterisk">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" required="" placeholder="" value="<?php echo $datosCliente['Tipo']; ?>" readonly="" class="form-control" name="clienteNuevo[tipoIdentificacion]" id="Tipo">
                                        <label for="name" class="error" style="display: none" id="errorTipo"></label>
                                    </div>
                                    <div class="col-sm-1">
                                       <span class="label label-danger">Inactivo</span>
                                    </div>
                                </div>       
                                  
                                  
			        <div class="form-group">
                  <label class="col-sm-4 control-label">Nit/Cedula<span class="asterisk">*</span></label>
                  <div class="col-sm-6">
                    <input type="text" required="" placeholder="" value="<?php echo $datosCliente['NitCedula']; ?>" readonly="" class="form-control" name="clienteNuevo[nitCedula]" id="NitCedula">
                    <label for="name" class="error" style="display: none" id="errorNitCedula"></label>
                  </div>
                  <div class="col-sm-1">
                  	
                  </div>
                </div>
                 
                <div class="form-group">
                  <label class="col-sm-4 control-label">Codigo Cliente <span class="asterisk">*</span></label>
                  <div class="col-sm-6">
                      <input type="text" required="" placeholder="" value="<?php echo $datosCliente['CodigoCliente']; ?>" readonly="" class="form-control" name="codigoCliente" id="codigoCliente"/>
                    <label for="name" class="error" style="display: none" id="errorCodigoCliente"></label>
                  </div>                  
                </div>
                
                <div class="form-group">
                  <label class="col-sm-4 control-label">Código CIIU <span class="asterisk">*</span></label>
                  <div class="col-sm-6">
                    <input type="text" required="" placeholder="" value="<?php echo $datosCliente['CodigoCiuu']; ?>" <?php if($datosCliente['CodigoCiuu']) echo  'readonly=""';?> class="form-control" name="clienteNuevo[codigoCiuu]" id="CodigoCiuu"/>
                    
                    <label for="name" class="error" style="display: none" id="errorCodigoCiuu"></label>
                  </div>
                </div>
                
                <div class="form-group">
                  <label class="col-sm-4 control-label">Código Zona de Venta<span class="asterisk">*</span></label>
                  <div class="col-sm-6">
                      <input type="text" required="" readonly="" placeholder="" value="<?php echo $datosCliente['CodigoZonaVenta']; ?>"  class="form-control" name="codigoZonaVenta" id="codigoZonaVenta"/>
                    <label for="name" class="error" style="display: none" id="errorCodigoZonaVenta"></label>
                  </div>
                </div>
                
                <div class="form-group">
                  <label class="col-sm-4 control-label">Nombre Asesor<span class="asterisk">*</span></label>
                  <div class="col-sm-6">
                    <input type="text" required="" readonly="" placeholder="" value="<?php echo $datosCliente['NombreAsesor']; ?>"   class="form-control" name="nombreAsesor" id="nombreAsesor"/>
                    <label for="name" class="error" style="display: none" id="errorNombreAsesor"></label>
                  </div>
                </div>
                
                      <div class="form-group">
                  <label class="col-sm-4 control-label">Departamento<span class="asterisk">*</span></label>
                  <div class="col-sm-6">
                      
                      <select required="" class="form-control"  id="Departamentos"  name="clienteNuevo[departamentos]" data-zona-ventas="<?php echo $zonaVentas; ?>" data-ruta="<?php echo $rutaSeleccionada;?>">
                      
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
                    <label for="name" class="error" style="display: none" id="errorDepartamento"></label>
                  </div>
                </div>
                
                 <div class="form-group">
                  <label class="col-sm-4 control-label" >Ciudad<span class="asterisk">*</span></label>
                  <div class="col-sm-6">
                  	<?php 
                       $ciudad=Consultas::model()->getNombreCiudad($datosCliente['CodCiudad']);					  
                      ?>
                      <select required="" class="form-control" name="clienteNuevo[ciudades]"  id="Ciudades" data-zona-ventas="<?php echo $zonaVentas; ?>" data-ruta="<?php echo $rutaSeleccionada;?>">
                      <option value="<?php echo $ciudad['Nombre']; ?>"><?php echo $ciudad['Nombre']; ?></option>                                        
                    </select>
                    <label for="name" class="error" style="display: none" id="errorCiudad"></label>
                  </div>
                </div>     
                      
                <div class="form-group">
                  <label class="col-sm-4 control-label">Barrio<span class="asterisk">*</span></label>
                  <div class="col-sm-6">
                  	<?php 
                       $barrio=Consultas::model()->getNombreBarrio($datosCliente['CodBarrio']);					  
                      ?>
                      <select required="" class="form-control"  id="Barrios" name="clienteNuevo[barrios]">
                      <option value="<?php echo $barrio['Nombre']; ?>"><?php echo $barrio['Nombre']; ?></option>                                        
                    </select>
                    <label for="name" class="error" style="display: none" id="errorBarrio"></label>
                  </div>
                </div>
                  
                  
                <div class="form-group">
                  <label class="col-sm-4 control-label">Dirección<span class="asterisk">*</span></label>
                  <div class="col-sm-6">
                     
                      <input type="text" required="" placeholder="" value="<?php echo $datosCliente['Direccion']; ?>"  class="form-control" name="clienteNuevo[direccion]" id="Direccion">
                      <label for="name" class="error" style="display: none" id="errorDireccion"></label>
                  </div>
                </div>  
                  
                  
                <div class="form-group">
                  <label class="col-sm-4 control-label">Teléfono<span class="asterisk">*</span></label>
                  <div class="col-sm-6">
                      <input type="text" required="" placeholder="" value="<?php echo $datosCliente['Telefono']; ?>"  class="form-control" name="clienteNuevo[telefono]" id="Telefono">
                      <label for="name" class="error" style="display: none" id="errorTelefono"></label>
                  </div>
                </div>  
                  
                 <div class="form-group">
                                    <label class="col-sm-4 control-label">Teléfono 1</label>
                                    <div class="col-sm-6">
                                        <input type="text" value="<?php echo $datosCliente['TelefonoMovil']; ?>" class="form-control" name="clienteNuevo[telefono1]" id="telefono1">
                                        <label for="name" class="error" style="display: none" id="errorTelefono1"></label>
                                    </div>
                </div>                  
                  
                 <div class="form-group">
                  <label class="col-sm-4 control-label">Teléfono Móvil</label>
                  <div class="col-sm-6">
                      <input type="text" required="" placeholder="" value="<?php echo $datosCliente['TelefonoMovil']; ?>"  class="form-control" name="clienteNuevo[telefonoMovil]" id="TelefonoMovil">
                      <label for="name" class="error" style="display: none" id="errorTelefonoMovil"></label>
                  </div>
                </div>  
                  
                
                   <div class="form-group">
                  <label class="col-sm-4 control-label">Correo Electrónico</label>
                  <div class="col-sm-6">
                      <input type="text" required="" placeholder="" value="<?php echo $datosCliente['CorreoElectronico']; ?>"  class="form-control" name="clienteNuevo[correo]" id="CorreoElectronico">
                      <label for="name" class="error" style="display: none" id="errorCorreoElectronico"></label>
                  </div>
                </div>  
                  
                  
                
                   <div class="form-group">
                  <label class="col-sm-4 control-label">Codigo Grupo de Ventas<span class="asterisk">*</span></label>
                  <div class="col-sm-6">
                      <input type="text" readonly="" class="form-control" value="<?php echo $datosCliente['CodigoGrupoVentas']; ?>" name="grupoVentas" id="grupoVentas">
                      <label for="name" class="error" style="display: none" id="errorGrupoVentas"></label>
                  </div>
                </div> 
                
               <div class="form-group">
                  <label class="col-sm-4 control-label">Nombre Grupo de Ventas<span class="asterisk">*</span></label>
                  <div class="col-sm-6">
                      <input type="text" readonly="" class="form-control" value="<?php echo $datosCliente['NombreGrupoVentas']; ?>"  name="nombreGrupoVentas" id="nombreGrupoVentas">
                      <label for="name" class="error" style="display: none" id="errorNombreGrupoVentas"></label>
                  </div>
                </div>     
                     
			       
                
                 <div class="panel-footer">
                <div class="row">
                  <div class="col-sm-9 col-sm-offset-3 text-center">  
                  	                   	                
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
                                        //print_r($pregunta);
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
                                                                <input data-respuesta="<?php echo $itemPreguntas['IdRespuesta']; ?>" data-siguiente-pregunta="<?php echo $itemPreguntas['IdSiguientePregunta']; ?>" type="radio" name="respuesta" value="<?php echo $itemPreguntas['IdRespuesta']; ?>" class="item-respuestas"><br>
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
			                     <select required="" class="form-control" id="frecuenciaVisita" name="frecuenciaVisita">
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
																<input type="text" maxlength="2" class="form-control bootstrap-timepicker-hour" name="hour">
																</td><td class="separator">:</td><td>
																<input type="text" maxlength="2" class="form-control bootstrap-timepicker-minute" name="minute">
																</td><td class="separator">&nbsp;</td><td>
																<input type="text" maxlength="2" class="form-control bootstrap-timepicker-meridian" name="meridian">
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
              </div><!-- panel-body -->             
          </div><!-- panel -->         
          
          </form>
         
        </div><!-- col-md-6 -->    
        
      </div>
      

<!-------------------------Mensajes---------------------------------------------->
<!-- Modal -->
<div class="modal fade" id="alertaEnrutarClienteNoInactivo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
  <div class="modal-dialog modal-dialog-message">
    <div class="modal-content">
      <div class="modal-header">
        
        <h5 class="modal-title" id="myModalLabel">Mensaje Crear Cliente</h5>
      </div>
      <div class="modal-body ">
      	<div class="row">
      		<div class="col-sm-2">
      			<span class="fa fa-exclamation-circle" style="font-size: 40px; color: #F0AD4E;"></span>
      		</div>
      		<div class="col-sm-10">
      			<p class="text-modal-body">El cliente esta inactivo</p>
      		</div>
      	</div>
        
      </div>
      <div class="modal-footer">
      	
        <button type="button" class="btn btn-default btn-small-template" data-dismiss="modal">Aceptar</button>        
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->

   <!-------------------------Mensajes---------------------------------------------->
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