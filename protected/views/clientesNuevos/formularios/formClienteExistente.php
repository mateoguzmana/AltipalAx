<div class="pageheader">
    <h2>
        <img src="images/home.png" alt="Ir al menu" class="cursorpointer" class="cursorpointer" id="retornarMenu"  style="width: 38px; margin-right: 15px; margin-left: 15px;"/>
        Clientes Nuevos <span></span></h2>
</div>
<?php
/* echo '<pre>';
  print_r($arrayclienteexistente);
  die(); */
if ($arrayclienteexistente[0]['CodigoTipoDocumento'] == '001') {


    $identificacion = $arrayclienteexistente[0]['Identificador'];
    $DiferentesDocumentos = Clientenuevo::model()->getClienteVerificadoVariasVeces($identificacion);
    if (count($DiferentesDocumentos > 1)) {
        ?>
        <!--FORMULARIO PARA CLIENTE NUEVO  EXISTENTE TIPO VARIOS UN NIT -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form class="form-horizontal" action="" id="frm-cliente-nuevo" method="post" name="frm-cliente-nuevo">
                        <?php if ($arrayclienteexistente[0]['Status'] == 'Todo' || $arrayclienteexistente[0]['Status'] == ''): ?>
                            <input type="hidden" value="1" id="status_cliente">
                        <?php else: ?>
                            <input type="hidden" value="0" id="status_cliente">
                        <?php endif ?>

                        <div class="panel panel-primary ">

                            <div class="panel-heading text-center">
                                <h4 class="panel-title">Crear Cliente</h4>
                                <?php //echo '<pre>';  print_r($arrayclienteexistente); ?>
                                <input type="hidden" id="ClienteNuevoCedula" value="2">
                            </div>

                            <div class="panel-body">

                                <div class="col-md-8 col-md-offset-2">

                                    <div class="tab-content">
                                        <div class="widget-bloglist tab-pane active" id="frm-registrar">

                                            <h4 class="text-center">Paso 1 - 3 Datos personales</h4>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Tipo de Documento</label>
                                                <div class="col-sm-6">
                                                    <?php
                                                    $CodTipDoc = $arrayclienteexistente[0]['CodigoTipoDocumento'];
                                                    $tipoDocumento = Clientenuevo::model()->getTipoDocumento($CodTipDoc);
                                                    ?>
                                                    <input class="form-control"  type="text" value="<?php echo $tipoDocumento[0]['Nombre']; ?>"  readonly="true">
                                                    <input type="hidden" value="<?php echo $tipoDocumento[0]['Codigo']; ?>" id="tipoIdentificacionCliExistenteNit" name="clienteNuevo[tipoIdentificacion]">
                                                    <label for="name" class="error" style="display: none" id="errorTipoIdentificacion"></label>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Nit</label>
                                                <div class="col-sm-6">
                                                    <select class="form-control selectIdCliente" required="required">
                                                        <?php foreach ($DiferentesDocumentos as $itemDoc): ?>
                                                            <option data-identificacion="<?php echo $itemDoc['Identificador'] ?>" data-cuentacliente="<?php echo $itemDoc['CuentaCliente'] ?>"><?php echo $itemDoc['Establecimiento'] ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <input type="hidden" id="nit"  name="clienteNuevo[nitCedula]">
                                                <input type="hidden" id="CuentaCliente"  name="clienteNuevo[cuentacliente]">
                                                <input type="hidden" id="Identificacion">
                                            </div>


                                            <div class="form-group" id="groupNombreRazonSocial">
                                                <label class="col-sm-4 control-label">Razón Social</label>
                                                <div class="col-sm-6">
                                                    <input type="text" required="" placeholder="" class="form-control" name="clienteNuevo[nombreRazonSocial]" id="nombreRazonSocialCliExitenteNit"  readonly="true">
                                                    <label for="name" class="error" style="display: none" id="errorNombreRazonSocial"></label>
                                                </div>
                                            </div>



                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Código CIIU</label>
                                                <div class="col-sm-6">
                                                    <label  class="label-control" name="clienteNuevo[codigoCiuu]" id="codigoCiiuLabel"></label>
                                                    <input type="hidden" name="clienteNuevo[codigoCiuu]" id="CodigoCiuu">
                                                    <label  class="label-control" id="nombreCiuu"></label>
                                                </div>
                                            </div>

                                            <div class="form-group" id="groupEstablecimiento">
                                                <label class="col-sm-4 control-label">Establecimiento</label>
                                                <div class="col-sm-6">
                                                    <input type="text" required="" placeholder="" class="form-control" name="clienteNuevo[establecimiento]" id="EestablecimientoCliExitenteNit"  readonly="true">
                                                    <label for="name" class="error" style="display: none" id="errorNombreEstablecimiento"></label>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Ciudad</label>
                                                <div class="col-sm-6">
                                                    <label class="label-control" id="CodCiudadLabel"></label>
                                                    <label class="label-control" id="NombreCiudadLabel"></label>
                                                    <label for="name" class="error" style="display: none" id="errorCiudades"></label>
                                                </div>
                                                <div class="col-sm-1" id="img-cargar-ciudades">

                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Departamento</label>
                                                <div class="col-sm-6">
                                                    <label class="label-control" id="CodDapartamentoLabel"></label>
                                                    <label class="label-control" id="NombreDepartamentoLabel"></label>
                                                    <label for="name" class="error" style="display: none" id="errorDepartamentos"></label>
                                                </div>
                                                <div class="col-sm-1" id="img-cargar-departamento">

                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Barrio</label>
                                                <div class="col-sm-6">
                                                    <label class="label-control" name="clienteNuevo[barrios]" id="CodBarrioLabel"></label>
                                                    <input type="hidden" name="clienteNuevo[barrios]" id="CodBarrio">
                                                    <label class="label-control" id="NombreBarrioLabel"></label>
                                                    <label for="name" class="error"style="display: none" id="errorBarrios"></label>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Dirección</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" name="clienteNuevo[direccion]" id="direccion1"  readonly="true">
                                                    <label for="name" class="error" style="display: none" id="errorDireccion"></label>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Teléfono</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" name="clienteNuevo[telefono]" id="telefono1"  readonly="true">
                                                    <label for="name" class="error" style="display: none" id="errorTelefono"></label>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Teléfono Móvil</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" name="clienteNuevo[telefonoMovil]" id="telefonoMovil1"  readonly="true">
                                                    <label for="name" class="error" style="display: none" id="errorTelefonoMovil"></label>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Correo Electrónico</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" name="clienteNuevo[correo]" id="email1"  readonly="true">
                                                    <label for="name" class="error" style="display: none" id="errorCorreo"></label>
                                                </div>
                                                <div id="ErrorEmail" class="col-sm-5"></div>
                                            </div>

                                            <div class="col-sm-offset-6" id="img">

                                            </div>
                                            <div class="panel-footer">
                                                <div class="row">
                                                    <div class="col-sm-6 col-sm-offset-4 text-center">
                                                        <!-- evento funciones.js -->
                                                        <input type="button" id="zonasventasvariosnit" class="btn btn-primary" value="Zonas Atiende" />
                                                        <?php if ($arrayclienteexistente[0]['GrupoVentasIguales'] == 1) { ?>
                                                            <input type="button" id="msgvalidarclienterutanit" class="btn btn-primary" value="Enrutar Cliente" />
                                                            <br><br>
                                                            <input type="button" id="crearclientenit" class="btn btn-primary" value="Crear Cliente" />
                                                        <?php } else { ?>
                                                            <input type="button" id="cargar-formulario-segmentos" class="btn btn-primary" value="Enrutar Cliente"/>
                                                            <br><br>
                                                            <input type="button" id="crearclientenit" class="btn btn-primary" value="Crear Cliente" />
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- tab-pane -->

                                        <div class="widget-bloglist tab-pane" id="frm-segmentos">



                                            <h4 class="text-center">Paso 2 - 3 Segmentos</h4>
                                            <br>
                                            <div class="form-group">

                                                <div class="cols-sm-12">
                                                    <?php $pregunta = Consultas::model()->getPreguntasEncuestaId('1'); ?>
                                                    <div id="contenido-pregunta">
                                                        <center><h5 id="pregunta-titulo" data-pregunta="<?php echo $pregunta[0]['IdPregunta']; ?>"><?php echo $pregunta[0]['pregunta'] ?></h5></center>
                                                        <br>
                                                        <table class="table table-striped" id="pregunta-respuesta">
                                                            <?php foreach ($pregunta as $itemPreguntas) { ?>
                                                                <tr>
                                                                    <td>
                                                                        <span class="glyphicon glyphicon-question-sign"></span>
                                                                        <?php echo $itemPreguntas['respuesta']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php if ($itemPreguntas['IdCampo'] == 1) { ?>
                                                                            <input data-respuesta="<?php echo $itemPreguntas['IdRespuesta']; ?>" data-siguiente-pregunta="<?php echo $itemPreguntas['IdSiguientePregunta']; ?>" type="radio" name="clienteNuevo[respuesta]" value="<?php echo $itemPreguntas['IdRespuesta']; ?>" class="item-respuestas" /><br>
                                                                        <?php } ?>
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
                                                        <option value="k">Seleccione</option>
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
                                                            <td class="text-center rs-numero-visita" id=""></td>
                                                            <td class="rs-r1"></td>
                                                            <td class="rs-r2"></td>
                                                            <td class="rs-r3"></td>
                                                            <td class="rs-r4"></td>

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
                                                        <?php if ($arrayclienteexistente[0]['Status'] == 'Todo' || $arrayclienteexistente[0]['Status'] == ''): ?>
                                                            <input type="button" id="cargar-formulario-segmentos-back" class="btn btn-primary" value="Encuesta de Segmentación" />
                                                        <?php endif ?>
                                                        <input type="button" name="crearClienteNuevo" id="crearClienteNuevo" class="btn btn-primary" value="Crear cliente" />
                                                        <input type="hidden" name="IddentificadorForm" id="IddentificadorForm" value="1"/>

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
        </div>


    <?php } else { ?>
        <!--FORMULARIO PARA CLIENTE NUEVO  EXISTENTE TIPO SOLO UN NIT -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form class="form-horizontal" action="" id="frm-cliente-nuevo" method="post" name="frm-cliente-nuevo">
                        <?php if ($arrayclienteexistente[0]['Status'] == 'Todo' || $arrayclienteexistente[0]['Status'] == ''): ?>
                            <input type="hidden" value="1" id="status_cliente">
                        <?php else: ?>
                            <input type="hidden" value="0" id="status_cliente">
                        <?php endif ?>
                        <div class="panel panel-primary ">

                            <div class="panel-heading text-center">
                                <h4 class="panel-title">Crear Cliente</h4>
                                <?php //echo '<pre>';  print_r($arrayclienteexistente); ?>
                            </div>

                            <div class="panel-body">

                                <div class="col-md-8 col-md-offset-2">

                                    <div class="tab-content">
                                        <div class="widget-bloglist tab-pane active" id="frm-registrar">

                                            <h4 class="text-center">Paso 1 - 3 Datos personales</h4>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Tipo de Documento</label>
                                                <div class="col-sm-6">
                                                    <?php
                                                    $CodTipDoc = $arrayclienteexistente[0]['CodigoTipoDocumento'];
                                                    $tipoDocumento = Clientenuevo::model()->getTipoDocumento($CodTipDoc);
                                                    ?>
                                                    <input class="form-control"  type="text" value="<?php echo $tipoDocumento[0]['Nombre']; ?>"  readonly="true">
                                                    <input type="hidden" value="<?php echo $tipoDocumento[0]['Codigo']; ?>" id="tipoIdentificacionCliExistenteNit" name="clienteNuevo[tipoIdentificacion]">
                                                    <label for="name" class="error" style="display: none" id="errorTipoIdentificacion"></label>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Nit</label>
                                                <div class="col-sm-6">
                                                    <select class="form-control selectIdCliente" required="required">
                                                        <option data-identificacion="<?php echo $DiferentesDocumentos[0]['Identificador'] ?>" data-cuentacliente="<?php echo $DiferentesDocumentos[0]['CuentaCliente'] ?>"><?php echo $DiferentesDocumentos[0]['Establecimiento'] ?></option>
                                                    </select>
                                                </div>
                                                <input type="hidden" id="nit"  name="clienteNuevo[nitCedula]">
                                                <input type="hidden" id="CuentaCliente">
                                                <input type="hidden" id="Identificacion">
                                            </div>


                                            <div class="form-group" id="groupNombreRazonSocial">
                                                <label class="col-sm-4 control-label">Razón Social</label>
                                                <div class="col-sm-6">
                                                    <input type="text" required="" placeholder="" class="form-control" name="clienteNuevo[nombreRazonSocial]" id="nombreRazonSocialCliExitenteNit" value="<?php echo $arrayclienteexistente[0]['RazonSocial'] ?>" readonly="true">
                                                    <label for="name" class="error" style="display: none" id="errorNombreRazonSocial"></label>
                                                </div>
                                            </div>



                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Código CIIU</label>
                                                <div class="col-sm-6">
                                                    <?php
                                                    $codciu = $arrayclienteexistente[0]['CodigoCIIU'];
                                                    $ciiu = Clientenuevo::model()->getCodCiiu($codciu);
                                                    ?>
                                                    <label  class="label-control" name="clienteNuevo[codigoCiuu]" id="codigoCiiu1"><?php echo $ciiu[0]['CodigoCIIU']; ?></label>
                                                    <input type="hidden" name="clienteNuevo[codigoCiuu]" value="<?php echo $ciiu[0]['CodigoCIIU']; ?>">
                                                    <label  class="label-control"><?php echo $ciiu[0]['NombreCIIU']; ?></label>
                                                </div>
                                            </div>

                                            <div class="form-group" id="groupEstablecimiento">
                                                <label class="col-sm-4 control-label">Establecimiento</label>
                                                <div class="col-sm-6">
                                                    <input type="text" required="" placeholder="" class="form-control" name="clienteNuevo[establecimiento]" id="EestablecimientoCliExitenteNit" value="<?php echo $arrayclienteexistente[0]['Establecimiento'] ?>" readonly="true">
                                                    <label for="name" class="error" style="display: none" id="errorNombreEstablecimiento"></label>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Ciudad</label>
                                                <div class="col-sm-6">
                                                    <?php
                                                    $barrio = $arrayclienteexistente[0]['Barrio'];
                                                    $localizacion = Clientenuevo::model()->getLocalizacion($barrio);
                                                    ?>
                                                    <label class="label-control"><?php echo $localizacion[0]['CodigoCiudad']; ?></label>
                                                    <label class="label-control" ><?php echo $localizacion[0]['NombreCiudad']; ?></label>
                                                    <label for="name" class="error" style="display: none" id="errorCiudades"></label>
                                                </div>
                                                <div class="col-sm-1" id="img-cargar-ciudades">

                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Departamento</label>
                                                <div class="col-sm-6">
                                                    <label class="label-control" ><?php echo $localizacion[0]['CodigoDepartamento']; ?></label>
                                                    <label class="label-control" ><?php echo $localizacion[0]['NombreDepartamento']; ?></label>
                                                    <label for="name" class="error" style="display: none" id="errorDepartamentos"></label>
                                                </div>
                                                <div class="col-sm-1" id="img-cargar-departamento">

                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Barrio</label>
                                                <div class="col-sm-6">
                                                    <label class="label-control" name="clienteNuevo[barrios]"><?php echo $arrayclienteexistente[0]['Barrio']; ?></label>
                                                    <input type="hidden" name="clienteNuevo[barrios]" value="<?php echo $arrayclienteexistente[0]['Barrio']; ?>">
                                                    <label class="label-control"><?php echo $localizacion[0]['NombreBarrio']; ?></label>
                                                    <label for="name" class="error"style="display: none" id="errorBarrios"></label>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Dirección</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" name="clienteNuevo[direccion]" id="direccion1" value="<?php echo $arrayclienteexistente[0]['Calle']; ?>" readonly="true">
                                                    <label for="name" class="error" style="display: none" id="errorDireccion"></label>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Teléfono</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" name="clienteNuevo[telefono]" id="telefono1" value="<?php echo $arrayclienteexistente[0]['Telefono']; ?>" readonly="true">
                                                    <label for="name" class="error" style="display: none" id="errorTelefono"></label>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Teléfono Móvil</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" name="clienteNuevo[telefonoMovil]" id="telefonoMovil1" value="<?php echo $arrayclienteexistente[0]['TelefonoMovil']; ?>" readonly="true">
                                                    <label for="name" class="error" style="display: none" id="errorTelefonoMovil"></label>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Correo Electrónico</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" name="clienteNuevo[correo]" id="email1" value="<?php echo $arrayclienteexistente[0]['CorreoElectronico']; ?>" readonly="true">
                                                    <label for="name" class="error" style="display: none" id="errorCorreo"></label>
                                                </div>
                                                <div id="ErrorEmail" class="col-sm-5"></div>
                                            </div>

                                            <div class="panel-footer">
                                                <div class="row">
                                                    <div class="col-sm-6 col-sm-offset-4 text-center">
                                                        <!-- evento funciones.js -->
                                                        <input type="button" id="zonasventas" class="btn btn-primary" value="Zonas Atiende" />
                                                        <?php if ($arrayclienteexistente[0]['GrupoVentasIguales'] == 1) { ?>
                                                            <input type="button" id="msgvalidarclienterutanit" class="btn btn-primary" value="Enrutar Cliente" />
                                                            <br><br>
                                                            <input type="button" id="crearclientenit" class="btn btn-primary" value="Crear Cliente" />

                                                        <?php } else { ?>
                                                            <input type="button" id="cargar-formulario-segmentos" class="btn btn-primary" value="Enrutar Cliente" />
                                                            <br><br>
                                                            <input type="button" id="crearclientenit" class="btn btn-primary" value="Crear Cliente" />
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>



                                        </div><!-- tab-pane -->

                                        <div class="widget-bloglist tab-pane" id="frm-segmentos">



                                            <h4 class="text-center">Paso 2 - 3 Segmentos</h4>
                                            <br>
                                            <div class="form-group">

                                                <div class="cols-sm-12">
                                                    <?php
                                                    $pregunta = Consultas::model()->getPreguntasEncuestaId('1');
                                                    ?>
                                                    <div id="contenido-pregunta">
                                                        <center><h5 id="pregunta-titulo" data-pregunta="<?php echo $pregunta[0]['IdPregunta']; ?>"><?php echo $pregunta[0]['pregunta'] ?></h5></center>
                                                        <br>
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
                                                        <option value="k">Seleccione</option>
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
                                                            <td class="text-center rs-numero-visita" id=""></td>
                                                            <td class="rs-r1"></td>
                                                            <td class="rs-r2"></td>
                                                            <td class="rs-r3"></td>
                                                            <td class="rs-r4"></td>

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
                                                        <?php if ($arrayclienteexistente[0]['Status'] == 'Todo' || $arrayclienteexistente[0]['Status'] == ''): ?>
                                                            <input type="button" id="cargar-formulario-segmentos-back" class="btn btn-primary" value="Encuesta de Segmentación" />
                                                        <?php endif ?>
                                                        <input type="button" name="crearClienteNuevo" id="crearClienteNuevo" class="btn btn-primary" value="Crear cliente" />
                                                        <input type="hidden" name="IddentificadorForm" id="IddentificadorForm" value="1"/>

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
        </div>
    <?php } ?>




    <?php
} else {

    $identificacion = $arrayclienteexistente[0]['Identificador'];
    $DiferentesDocumentos = Clientenuevo::model()->getClienteVerificadoVariasVeces($identificacion);
    if (count($DiferentesDocumentos) > 1) {
        ?>

        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal" action="" id="frm-cliente-nuevo" method="post" name="frm-cliente-nuevo">
                    <?php if ($arrayclienteexistente[0]['Status'] == 'Todo' || $arrayclienteexistente[0]['Status'] == ''): ?>
                        <input type="hidden" value="1" id="status_cliente">
                    <?php else: ?>
                        <input type="hidden" value="0" id="status_cliente">
                    <?php endif ?>

                    <div class="panel panel-primary ">


                        <div class="panel-heading text-center">
                            <h4 class="panel-title">Crear Cliente</h4>
                            <input type="hidden" id="ClienteNuevoCedula" value="1">
                        </div>
                        <div class="panel-body">

                            <div class="col-md-8 col-md-offset-2">

                                <div class="tab-content">
                                    <div class="widget-bloglist tab-pane active" id="frm-registrar">

                                        <h4 class="text-center">Paso 1 - 3 Datos personales</h4>

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Tipo de Documento</label>
                                            <div class="col-sm-6">
                                                <?php
                                                $CodTipDoc = $arrayclienteexistente[0]['CodigoTipoDocumento'];
                                                $tipoDocumento = Clientenuevo::model()->getTipoDocumento($CodTipDoc);
                                                ?>
                                                <input class="form-control"  type="text" value="<?php echo $tipoDocumento[0]['Nombre']; ?>"  readonly="true">
                                                <input type="hidden" value="<?php echo $tipoDocumento[0]['Codigo']; ?>" id="tipoIdentificacionCliExistente" name="clienteNuevo[tipoIdentificacion]">
                                                <label for="name" class="error" style="display: none" id="errorTipoIdentificacion"></label>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Establecimiento</label>
                                            <div class="col-sm-6">
                                                <select class="form-control selectIdClienteCedula" required="required">
                                                    <?php foreach ($DiferentesDocumentos as $itemDoc): ?>
                                                        <option data-identificacion="<?php echo $itemDoc['Identificador'] ?>" data-cuentacliente="<?php echo $itemDoc['CuentaCliente'] ?>"><?php echo $itemDoc['Establecimiento'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <input type="hidden" id="CuentaCliente" name="clienteNuevo[cuentacliente]">
                                            <input type="hidden" id="Identificacion">
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Cedula</label>
                                            <div class="col-sm-6">
                                                <input type="text"  class="form-control" name="clienteNuevo[nitCedula]" id="Cedula" readonly="true">
                                                <label for="name" class="error" style="display: none" id="errorNitCedula"></label>
                                            </div>
                                        </div>


                                        <div class="form-group" id="groupPrimerNombre">
                                            <label class="col-sm-4 control-label">Primer Nombre</label>
                                            <div class="col-sm-6">
                                                <input type="text" required="" placeholder="" class="form-control" name="clienteNuevo[primerNombre]" id="primerNombre" readonly="true">
                                                <label for="name" class="error" style="display: none" id="errorPrimerNombre"></label>
                                            </div>
                                        </div>

                                        <div class="form-group" id="groupSegundoNombre">
                                            <label class="col-sm-4 control-label">Segundo Nombre</label>
                                            <div class="col-sm-6">
                                                <input type="text" required="" placeholder="" class="form-control" name="clienteNuevo[segundoNombre]" id="segundoNombre" readonly="true">
                                                <label for="name" class="error" style="display: none" id="errorSegundoNombre"></label>
                                            </div>
                                        </div>

                                        <div class="form-group" id="groupPrimerApellido">
                                            <label class="col-sm-4 control-label">Primer Apellido</label>
                                            <div class="col-sm-6">
                                                <input type="text" required="" placeholder="" class="form-control" name="clienteNuevo[primerApellido]" id="primerApellido" readonly="true">
                                                <label for="name" class="error" style="display: none" id="errorPrimerApellido"></label>
                                            </div>
                                        </div>

                                        <div class="form-group" id="groupSegundoApellido">
                                            <label class="col-sm-4 control-label">Segundo Apellido</label>
                                            <div class="col-sm-6">
                                                <input type="text" required="" placeholder="" class="form-control" name="clienteNuevo[segundoApellido]" id="segundoApellido" readonly="true">
                                                <label for="name" class="error" style="display: none" id="errorSegundoApellido"></label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Código CIIU</label>
                                            <div class="col-sm-6">
                                                <label  class="label-control" name="clienteNuevo[codigoCiuu]" id="codigoCiiuLabel"></label>
                                                <input type="hidden" name="clienteNuevo[codigoCiuu]" id="CodigoCiuu">
                                                <label  class="label-control" id="nombreCiuu"></label>
                                            </div>
                                        </div>

                                        <div class="form-group" id="groupEstablecimiento">
                                            <label class="col-sm-4 control-label">Establecimiento</label>
                                            <div class="col-sm-6">
                                                <input type="text" required="" placeholder="" class="form-control" name="clienteNuevo[establecimiento]" id="EestablecimientoCliExitenteNit"  readonly="true">
                                                <label for="name" class="error" style="display: none" id="errorNombreEstablecimiento"></label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Ciudad</label>
                                            <div class="col-sm-6">
                                                <label class="label-control" id="CodCiudadLabel"></label>
                                                <label class="label-control" id="NombreCiudadLabel"></label>
                                                <label for="name" class="error" style="display: none" id="errorCiudades"></label>
                                            </div>
                                            <div class="col-sm-1" id="img-cargar-ciudades">

                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Departamento</label>
                                            <div class="col-sm-6">
                                                <label class="label-control" id="CodDapartamentoLabel"></label>
                                                <label class="label-control" id="NombreDepartamentoLabel"></label>
                                                <label for="name" class="error" style="display: none" id="errorDepartamentos"></label>
                                            </div>
                                            <div class="col-sm-1" id="img-cargar-departamento">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Barrio</label>
                                            <div class="col-sm-6">
                                                <label class="label-control" name="clienteNuevo[barrios]" id="CodBarrioLabel"></label>
                                                <input type="hidden" name="clienteNuevo[barrios]" id="CodBarrio">
                                                <label class="label-control" id="NombreBarrioLabel"></label>
                                                <label for="name" class="error"style="display: none" id="errorBarrios"></label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Dirección</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="clienteNuevo[direccion]" id="direc" readonly="true">
                                                <label for="name" class="error" style="display: none" id="errorDireccion"></label>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Teléfono</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="clienteNuevo[telefono]" id="tel" readonly="true">
                                                <label for="name" class="error" style="display: none" id="errorTelefono"></label>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Teléfono Móvil</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="clienteNuevo[telefonoMovil]" id="telMovil" readonly="true">
                                                <label for="name" class="error" style="display: none" id="errorTelefonoMovil"></label>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Correo Electrónico</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="clienteNuevo[correo]" id="email" readonly="true">
                                                <label for="name" class="error" style="display: none" id="errorCorreo"></label>
                                            </div>
                                            <div id="ErrorEmail" class="col-sm-5"></div>
                                        </div>

                                        <div class="panel-footer">
                                            <div class="row">
                                                <div class="col-sm-6 col-sm-offset-4 text-center">
                                                    <!-- evento funciones.js -->
                                                    <!--<input type="button" id="zonasventas" class="btn btn-primary" value="Zonas Atiende" />-->
                                                    <input type="button" id="zonasventasvarioCedula" class="btn btn-primary" value="Zonas Atiende" />
                                                    <?php if ($arrayclienteexistente[0]['GrupoVentasIguales'] == 1) { ?>
                                                        <input type="button" id="msgvalidarclienterutacedula" class="btn btn-primary" value="Enrutar Cliente" />
                                                        <br><br>
                                                        <input type="button" id="crearclientecedula" class="btn btn-primary" value="Crear Cliente" />
                                                    <?php } else { ?>
                                                        <input type="button" id="cargar-formulario-segmentos" class="btn btn-primary" value="Enrutar Cliente" />
                                                        <br><br>
                                                        <input type="button" id="crearclientenit" class="btn btn-primary" value="Crear Cliente" />
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>



                                    </div><!-- tab-pane -->

                                    <div class="widget-bloglist tab-pane" id="frm-segmentos">



                                        <h4 class="text-center">Paso 2 - 3 Segmentos</h4>
                                        <br>
                                        <div class="form-group">

                                            <div class="cols-sm-12">
                                                <?php
                                                $pregunta = Consultas::model()->getPreguntasEncuestaId('1');
                                                ?>
                                                <div id="contenido-pregunta">
                                                    <center><h5 id="pregunta-titulo" data-pregunta="<?php echo $pregunta[0]['IdPregunta']; ?>"><?php echo $pregunta[0]['pregunta'] ?></h5></center>
                                                    <br>
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
                                                    <option value="k">Seleccione</option>
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
                                                        <td class="text-center rs-numero-visita" id=""></td>
                                                        <td class="rs-r1"></td>
                                                        <td class="rs-r2"></td>
                                                        <td class="rs-r3"></td>
                                                        <td class="rs-r4"></td>

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

                                                    <?php if ($arrayclienteexistente[0]['Status'] == 'Todo' || $arrayclienteexistente[0]['Status'] == ''): ?>
                                                        <input type="button" id="cargar-formulario-segmentos-back" class="btn btn-primary" value="Encuesta de Segmentación" />
                                                    <?php endif ?>
                                                    <input type="button" name="crearClienteNuevo" id="crearClienteNuevo" class="btn btn-primary" value="Crear cliente" />
                                                    <input type="hidden" name="IddentificadorForm" id="IddentificadorForm" value="1"/>

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


    <?php } else { ?>
        <!--FORMULARIO PARA CLIENTE NO EXISTENTE OTRO TIPO DE DOCUMENTO-->

        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal" action="" id="frm-cliente-nuevo" method="post" name="frm-cliente-nuevo">
                    <?php if ($arrayclienteexistente[0]['Status'] == 'Todo' || $arrayclienteexistente[0]['Status'] == ''): ?>
                        <input type="hidden" value="1" id="status_cliente">
                    <?php else: ?>
                        <input type="hidden" value="0" id="status_cliente">
                    <?php endif ?>

                    <div class="panel panel-primary ">



                        <div class="panel-heading text-center">
                            <h4 class="panel-title">Crear Cliente</h4>

                        </div>
                        <div class="panel-body">

                            <div class="col-md-8 col-md-offset-2">

                                <div class="tab-content">
                                    <div class="widget-bloglist tab-pane active" id="frm-registrar">

                                        <h4 class="text-center">Paso 1 - 3 Datos personales</h4>

                                        <input type="hidden" id="cuentacliente" name="clienteNuevo[cuentacliente]" value="<?php echo $arrayclienteexistente[0]['CuentaCliente'] ?>">

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Tipo de Documento</label>
                                            <div class="col-sm-6">
                                                <?php
                                                $CodTipDoc = $arrayclienteexistente[0]['CodigoTipoDocumento'];
                                                $tipoDocumento = Clientenuevo::model()->getTipoDocumento($CodTipDoc);
                                                ?>
                                                <input class="form-control"  type="text" value="<?php echo $tipoDocumento[0]['Nombre']; ?>"  readonly="true">
                                                <input type="hidden" value="<?php echo $tipoDocumento[0]['Codigo']; ?>" id="tipoIdentificacionCliExistente" name="clienteNuevo[tipoIdentificacion]">
                                                <label for="name" class="error" style="display: none" id="errorTipoIdentificacion"></label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Cedula</label>
                                            <div class="col-sm-6">
                                                <input type="text"  class="form-control" name="clienteNuevo[nitCedula]" id="Cedula" readonly="true"  value="<?php echo $arrayclienteexistente[0]['Identificador']; ?>">
                                                <label for="name" class="error" style="display: none" id="errorNitCedula"></label>
                                            </div>
                                        </div>

                                        <div class="form-group" id="groupPrimerNombre">
                                            <label class="col-sm-4 control-label">Primer Nombre</label>
                                            <div class="col-sm-6">
                                                <input type="text" required="" placeholder="" class="form-control" name="clienteNuevo[primerNombre]" id="primerNombre" readonly="true" value="<?php echo $arrayclienteexistente[0]['PrimerNombre']; ?>">
                                                <label for="name" class="error" style="display: none" id="errorPrimerNombre"></label>
                                            </div>
                                        </div>

                                        <div class="form-group" id="groupSegundoNombre">
                                            <label class="col-sm-4 control-label">Segundo Nombre</label>
                                            <div class="col-sm-6">
                                                <input type="text" required="" placeholder="" class="form-control" name="clienteNuevo[segundoNombre]" id="segundoNombre" readonly="true" value="<?php echo $arrayclienteexistente[0]['SegundoNombre']; ?>">
                                                <label for="name" class="error" style="display: none" id="errorSegundoNombre"></label>
                                            </div>
                                        </div>

                                        <div class="form-group" id="groupPrimerApellido">
                                            <label class="col-sm-4 control-label">Primer Apellido</label>
                                            <div class="col-sm-6">
                                                <input type="text" required="" placeholder="" class="form-control" name="clienteNuevo[primerApellido]" id="primerApellido" readonly="true" value="<?php echo $arrayclienteexistente[0]['PrimerApellido']; ?>">
                                                <label for="name" class="error" style="display: none" id="errorPrimerApellido"></label>
                                            </div>
                                        </div>

                                        <div class="form-group" id="groupSegundoApellido">
                                            <label class="col-sm-4 control-label">Segundo Apellido</label>
                                            <div class="col-sm-6">
                                                <input type="text" required="" placeholder="" class="form-control" name="clienteNuevo[segundoApellido]" id="segundoApellido" readonly="true" value="<?php echo $arrayclienteexistente[0]['SegundoApellido']; ?>">
                                                <label for="name" class="error" style="display: none" id="errorSegundoApellido"></label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Código CIIU</label>
                                            <div class="col-sm-6">
                                                <?php
                                                $codciu = $arrayclienteexistente[0]['CodigoCIIU'];
                                                $ciiu = Clientenuevo::model()->getCodCiiu($codciu);
                                                ?>
                                                <label  class="label-control" name="clienteNuevo[codigoCiuu]" id="codigoCiiu" value="<?php echo $ciiu[0]['CodigoCIIU']; ?>"><?php echo $ciiu[0]['CodigoCIIU']; ?></label>
                                                <input type="hidden" name="clienteNuevo[codigoCiuu]" value="<?php echo $ciiu[0]['CodigoCIIU']; ?>">
                                                <label  class="label-control"><?php echo $ciiu[0]['NombreCIIU']; ?></label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Establecimiento</label>
                                            <div class="col-sm-6">
                                                <input type="text" required="" placeholder="Establecimiento" class="form-control" name="clienteNuevo[establecimiento]" id="establecimientoPersona" value="<?php echo $arrayclienteexistente[0]['Establecimiento'] ?>" readonly="true">
                                                <label for="name" class="error" style="display: none" id="errorEstablecimientoPersona"></label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Ciudad</label>
                                            <div class="col-sm-6">
                                                <?php
                                                $barrio = $arrayclienteexistente[0]['Barrio'];
                                                $localizacion = Clientenuevo::model()->getLocalizacion($barrio);
                                                ?>
                                                <label class="label-control"><?php echo $localizacion[0]['CodigoCiudad']; ?></label>
                                                <label class="label-control" ><?php echo $localizacion[0]['NombreCiudad']; ?></label>
                                                <label for="name" class="error" style="display: none" id="errorCiudades"></label>
                                            </div>
                                            <div class="col-sm-1" id="img-cargar-ciudades">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Departamento</label>
                                            <div class="col-sm-6">
                                                <label class="label-control" ><?php echo $localizacion[0]['CodigoDepartamento']; ?></label>
                                                <label class="label-control" ><?php echo $localizacion[0]['NombreDepartamento']; ?></label>
                                                <label for="name" class="error" style="display: none" id="errorDepartamentos"></label>
                                            </div>
                                            <div class="col-sm-1" id="img-cargar-departamento">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Barrio</label>
                                            <div class="col-sm-6">
                                                <label class="label-control" id="Barrios"><?php echo $arrayclienteexistente[0]['Barrio']; ?></label>
                                                <input type="hidden" name="clienteNuevo[barrios]" value="<?php echo $arrayclienteexistente[0]['Barrio']; ?>">
                                                <label class="label-control"><?php echo $localizacion[0]['NombreBarrio']; ?></label>
                                                <label for="name" class="error"style="display: none" id="errorBarrios"></label>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Dirección</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="clienteNuevo[direccion]" id="direc" readonly="true" value="<?php echo $arrayclienteexistente[0]['Calle']; ?>">
                                                <label for="name" class="error" style="display: none" id="errorDireccion"></label>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Teléfono</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="clienteNuevo[telefono]" id="tel" readonly="true" value="<?php echo $arrayclienteexistente[0]['Telefono']; ?>">
                                                <label for="name" class="error" style="display: none" id="errorTelefono"></label>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Teléfono Móvil</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="clienteNuevo[telefonoMovil]" id="telMovil" readonly="true" value="<?php echo $arrayclienteexistente[0]['TelefonoMovil']; ?>">
                                                <label for="name" class="error" style="display: none" id="errorTelefonoMovil"></label>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Correo Electrónico</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="clienteNuevo[correo]" id="email" readonly="true" value="<?php echo $arrayclienteexistente[0]['CorreoElectronico']; ?>">
                                                <label for="name" class="error" style="display: none" id="errorCorreo"></label>
                                            </div>
                                            <div id="ErrorEmail" class="col-sm-5"></div>
                                        </div>

                                        <div class="panel-footer">
                                            <div class="row">
                                                <div class="col-sm-6 col-sm-offset-4 text-center">
                                                    <!-- evento funciones.js -->
                                                    <input type="button" id="zonasventas" class="btn btn-primary" value="Zonas Atiende" />
                                                    <?php if ($arrayclienteexistente[0]['GrupoVentasIguales'] == 1) { ?>
                                                        <input type="button" id="msgvalidarclienterutacedula" class="btn btn-primary" value="Enrutar Cliente" />
                                                        <br><br>
                                                        <input type="button" id="crearclientecedula" class="btn btn-primary" value="Crear Cliente" />
                                                    <?php } else { ?>
                                                        <input type="button" id="cargar-formulario-segmentos" class="btn btn-primary" value="Enrutar Cliente" />
                                                        <br><br>
                                                        <input type="button" id="crearclientenit" class="btn btn-primary" value="Crear Cliente" />
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>



                                    </div><!-- tab-pane -->

                                    <div class="widget-bloglist tab-pane" id="frm-segmentos">



                                        <h4 class="text-center">Paso 2 - 3 Segmentos</h4>
                                        <br>
                                        <div class="form-group">

                                            <div class="cols-sm-12">
                                                <?php
                                                $pregunta = Consultas::model()->getPreguntasEncuestaId('1');
                                                ?>
                                                <div id="contenido-pregunta">
                                                    <center><h5 id="pregunta-titulo" data-pregunta="<?php echo $pregunta[0]['IdPregunta']; ?>"><?php echo $pregunta[0]['pregunta'] ?></h5></center>
                                                    <br>
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
                                                    <option value="k">Seleccione</option>
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
                                                        <td class="text-center rs-numero-visita" id=""></td>
                                                        <td class="rs-r1"></td>
                                                        <td class="rs-r2"></td>
                                                        <td class="rs-r3"></td>
                                                        <td class="rs-r4"></td>

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

                                                    <?php if ($arrayclienteexistente[0]['Status'] == 'Todo' || $arrayclienteexistente[0]['Status'] == ''): ?>
                                                        <input type="button" id="cargar-formulario-segmentos-back" class="btn btn-primary" value="Encuesta de Segmentación" />
                                                    <?php endif ?>
                                                    <input type="button" name="crearClienteNuevo" id="crearClienteNuevo" class="btn btn-primary" value="Crear cliente" />
                                                    <input type="hidden" name="IddentificadorForm" id="IddentificadorForm" value="1"/>

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


    <?php } ?>

<?php } ?>



<!--ALERTAS-->


<div class="modal fade" id="alertazonasatienden" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content" style="width:650px;">
            <div class="modal-header">

                <h5 class="modal-title" id="myModalLabel">Zonas Atienden</h5>
            </div>
            <div class="modal-body ">
                <div class="col-sm-2"></div>
                <div class="col-sm-9">
                    <br>
                    <div class="row">
                        <div class="col-sm-4">
                            <label><font color="#0033CC"><b>Cuenta Cliente:</b></font></label>
                        </div>
                        <div class="col-sm-6">
                            <label><?php echo $arrayclienteexistente[0]['CuentaCliente']; ?></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label><font color="#0033CC"><b>Nombre:</b></font></label>
                        </div>
                        <div class="col-sm-6">
                            <?php
                            if ($arrayclienteexistente[0]['CodigoTipoDocumento'] == '001') {

                                $nombrenegocio = $arrayclienteexistente[0]['RazonSocial'];
                            } else {

                                $nombrenegocio = $arrayclienteexistente[0]['PrimerNombre'] . "&nbsp;&nbsp;&nbsp;" . $arrayclienteexistente[0]['PrimerApellido'] . "&nbsp;&nbsp;&nbsp;" . $arrayclienteexistente[0]['SegundoApellido'];
                            }
                            ?>
                            <label><?php echo $nombrenegocio ?></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label><font color="#0033CC"><b>Establecimiento:</b></font></label>
                        </div>
                        <div class="col-sm-6">
                            <label><?php echo $arrayclienteexistente[0]['Establecimiento']; ?></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label><font color="#0033CC"><b>Estado:</b></font></label>
                        </div>
                        <div class="col-sm-6">
                            <?php
                            if ($arrayclienteexistente[0]['Estado'] == 1) {

                                $estado = 'Activo';
                            } else {

                                $estado = 'Inactivo';
                            }
                            ?>
                            <label><?php echo $estado; ?></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label><font color="#0033CC"><b>Dirección:</b></font></label>
                        </div>
                        <div class="col-sm-6">
                            <label><?php echo $arrayclienteexistente[0]['Calle']; ?></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label><font color="#0033CC"><b>Barrio:</b></font></label>
                        </div>
                        <div class="col-sm-6">
                            <label><?php echo $localizacion[0]['NombreBarrio']; ?></label>
                        </div>
                    </div>
                    <div class="row">
                        ------------------------------------------------------------------------------------
                    </div>
                </div>

                <?php foreach ($arrayclienteexistente as $item) { ?>
                    <?php foreach ($item['ZonasVentas'] as $zona) { ?>
                        <div class="col-sm-2"><img src="images/cliente.png" style="width: 60px; height: 60px;"> </div>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-5">
                                    <label class="text-center"><font color="#0033CC"><b>Grupo Ventas:</b></font></label>
                                </div>
                                <div class="col-sm-4">
                                    <label><?php echo $zona['CodigoGrupoVentas']; ?></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5">
                                    <label><font color="#0033CC"><b>Nombre Grupo Ventas:</b></font></label>
                                </div>
                                <div class="col-sm-4">
                                    <label><?php echo $zona['NombreGrupoVentas']; ?></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5">
                                    <label><font color="#0033CC"><b>Código Zona Ventas:</b></font></label>
                                </div>
                                <div class="col-sm-4">
                                    <label><?php echo $zona['CodigoZonaVentas']; ?></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5">
                                    <label><font color="#0033CC"><b>Nombre Zona Ventas:</b></font></label>
                                </div>
                                <div class="col-sm-7">
                                    <label><?php echo $zona['NombreZonaVentas']; ?></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5">
                                    <label><font color="#0033CC"><b>Cupo total:</b></font></label>
                                </div>
                                <div class="col-sm-4">
                                    <label>0</label>
                                </div>
                            </div>
                            <div class="row">
                                ------------------------------------------------------------------------------------
                            </div>
                        </div>

                    <?php } ?>
                <?php } ?>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->


<div class="modal fade" id="alertazonasatiendenCedula" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content" style="width:650px;">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Zonas Atienden</h5>
            </div>
            <div class="modal-body ">
                <div class="col-sm-2"></div>
                                <div class="col-sm-9">
                    <br>
                    <div class="row">
                        <div class="col-sm-4">
                            <label><font color="#0033CC"><b>Cuenta Cliente:</b></font></label>
                        </div>
                        <div class="col-sm-6">
                            <label id="CuantaClienteZona"></label>
                        </div>
                    </div>
                  <!--  <div class="row">
                        <div class="col-sm-4">
                            <label><font color="#0033CC"><b>Nombre:</b></font></label>
                        </div>
                        <div class="col-sm-6">
                            <label id="primerNombre"></label>
                        </div>
                    </div>-->
                    <div class="row">
                        <div class="col-sm-4">
                            <label><font color="#0033CC"><b>Establecimiento:</b></font></label>
                        </div>
                        <div class="col-sm-6">
                            <label id="EstablecimientoZona"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label><font color="#0033CC"><b>Estado:</b></font></label>
                        </div>
                        <div class="col-sm-6">
                            <label id="EstadoZona"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label><font color="#0033CC"><b>Dirección:</b></font></label>
                        </div>
                        <div class="col-sm-6">
                            <label id="DireccionZona"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label><font color="#0033CC"><b>Barrio:</b></font></label>
                        </div>
                        <div class="col-sm-6">
                            <label id="BarrioZona"></label>
                        </div>
                    </div>
                    <div class="row">
                        ------------------------------------------------------------------------------------
                    </div>
                </div>
                <div class="col-sm-2"><img src="images/cliente.png" style="width: 60px; height: 60px;"> </div>
                <div class="col-sm-9" id="DatosZonasCedulas">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->

<div class="modal fade" id="Alertazonasventasvariosnit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content" style="width:650px;">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Zonas Atienden</h5>
            </div>
            <div class="modal-body ">
                <div class="col-sm-2"></div>
                <div class="col-sm-9">
                    <br>
                    <div class="row">
                        <div class="col-sm-4">
                            <label><font color="#0033CC"><b>Cuenta Cliente:</b></font></label>
                        </div>
                        <div class="col-sm-6">
                            <label id="CuantaClienteZona"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label><font color="#0033CC"><b>Nombre:</b></font></label>
                        </div>
                        <div class="col-sm-6">
                            <label id="RazonSocialZona"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label><font color="#0033CC"><b>Establecimiento:</b></font></label>
                        </div>
                        <div class="col-sm-6">
                            <label id="EstablecimientoZona"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label><font color="#0033CC"><b>Estado:</b></font></label>
                        </div>
                        <div class="col-sm-6">
                            <label id="EstadoZona"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label><font color="#0033CC"><b>Dirección:</b></font></label>
                        </div>
                        <div class="col-sm-6">
                            <label id="DireccionZona"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label><font color="#0033CC"><b>Barrio:</b></font></label>
                        </div>
                        <div class="col-sm-6">
                            <label id="BarrioZona"></label>
                        </div>
                    </div>
                    <div class="row">
                        ------------------------------------------------------------------------------------
                    </div>
                </div>

                <div class="col-sm-2"><img src="images/cliente.png" style="width: 60px; height: 60px;"> </div>
                <div class="col-sm-9" id="DatosZonas">
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div><!-- modal-dialog -->
    </div>
</div><!-- modal -->


<div class="modal fade" id="alerta" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id="">Mensaje</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: #DD0000;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body"></p>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-primary" type="button">Aceptar</button>
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->


<div class="modal fade" id="alertcrearclientenit" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id="">Mensaje</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: orange;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body"></p>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button id="aceptarnit" class="btn btn-primary" type="button">Si</button>
                <button data-dismiss="modal" class="btn btn-primary" type="button">No</button>
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->


<div class="modal fade" id="alertcrearclientecedula" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id="">Mensaje</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: orange;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body"></p>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button id="aceptarcedula" class="btn btn-primary" type="button">Si</button>
                <button data-dismiss="modal" class="btn btn-primary" type="button">No</button>
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->


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



<?php $this->renderPartial('//mensajes/_alertConfirmationClientesRuta'); ?> 




