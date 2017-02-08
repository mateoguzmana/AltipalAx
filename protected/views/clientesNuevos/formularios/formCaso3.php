<style>
   /* .tab-content > .tab-pane {
        display: block !important;
    }*/

</style>



<div class="row">



    <div class="col-md-12">
        <form class="form-horizontal" action="http://themepixels.com/demo/webpage/bracket/form-validation.html" id="basicForm" novalidate="novalidate">


            <div class="panel panel-primary ">             

                <div class="panel-heading text-center">                
                    <h4 class="panel-title">Crear Existente</h4>               
                </div>
                <div class="panel-body">

                    <div class="col-md-8 col-md-offset-2">  



                        <div class="tab-content">
                            <div class="widget-bloglist tab-pane active" id="frm-registrar-4">

                                <h4 class="text-center">Paso 1 - 3 Datos personales</h4>       

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Tipo<span class="asterisk">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" required="" placeholder="" value="<?php echo $datosCliente['Tipo']; ?>" disabled="false" class="form-control" name="Tipo" id="Tipo">
                                        <label for="name" class="error" style="display: none" id="errorTipo"></label>
                                    </div>
                                    <div class="col-sm-1">
                                        <span class="label label-info">Activo</span>
                                    </div>
                                </div>      

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Nit/Cedula<span class="asterisk">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" required="" placeholder="" value="<?php echo $datosCliente['NitCedula']; ?>" disabled="false" class="form-control" name="NitCedula" id="NitCedula">
                                        <label for="name" class="error" style="display: none" id="errorNitCedula"></label>
                                    </div>
                                    <div class="col-sm-1">
                                       
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Codigo Cliente <span class="asterisk">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" required="" placeholder="" value="<?php echo $datosCliente['CodigoCliente']; ?>" disabled="false" class="form-control" name="codigoCliente" id="codigoCliente"/>
                                        <label for="name" class="error" style="display: none" id="errorCodigoCliente"></label>
                                    </div>                  
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Código CIIU <span class="asterisk">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" required="" placeholder="" value="<?php echo $datosCliente['CodigoCiuu']; ?>" <?php if($datosCliente['CodigoCiuu']) echo  'disabled="false"';?> class="form-control" name="CodigoCiuu" id="CodigoCiuu"/>

                                        <label for="name" class="error" style="display: none" id="errorCodigoCiuu"></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Código Zona de Venta<span class="asterisk">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" required="" placeholder="" value="<?php echo $datosCliente['CodigoZonaVenta']; ?>"  class="form-control" name="codigoZonaVenta" id="codigoZonaVenta"/>
                                        <label for="name" class="error" style="display: none" id="errorCodigoZonaVenta"></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Nombre Asesor<span class="asterisk">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" required="" placeholder="" value="<?php echo $datosCliente['NombreAsesor']; ?>"   class="form-control" name="nombreAsesor" id="nombreAsesor"/>
                                        <label for="name" class="error" style="display: none" id="errorNombreAsesor"></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Departamento<span class="asterisk">*</span></label>
                                    <div class="col-sm-6">

                                        <select class="form-control"    name="departamentos" data-zona-ventas="<?php echo $zonaVentas; ?>" data-ruta="<?php echo $rutaSeleccionada;?>">
                                            <option class="" selected readonly><?php echo $datosCliente['Departamento']; ?></option>

                                           <?php                                           
                                            /*if ($departamentosZona) {
                                                foreach ($departamentosZona as $itemDepartamentos) {
                                                    ?>
                                                    <option value="<?php echo $itemDepartamentos['CodigoDepartamento']; ?>"><?php echo $itemDepartamentos['NombreDepartamento']; ?></option>
                                                    <?php
                                                }
                                            }*/
                                            ?>   
                                        </select>                      



                                        <label for="name" class="error" style="display: none" id="errorDepartamento"></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label" >Ciudad<span class="asterisk">*</span></label>
                                    <div class="col-sm-6">
                                        <?php
                                        //$ciudad = Consultas::model()->getNombreCiudad($datosCliente['CodCiudad']);
                                        ?>
                                        <select required="" class="form-control"  id="Ciudades" data-zona-ventas="<?php echo $zonaVentas; ?>" data-ruta="<?php echo $rutaSeleccionada;?>">
                                            <option value="<?php echo $datosCliente['CodCiudad']; ?>"><?php echo $datosCliente['Ciudad']; ?></option>                                        
                                        </select>
                                        <label for="name" class="error" style="display: none" id="errorCiudad"></label>
                                    </div>
                                </div>     

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Barrio<span class="asterisk">*</span></label>
                                    <div class="col-sm-6">
                                        <?php
                                        //$barrio = Consultas::model()->getNombreBarrio($datosCliente['CodBarrio']);
                                        ?>
                                        <select required="" class="form-control"  id="Barrios">
                                            <option value="<?php echo $datosCliente['CodBarrio']; ?>"><?php echo $datosCliente['Barrio']; ?></option>                                        
                                        </select>
                                        <label for="name" class="error" style="display: none" id="errorBarrio"></label>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Dirección<span class="asterisk">*</span></label>
                                    <div class="col-sm-6">

                                        <input type="text" required="" placeholder="" value="<?php echo $datosCliente['Direccion']; ?>"  class="form-control" name="Direccion" id="Direccion">
                                        <label for="name" class="error" style="display: none" id="errorDireccion"></label>
                                    </div>
                                </div>  


                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Teléfono<span class="asterisk">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" required="" placeholder="" value="<?php echo $datosCliente['Telefono']; ?>"  class="form-control" name="Telefono" id="Telefono">
                                        <label for="name" class="error" style="display: none" id="errorTelefono"></label>
                                    </div>
                                </div>  


                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Teléfono Móvil</label>
                                    <div class="col-sm-6">
                                        <input type="text" required="" placeholder="" value="<?php echo $datosCliente['TelefonoMovil']; ?>"  class="form-control" name="TelefonoMovil" id="TelefonoMovil">
                                        <label for="name" class="error" style="display: none" id="errorTelefonoMovil"></label>
                                    </div>
                                </div>  


                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Correo Electrónico</label>
                                    <div class="col-sm-6">
                                        <input type="text" required="" placeholder="" value="<?php echo $datosCliente['CorreoElectronico']; ?>" class="form-control" name="CorreoElectronico" id="">
                                        <label for="name" class="error" style="display: none" id="errorCorreoElectronico"></label>
                                    </div>
                                </div>  



                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Codigo Grupo de Ventas<span class="asterisk">*</span><span class="asterisk">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" value="<?php echo $datosCliente['CodigoGrupoVentas']; ?>" name="grupoVentas" id="grupoVentas">
                                        <label for="name" class="error" style="display: none" id="errorGrupoVentas"></label>
                                    </div>
                                </div> 

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Nombre Grupo de Ventas<span class="asterisk">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" value="<?php echo $datosCliente['NombreGrupoVentas']; ?>"  name="nombreGrupoVentas" id="nombreGrupoVentas">
                                        <label for="name" class="error" style="display: none" id="errorNombreGrupoVentas"></label>
                                    </div>
                                </div>     



                                <div class="panel-footer">
                                    <div class="row">
                                        <div class="col-sm-9 col-sm-offset-3 text-center">  

                                            <input type="button" id="cargar-formulario-segmentos-4" class="btn btn-primary" value="Siguiente" />                
                                        </div>
                                    </div>
                                </div>




                            </div><!-- tab-pane -->

                            <div class="widget-bloglist tab-pane" id="frm-segmentos-4">

                                <h4 class="text-center">Paso 2 - 3 Segmentos</h4>

                              
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Segmentos<span class="asterisk">*</span></label>
                                    <div class="col-sm-6">
                                        <select required="" class="form-control " disabled="false" name="segmentoCliente" id="segmentoCliente">
                                            <option value="">Segmentos</option>
                                            <?php
                                            $segmentos = Consultas::model()->getSementos();
                                            if ($segmentos) {
                                                foreach ($segmentos as $itemSegmento) {
                                                    ?>
                                                    <option  value="<?php echo $itemSegmento['CodSegmento']; ?>" <?php
                                                    if ($datosCliente['segmentos'] == $itemSegmento['CodSegmento'])
                                                        echo "selected";
                                                    ?>><?php echo $itemSegmento['Nombre']; ?></option>
                                                         <?php
                                                         }
                                                     }
                                                     ?>
                                        </select>
                                        <label for="name" class="error" style="display: none" id="errorSegmentoCliente"></label>

                                    </div>
                                    <div class="col-sm-1" id="img-cargar-segmentos">

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Sub Segmentos<span class="asterisk">*</span></label>
                                    <div class="col-sm-6">
                                        <select required="" class="form-control " disabled="false" name="tipoIdentificacion" id="subsementoCliente">
                                            <option value="">Sub Segmentos</option>
                                            <?php
                                            $subsementos = Consultas::model()->getSubSementosAll();
                                            if ($subsementos) {
                                                foreach ($subsementos as $itemSubsegmentos) {
                                                    ?>
                                                    <option disabled="false" value="<?php echo $itemSubsegmentos['CodSubSegmento']; ?>" <?php
                                                            if ($datosCliente['subsegmentos'] == $itemSubsegmentos['CodSubSegmento'])
                                                                echo 'Selected';
                                                            ?>><?php echo $itemSubsegmentos['Nombre']; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                        </select>
                                        <label for="name" class="error" style="display: none" id="errorSubsementoCliente"></label>

                                    </div>
                                </div>

                                  <div class="form-group">
                                    <label class="col-sm-4 control-label">Tipo de registro<span class="asterisk">*</span></label>
                                    <div class="col-sm-6">
                                        <select required="" class="form-control " disabled="false" name="tipoRegistroCliente" id="tipoRegistroCliente">
                                            <option value="">Tipo de registro</option>
                                            <?php
                                            $tipoRegistro = Consultas::model()->getTipoResgistro();
                                            if ($tipoRegistro) {
                                                foreach ($tipoRegistro as $itemTipoRegistro) {
                                                    ?>
                                                    <option  value="<?php echo $itemTipoRegistro['CodTipoRegistro']; ?>"  <?php
                                                    if ($datosCliente['tipoRegistro'] == $itemTipoRegistro['CodTipoRegistro'])
                                                        echo "selected";
                                                    ?>><?php echo $itemTipoRegistro['Nombre']; ?></option> 
                                                         <?php
                                                         }
                                                     }
                                                     ?>

                                        </select>
                                        <label for="name" class="error" style="display: none" id="errorTipoRegistroCliente"></label>

                                    </div>
                                </div>



                                <div class="panel-footer">
                                    <div class="row">
                                        <div class="col-sm-9 col-sm-offset-3 text-center">                    

                                            <input type="button" id="cargar-formulario-registrar-4" class="btn btn-primary" value="Formulario registrar" /> 
                                            <input type="button" id="cargar-formulario-enrutar-4" class="btn btn-primary" value="Enrutar cliente" />  

                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="widget-bloglist tab-pane" id="frm-enrutar-4">

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

                                    <input type="hidden" value="" name="numeroVisita" id="numeroVisita"/>

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

                                            <input type="button" id="cargar-formulario-segmentos-back-4" class="btn btn-primary" value="Encuesta de Segmentación" />  
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
                        <p class="text-modal-body">El cliente no se encuentra Enrutado a un asesor del mismo grupo de ventas</p>
                    </div>
                </div>

            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-default btn-small-template" data-dismiss="modal">Cerrar</button>        
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