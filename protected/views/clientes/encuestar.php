<div id="NuevaPregunta">
    <div class="contentpanel">
        <form id="form1" class="form-horizontal" enctype="multipart/form-data">
            <div class="panel panel-default">
                <h5 id="pregunta-titulo"></h5>                                                  
                <table class="table table-striped" id="pregunta-respuesta">

                    <?php $RespuestasPregunta = ClientesRuta::model()->getRespuestas($PreguntaEncuesta[0]['IdPregunta']); ?>
                    <?php $FotosPregunta = ClientesRuta::model()->getfotosPreguntas($PreguntaEncuesta[0]['IdTituloEncuesta'], $PreguntaEncuesta[0]['IdPregunta']); ?>        
                    <tr>
                        <td class="text-center">
                            <?php echo $PreguntaEncuesta[0]['Pregunta']; ?> <span class="glyphicon glyphicon-question-sign"></span>
                            <input type="hidden" value="<?php echo $PreguntaEncuesta[0]['IdPregunta']; ?>" id="Idpregunta">
                            <input type="hidden" value="<?php echo $cuentaCliente ?>" id="CuentaCliente">
                            <input type="hidden" value="<?php echo $zonaVentas ?>" id="ZonaVentas">
                        </td>
                    </tr>
                    <?php if ($PreguntaEncuesta[0]['IdTipoCampo'] == 1) { ?>
                        <?php foreach ($RespuestasPregunta as $itemRespuestas) { ?>
                            <tr>
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input id="idMultipleUnicaRespuesta" data-idrespuesta="<?php echo $itemRespuestas['Id']; ?>" data-idsiguinetepregunta="<?php echo $itemRespuestas['IdSiguientePregunta']; ?>" type="radio" name="radio" data-tipotexto="<?php echo $itemRespuestas['TipoTexto'] ?>"  value="<?php echo $itemRespuestas['Id']; ?>" class="item-respuestas idMultipleUnicaRespuesta">
                                    <?php echo $itemRespuestas['Descripcion']; ?>
                                    <br>
                                </td>
                                
                            </tr>
                        <?php } ?>
                        <tr>
                            <td class="text-center">
                                <label>Observación</label>  
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                <div id="TextoRespuesta"></div>  
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php if ($PreguntaEncuesta[0]['VisualizarFoto'] == 1) { ?>
                                    <div class="col-lg-offset-5">
                                        <div class="col-xs-6 col-sm-4 col-md-3 image">
                                             <?php if($FotosPregunta['Nombre'] != ""){ ?>
                                            <div class="thmb">
                                                <div class="thmb-prev">
                                                    <a href="imagenesEncuestasDescarga/<?php echo $FotosPregunta['Nombre']; ?>" data-rel="prettyPhoto">
                                                        <img src="imagenesEncuestasDescarga/<?php echo $FotosPregunta['Nombre']; ?>" class="img-responsive" alt="" />
                                                    </a>
                                                </div>
                                                <h5 class="fm-title"><a href="#"><?php echo $FotosPregunta['Nombre']; ?></a></h5>
                                                <small class="text-muted">Foto</small>
                                                <?php } ?>
                                            </div><!-- thmb -->
                                        </div><!-- col-xs-6 -->
                                    </div>   
                                <?php } ?> 
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php if ($PreguntaEncuesta[0]['RequiereFoto'] == 1 || $PreguntaEncuesta[0]['RequiereFoto'] == 2) { ?>
                                    <label class="col-lg-offset-5">Seleccione una foto</label> <input class="form-control col-lg-offset-4" type="file" style="width: 400px;" id="foto" name="foto"  onchange="control(this)">
                                    <input type="hidden" id="RequiereFoto" value="<?php  echo $PreguntaEncuesta[0]['RequiereFoto'] ?>">
                                <?php } ?>     
                            </td>  
                        </tr>
                    <?php } elseif ($PreguntaEncuesta[0]['IdTipoCampo'] == 2) { ?>
                        <?php foreach ($RespuestasPregunta as $itemRespuestas) { ?>
                        <tr>
                            <td>
                               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                               <input id="idMultipleRespuesta" data-idrespuesta="<?php echo $itemRespuestas['Id']; ?>" data-idsiguinetepregunta="<?php echo $itemRespuestas['IdSiguientePregunta']; ?>" type="checkbox" data-tipotexto="<?php echo $itemRespuestas['TipoTexto'] ?>"  value="<?php echo $itemRespuestas['Id']; ?>" class="idMultipleRespuesta chckRespuesta">
                                   <?php echo $itemRespuestas['Descripcion']; ?>
                                   <br> 
                                   <input type="hidden" id="RequiereFoto" value="<?php  echo $PreguntaEncuesta[0]['RequiereFoto'] ?>">
                            </td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td class="text-center">
                                <label>Observación</label>  
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                <div id="TextoRespuesta"></div>  
                            </td>
                        </tr>
                    <?php } elseif ($PreguntaEncuesta[0]['IdTipoCampo'] == 3) { ?>
                        <tr>
                            <td>
                                <?php if ($PreguntaEncuesta[0]['VisualizarFoto'] == 1) { ?>
                                    <div class="col-lg-offset-5">
                                        <div class="col-xs-6 col-sm-4 col-md-3 image">
                                             <?php if($FotosPregunta['Nombre'] != ""){ ?>
                                            <div class="thmb">
                                                <div class="thmb-prev">
                                                    <a href="imagenesEncuestasDescarga/<?php echo $FotosPregunta['Nombre']; ?>" data-rel="prettyPhoto">
                                                        <img src="imagenesEncuestasDescarga/<?php echo $FotosPregunta['Nombre']; ?>" class="img-responsive" alt="" />
                                                    </a>
                                                </div>
                                                <h5 class="fm-title"><a href="#"><?php echo $FotosPregunta['Nombre']; ?></a></h5>
                                                <small class="text-muted">Foto</small>
                                                <?php } ?>
                                            </div><!-- thmb -->
                                        </div><!-- col-xs-6 -->
                                    </div>   
                                <?php } ?> 
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" id="respuesta" data-idsiguinetepregunta="<?php echo $RespuestasPregunta[0]['IdSiguientePregunta']; ?>"  class="form-control IngresoRepuesta" placeholder="Respuesta">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php if ($PreguntaEncuesta[0]['RequiereFoto'] == 1 || $PreguntaEncuesta[0]['RequiereFoto'] == 2) { ?>
                                    <label class="col-lg-offset-5">Seleccione una foto</label> <input class="form-control col-lg-offset-4" type="file" style="width: 400px;" id="foto" name="foto"  onchange="control(this)">
                                    <input type="hidden" id="RequiereFoto" value="<?php  echo $PreguntaEncuesta[0]['RequiereFoto'] ?>">
                                <?php } ?>     
                            </td>  
                        </tr>

                    <?php } elseif ($PreguntaEncuesta[0]['IdTipoCampo'] == 4) { ?>
                        <tr>
                            <td>
                                <?php if ($PreguntaEncuesta[0]['VisualizarFoto'] == 1) { ?>
                                    <div class="col-lg-offset-5">
                                        <div class="col-xs-6 col-sm-4 col-md-3 image">
                                            <?php if($FotosPregunta['Nombre'] != ""){ ?>
                                            <div class="thmb">
                                                <div class="thmb-prev">
                                                    <a href="imagenesEncuestasDescarga/<?php echo $FotosPregunta['Nombre']; ?>" data-rel="prettyPhoto">
                                                        <img src="imagenesEncuestasDescarga/<?php echo $FotosPregunta['Nombre']; ?>" class="img-responsive" alt="" />
                                                    </a>
                                                </div>
                                                <h5 class="fm-title"><a href="#"><?php echo $FotosPregunta['Nombre']; ?></a></h5>
                                                <small class="text-muted">Foto</small>
                                                <?php } ?>
                                            </div><!-- thmb -->
                                        </div><!-- col-xs-6 -->
                                    </div>   
                                <?php } ?> 
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <input type="text" id="respuesta" data-idsiguinetepregunta="<?php echo $RespuestasPregunta[0]['IdSiguientePregunta']; ?>"  class="form-control IngresoRepuesta" onkeypress="return FilterInput(event)" placeholder="Respuesta">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php if ($PreguntaEncuesta[0]['RequiereFoto'] == 1 || $PreguntaEncuesta[0]['RequiereFoto'] == 2) { ?>
                                    <label class="col-lg-offset-5">Seleccione una foto</label> <input class="form-control col-lg-offset-4" type="file" style="width: 400px;" id="foto" name="foto"  onchange="control(this)">
                                    <input type="hidden" id="RequiereFoto" value="<?php  echo $PreguntaEncuesta[0]['RequiereFoto'] ?>">
                                <?php } ?>     
                            </td>  
                        </tr>

                    <?php } elseif ($PreguntaEncuesta[0]['IdTipoCampo'] == 5) { ?>
                        <tr>
                            <td>
                                <?php if ($PreguntaEncuesta[0]['VisualizarFoto'] == 1) { ?>
                                    <div class="col-lg-offset-5">
                                        <div class="col-xs-6 col-sm-4 col-md-3 image">
                                            <?php if($FotosPregunta['Nombre'] != ""){ ?>
                                            <div class="thmb">
                                                <div class="thmb-prev">
                                                    <a href="imagenesEncuestasDescarga/<?php echo $FotosPregunta['Nombre']; ?>" data-rel="prettyPhoto">
                                                        <img src="imagenesEncuestasDescarga/<?php echo $FotosPregunta['Nombre']; ?>" class="img-responsive" alt="" />
                                                    </a>
                                                </div>
                                                <h5 class="fm-title"><a href="#"><?php echo $FotosPregunta['Nombre']; ?></a></h5>
                                                <small class="text-muted">Foto</small>
                                                <?php } ?>
                                            </div><!-- thmb -->
                                        </div><!-- col-xs-6 -->
                                    </div>   
                                <?php } ?> 
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <input type="text" id="respuesta" data-idsiguinetepregunta="<?php echo $RespuestasPregunta[0]['IdSiguientePregunta']; ?>" class="form-control fechaEncuesta IngresoRepuestaBlur" placeholder="Respuesta">
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <?php if ($PreguntaEncuesta[0]['RequiereFoto'] == 1 || $PreguntaEncuesta[0]['RequiereFoto'] == 2) { ?>
                                    <label class="col-lg-offset-5">Seleccione una foto</label> <input class="form-control col-lg-offset-4" type="file" style="width: 400px;" id="foto" name="foto"  onchange="control(this)">
                                    <input type="hidden" id="RequiereFoto" value="<?php  echo $PreguntaEncuesta[0]['RequiereFoto'] ?>">
                                <?php } ?>     
                            </td>  
                        </tr>

                    <?php } elseif ($PreguntaEncuesta[0]['IdTipoCampo'] == 6) { ?>
                        <tr>
                            <td>
                                <?php if ($PreguntaEncuesta[0]['VisualizarFoto'] == 1) { ?>
                                    <div class="col-lg-offset-5">
                                        <div class="col-xs-6 col-sm-4 col-md-3 image">
                                            <div class="thmb">
                                                <?php if($FotosPregunta['Nombre'] != ""){ ?>
                                                <div class="thmb-prev">
                                                    <a href="imagenesEncuestasDescarga/<?php echo $FotosPregunta['Nombre']; ?>" data-rel="prettyPhoto">
                                                        <img src="imagenesEncuestasDescarga/<?php echo $FotosPregunta['Nombre']; ?>" class="img-responsive" alt="" />
                                                    </a>
                                                </div>
                                                <h5 class="fm-title"><a href="#"><?php echo $FotosPregunta['Nombre']; ?></a></h5>
                                                <small class="text-muted">Foto</small>
                                                <?php } ?>
                                            </div><!-- thmb -->
                                        </div><!-- col-xs-6 -->
                                    </div>   
                                <?php } ?> 
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="file" id="respuesta" data-idsiguinetepregunta="<?php echo $RespuestasPregunta[0]['IdSiguientePregunta']; ?>" class="form-control IngresoRepuestaBlur">
                                <input type="hidden" id="tipo" value="<?php echo $PreguntaEncuesta[0]['IdTipoCampo'] ?>">
                                <input type="hidden" id="RequiereFoto" value="<?php  echo $PreguntaEncuesta[0]['RequiereFoto'] ?>">
                            </td>
                        </tr>
                    
                    <?php } elseif ($PreguntaEncuesta[0]['IdTipoCampo'] == 7) { ?>
                        <tr>
                            <td>
                                <?php if ($PreguntaEncuesta[0]['VisualizarFoto'] == 1) { ?>
                                    <div class="col-lg-offset-5">
                                        <div class="col-xs-6 col-sm-4 col-md-3 image">
                                            <div class="thmb">
                                                <div class="thmb-prev">
                                                    <a href="imagenesEncuestasDescarga/<?php echo $FotosPregunta['Nombre']; ?>" data-rel="prettyPhoto">
                                                        <img src="imagenesEncuestasDescarga/<?php echo $FotosPregunta['Nombre']; ?>" class="img-responsive" alt="" />
                                                    </a>
                                                </div>
                                                <h5 class="fm-title"><a href="#"><?php echo $FotosPregunta['Nombre']; ?></a></h5>
                                                <small class="text-muted">Foto</small>
                                            </div><!-- thmb -->
                                        </div><!-- col-xs-6 -->
                                    </div>   
                                <?php } ?> 
                            </td>
                        </tr>
                         <tr>
                            <td>
                                <select id="respuesta" class="form-control idSeleccionable">
                                 <option>Seleccione una Respuesta</option>
                                <?php
                                foreach ($RespuestasPregunta as $itemRespuestas) {
                                    ?>
                                    <option data-idrespuesta="<?php echo $itemRespuestas['Id']; ?>" data-idsiguinetepregunta="<?php echo $itemRespuestas['IdSiguientePregunta']; ?>" data-tipotexto="<?php echo $itemRespuestas['TipoTexto'] ?>"><?php echo $itemRespuestas['Descripcion']; ?></option>
                            <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                <label>Observación</label>  
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                <div id="TextoRespuesta"></div>  
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php if ($PreguntaEncuesta[0]['RequiereFoto'] == 1 || $PreguntaEncuesta[0]['RequiereFoto'] == 2) { ?>
                                    <label class="col-lg-offset-5">Seleccione una foto</label> <input class="form-control col-lg-offset-4" type="file" style="width: 400px;" id="foto" name="foto"  onchange="control(this)">
                                    <input type="hidden" id="RequiereFoto" value="<?php  echo $PreguntaEncuesta[0]['RequiereFoto'] ?>">
                                <?php } ?>     
                            </td>  
                        </tr>

                    <?php } ?>    
                </table>
                <br>
                <table class="col-lg-offset-5">
                    <tr>
                        <td class="text-center"><div id="SiguinetePregunta"></div></td>
                    </tr>
                </table>
                <br>
            </div>
        </form>
    </div>
</div>
<?php $this->renderPartial('//mensajes/_alerta'); ?>
<?php $this->renderPartial('//mensajes/_alertSuccesEncuestas', array('cuentaCliente' => $cuentaCliente, 'zonaVentas' => $zonaVentas)); ?>


