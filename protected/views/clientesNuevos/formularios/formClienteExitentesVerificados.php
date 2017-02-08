<div class="pageheader">
    <h2>
        <img src="images/home.png" alt="Ir al menu" class="cursorpointer" class="cursorpointer" id="retornarMenu"  style="width: 38px; margin-right: 15px; margin-left: 15px;"/>
        Clientes Nuevos <span></span></h2>
</div>
<?php if($identificador == 1){ ?>

    <!--FORMULARIO PARA CLIENTE NUEVO EXISTENTE VERIFICADO TIPO NIT-->
    <?php

    $session = new CHttpSession;
    $session->open();
    $ClientesExistente1 = $session['clienteexistente'];


    ?>


    <form class="form-horizontal" action="" id="frm-cliente-nuevo" method="post" name="frm-cliente-nuevo">

        <div class="panel panel-primary ">

            <div class="panel-heading text-center">
                <h4 class="panel-title">Crear Cliente</h4>
            </div>
            <?php if($arrayclienteexistente[0]['Status'] == 'Todo' || $arrayclienteexistente[0]['Status']==""): ?>
                <input type="hidden" value="1" id="status_cliente">
            <?php else: ?>
                <input type="hidden" value="0" id="status_cliente">
            <?php endif ?>

            <div class="panel-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">

                            <div class="tab-content">
                                <div class="widget-bloglist tab-pane active" id="frm-registrar">

                                    <h4 class="text-center">Paso 1 - 3 Datos personales</h4>

                                    <input type="hidden" id="cuentacliente" name="clienteNuevo[cuentacliente]" value="<?php echo $ClientesExistente1[0]['CuentaCliente'] ?>">
                                    <input type="hidden" id="latitud" name="clienteNuevo[latitud]">
                                    <input type="hidden" id="longitud" name="clienteNuevo[longitud]">

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Tipo de Documento <span class="asterisk">*</span></label>
                                        <div class="col-sm-6">
                                            <?php
                                            $CodTipDoc = $ClientesExistente1[0]['CodigoTipoDocumento'];
                                            $tipoDocumento = Clientenuevo::model()->getTipoDocumento($CodTipDoc);
                                            ?>
                                            <input class="form-control"  type="text" value="<?php echo $tipoDocumento[0]['Nombre']; ?>"  readonly="true">
                                            <input type="hidden" value="<?php echo $tipoDocumento[0]['Codigo']; ?>" id="tipoIdentificavnit" name="clienteNuevo[tipoIdentificacion]">
                                            <label for="name" class="error" style="display: none" id="errorTipoIdentificacion"></label>
                                        </div>
                                    </div>

                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Nit<span class="asterisk">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text" required="" placeholder="" class="form-control" name="clienteNuevo[nitCedula]" id='nit' value="<?php echo $ClientesExistente1[0]['Identificador'] ?>" readonly="true">
                                            <label for="name" class="error" style="display: none" id="errorNitCedula"></label>
                                        </div>
                                    </div>


                                    <?php if($ClientesExistente1[0]['RazonSocial'] != ""){ ?>
                                        <div class="form-group" id="groupNombreRazonSocial">
                                            <label class="col-sm-4 control-label">Razón Social<span class="asterisk">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" required="" placeholder="" class="form-control" name="clienteNuevo[nombreRazonSocial]" id="nombreRazonSocialNit" readonly="true" value="<?php echo $ClientesExistente1[0]['RazonSocial']; ?>">
                                                <label for="name" class="error" style="display: none" id="errorNombreRazonSocial"></label>
                                            </div>
                                        </div>
                                    <?php }else{ ?>
                                        <div class="form-group" id="groupNombreRazonSocial">
                                            <label class="col-sm-4 control-label">Razón Social<span class="asterisk">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" required="" placeholder="" class="form-control" name="clienteNuevo[nombreRazonSocial]" id="nombreRazonSocialNit" maxlength="100">
                                                <label for="name" class="error" style="display: none" id="errorNombreRazonSocial"></label>
                                            </div>
                                        </div>

                                    <?php } ?>


                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Código CIIU<span class="asterisk">*</span></label>
                                        <div class="col-sm-6">
                                            <select class="chosen-select" name="clienteNuevo[codigoCiuu]" data-placeholder="Codigo Ciiu" id="codigoCiiuNit" style="width:  327px;">
                                                <option value=""></option>
                                                <?php
                                                $codciu = $ClientesExistente1[0]['CodigoCIIU'];
                                                $codigoCiiu = Ciiu::model()->findAll();
                                                foreach ($codigoCiiu as $item) {
                                                    ?>
                                                    <?php if($codciu == $item['CodigoCIIU']){ ?>

                                                        <option value="<?php echo $item['CodigoCIIU'] ?>" selected><?php echo $item['NombreCIIU'] ?> <?php echo $item['CodigoCIIU'] ?></option>

                                                    <?php }else{ ?>
                                                        <option value="<?php echo $item['CodigoCIIU'] ?>"><?php echo $item['NombreCIIU'] ?>  <?php echo $item['CodigoCIIU'] ?></option>

                                                    <?php } ?>

                                                    <?php
                                                }

                                                ?>
                                            </select>
                                            <label for="name" class="error" style="display: none" id="errorcodigoCiiuNit"></label>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-sm-4 control-label"></label>
                                        <div class="col-sm-6">
                                            <?php
                                            $codciu = $ClientesExistente1[0]['CodigoCIIU'];
                                            $ciiu = Clientenuevo::model()->getCodCiiu($codciu);
                                            ?>
                                            <label  class="label-control" name="clienteNuevo[codigoCiuu]" id="codigoCiiu"><?php echo $item['CodigoCIIU'] ?>--<?php echo $ciiu[0]['CodigoCIIU']; ?></label>
                                            <label  class="label-control" id="nombreciiu"><?php echo $ciiu[0]['NombreCIIU']; ?></label>
                                        </div>
                                    </div>




                                    <div class="form-group" id="groupEstablecimiento">
                                        <label class="col-sm-4 control-label">Establecimiento <span class="asterisk">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text" required="" placeholder="" class="form-control" name="clienteNuevo[establecimiento]" id="establecimientoNit"  value="<?php echo $ClientesExistente1[0]['Establecimiento']; ?>">
                                            <label for="name" class="error" style="display: none" id="errorEstablecimiento"></label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Ciudades<span class="asterisk">*</span></label>
                                        <div class="col-sm-6">
                                            <select required="" class="chosen-select" id="Ciudades" name="clienteNuevo[ciudades]"  style="width:  327px;">
                                                <option value="0"></option>
                                                <?php
                                                $barrio = $ClientesExistente1[0]['Barrio'];
                                                $localizacion = Clientenuevo::model()->getLocalizacion($barrio);
                                                $ciudadCargada = $localizacion[0]['CodigoCiudad'];
                                                $departametocargado = $localizacion[0]['CodigoDepartamento'];
                                                foreach ($ciudades as $itemCiudades) {
                                                    ?>
                                                    <?php if($ciudadCargada == $itemCiudades['CodigoCiudad'] && $departametocargado == $itemCiudades['CodigoDepartamento']){ ?>

                                                        <option data-ciudad="<?php echo $itemCiudades['CodigoCiudad']; ?>" data-depatamento="<?php echo $itemCiudades['CodigoDepartamento']; ?>" data-barrio="<?php echo $barrio; ?>" selected><?php echo $itemCiudades['NombreCiudad']; ?></option>

                                                    <?php }else{ ?>

                                                        <option data-ciudad="<?php echo $itemCiudades['CodigoCiudad']; ?>" data-depatamento="<?php echo $itemCiudades['CodigoDepartamento']; ?>"><?php echo $itemCiudades['NombreCiudad']; ?></option>

                                                    <?php } ?>
                                                    <?php
                                                }

                                                ?>
                                                <script>
                                                    //alert("entre");
                                                    verificaCiudades('<?php echo $itemCiudades['CodigoCiudad'];?>','<?php echo $itemCiudades['CodigoDepartamento'];?>','<?php echo $barrio; ?>');
                                                </script>
                                            </select>
                                            <label for="name" class="error" style="display: none" id="errorCiudades"></label>
                                        </div>
                                        <div class="col-sm-1" id="img-cargar-departamento">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Departamentos<span class="asterisk">*</span></label>
                                        <div class="col-sm-6">
                                            <div id="Departamentos"></div>
                                            <label for="name" class="error" style="display: none" id="errorDepartamentos"></label>
                                        </div>
                                        <div class="col-sm-1" id="img-cargar-ciudades">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Barrio<span class="asterisk">*</span></label>
                                        <div class="col-sm-6">
                                            <div id="Barrios"></div>
                                            <label for="name" class="error"style="display: none" id="errorBarrios"></label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Otro Barrio</label>
                                        <div class="col-sm-6">
                                            <div id="OtroBarrio"></div>
                                            <label for="name" class="error"style="display: none" id="errorBarrios"></label>
                                        </div>
                                        <div class="col-sm-1" id="img-cargar-otrobarrio">

                                        </div>
                                    </div>

                                    <div class="col-md-offset-5">
                                        <label >Direccion:  (Ej. Calle 97 # 23-60)</label>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-5">
                                            <select class="chosen-select" id="via" style="width: 220px;">
                                                <option value="0">Seleccione</option>
                                                <?php

                                                if ($vias) {
                                                    foreach ($vias as $itemvia) {
                                                        ?>
                                                        <option value="<?php echo $itemvia['Tipo']; ?>"><?php echo $itemvia['Descripcion']; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="col-sm-6">
                                                <input class="form-control mayusculas" id="direcnit" style="height: 35px; width: 130px;">
                                            </div>
                                            <div class="col-sm-1">
                                                <label><font size="5">#</font></label>
                                            </div>
                                            <div class="col-sm-5">
                                                <input class="form-control mayusculas" id="numeronit" style="height: 35px;">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="button" class="btn btn-primary" id="agregardireccionnit" value="Agregar Direccion" style="height:27px;">
                                            <script>
                                                $("#agregardireccionnit").click(function (){

                                                    var via = $("#via").val();
                                                    var direc = $("#direcnit").val();
                                                    var numero = $("#numeronit").val();
                                                    var tipoviacomplemento = $("#tipoviacomplemento").val();
                                                    var direccioncomplementaria = $("#direccioncomplementaria").val();

                                                    if(via == 0){
                                                        via = '';
                                                    }

                                                    if(tipoviacomplemento == 0){
                                                        tipoviacomplemento = '' ;
                                                    }

                                                    $("#direccionNit").val(via + " " + direc + " " + numero + " " +  tipoviacomplemento + " " + direccioncomplementaria);

                                                });
                                            </script>
                                        </div>
                                    </div>
                                    <br>

                                    <div class="col-md-offset-5">
                                        <label >Complementario:  (Ej. INT 2 AP 505)</label>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"></label>
                                        <div class="col-sm-4">
                                            <select class="chosen-select" id="tipoviacomplemento" style="width: 220px;">
                                                <option value="0">Seleccione</option>
                                                <?php

                                                if ($tipoviacomplemento) {
                                                    foreach ($tipoviacomplemento as $itemviacomplemento) {
                                                        ?>
                                                        <option value="<?php echo $itemviacomplemento['Tipo']; ?>"><?php echo $itemviacomplemento['Descripcion']; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <input class="form-control mayusculas" id="direccioncomplementaria" style="height: 35px;">
                                        </div>
                                        <div class="col-sm-4 col-md-offset-5">
                                            <label for="name" class="error" style="display: none" id="errorTipocomplemento"></label>
                                        </div>
                                    </div>



                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Dirección<span class="asterisk">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="clienteNuevo[direccion]" id="direccionNit" value="<?php echo $ClientesExistente1[0]['Calle']; ?>" readonly="true">
                                            <label for="name" class="error" style="display: none" id="errorDireccion"></label>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Teléfono</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="clienteNuevo[telefono]" id="telefonoNit" value="<?php echo $ClientesExistente1[0]['Telefono']; ?>">
                                            <label for="name" class="error" style="display: none" id="errorTelefono"></label>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Teléfono Móvil</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="clienteNuevo[telefonoMovil]" id="telefonoMovilNit" value="<?php echo $ClientesExistente1[0]['TelefonoMovil']; ?>">
                                            <label for="name" class="error" style="display: none" id="errorTelefonoMovil"></label>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Correo Electrónico</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="clienteNuevo[correo]" id="emailNit" value="<?php echo $ClientesExistente1[0]['CorreoElectronico']; ?>" maxlength="50">
                                            <label for="name" class="error" style="display: none" id="errorCorreo"></label>
                                        </div>
                                        <div id="ErrorEmail" class="col-sm-5"></div>
                                    </div>

                                    <div class="panel-footer">
                                        <div class="row">
                                            <div class="col-sm-9 col-sm-offset-3 text-center">
                                                <!-- evento funciones.js -->
                                                <input type="button" id="cargar-formulario-segmentos-nit" class="btn btn-primary" value="Siguiente" />
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
                                                <?php if($arrayclienteexistente[0]['Status'] == 'Todo' || $arrayclienteexistente[0]['Status'] == ''): ?>
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
                </div>
            </div>
        </div><!-- panel-body -->
    </form>


<?php }else if($identificador == 2){ ?>

    <!--FORMULARIO PARA CLIENTE NUEVO EXISTENTE VERIFICADO NORMAL-->

    <?php

    $session = new CHttpSession;
    $session->open();
    $ClientesExistente2 = $session['clienteexistente'];

    /*echo '<pre>';
    print_r($ClientesExistente2);*/

    ?>


    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" action="" id="frm-cliente-nuevo" method="post" name="frm-cliente-nuevo">


                <div class="panel panel-primary ">



                    <div class="panel-heading text-center">
                        <h4 class="panel-title">Crear Cliente</h4>

                    </div>
                    <?php if($arrayclienteexistente[0]['Status'] == 'Todo' || $arrayclienteexistente[0]['Status'] == ''): ?>
                        <input type="hidden" value="1" id="status_cliente">
                    <?php else: ?>
                        <input type="hidden" value="0" id="status_cliente">
                    <?php endif ?>
                    <div class="panel-body">

                        <div class="col-md-8 col-md-offset-2">

                            <div class="tab-content">
                                <div class="widget-bloglist tab-pane active" id="frm-registrar">

                                    <h4 class="text-center">Paso 1 - 3 Datos personales</h4>

                                    <input type="hidden" id="cuentacliente" name="clienteNuevo[cuentacliente]" value="<?php echo $ClientesExistente2[0]['CuentaCliente'] ?>">
                                    <input type="hidden" id="latitud" name="clienteNuevo[latitud]">
                                    <input type="hidden" id="longitud" name="clienteNuevo[longitud]">

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Tipo de Documento <span class="asterisk">*</span></label>
                                        <div class="col-sm-6">
                                            <?php
                                            $CodTipDoc = $ClientesExistente2[0]['CodigoTipoDocumento'];
                                            $tipoDocumento = Clientenuevo::model()->getTipoDocumento($CodTipDoc);
                                            ?>
                                            <input class="form-control"  type="text" value="<?php echo $tipoDocumento[0]['Nombre']; ?>"  readonly="true">
                                            <input type="hidden" value="<?php echo $tipoDocumento[0]['Codigo']; ?>" id="tipoIdentificacionvp" name="clienteNuevo[tipoIdentificacion]">
                                            <label for="name" class="error" style="display: none" id="errorTipoIdentificacion"></label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Cedula<span class="asterisk">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text"  class="form-control" name="clienteNuevo[nitCedula]" id="Cedula"  value="<?php echo $ClientesExistente2[0]['Identificador']; ?>" readonly="true">
                                            <label for="name" class="error" style="display: none" id="errorNitCedula"></label>
                                        </div>
                                    </div>

                                    <?php if($ClientesExistente2[0]['PrimerNombre'] != ""){ ?>
                                        <div class="form-group" id="groupPrimerNombre">
                                            <label class="col-sm-4 control-label">Primer Nombre<span class="asterisk">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" required="" placeholder="" class="form-control" name="clienteNuevo[primerNombre]" id="primerNombre" value="<?php echo  $ClientesExistente2[0]['PrimerNombre'] ?>" readonly="true">
                                                <label for="name" class="error" style="display: none" id="errorPrimerNombre"></label>
                                            </div>
                                        </div>
                                    <?php }else{ ?>
                                        <div class="form-group" id="groupPrimerNombre">
                                            <label class="col-sm-4 control-label">Primer Nombre<span class="asterisk">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" required="" placeholder="" class="form-control" name="clienteNuevo[primerNombre]" id="primerNombre">
                                                <label for="name" class="error" style="display: none" id="errorPrimerNombre"></label>
                                            </div>
                                        </div>
                                    <?php } ?>


                                    <?php if($ClientesExistente2[0]['SegundoNombre'] != ""){ ?>
                                        <div class="form-group" id="groupSegundoNombre">
                                            <label class="col-sm-4 control-label">Segundo Nombre</label>
                                            <div class="col-sm-6">
                                                <input type="text" required="" placeholder="" class="form-control" name="clienteNuevo[segundoNombre]" id="segundoNombre" value="<?php echo $ClientesExistente2[0]['SegundoNombre'] ?>" readonly="true">
                                                <label for="name" class="error" style="display: none" id="errorSegundoNombre"></label>
                                            </div>
                                        </div>
                                    <?php }else{ ?>
                                        <div class="form-group" id="groupSegundoNombre">
                                            <label class="col-sm-4 control-label">Segundo Nombre</label>
                                            <div class="col-sm-6">
                                                <input type="text" required="" placeholder="" class="form-control" name="clienteNuevo[segundoNombre]" id="segundoNombre">
                                                <label for="name" class="error" style="display: none" id="errorSegundoNombre"></label>
                                            </div>
                                        </div>

                                    <?php } ?>

                                    <?php if($ClientesExistente2[0]['PrimerApellido'] !=""){ ?>
                                        <div class="form-group" id="groupPrimerApellido">
                                            <label class="col-sm-4 control-label">Primer Apellido<span class="asterisk">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" required="" placeholder="" class="form-control" name="clienteNuevo[primerApellido]" id="primerApellido" value="<?php echo $ClientesExistente2[0]['PrimerApellido'] ?>" readonly="true">
                                                <label for="name" class="error" style="display: none" id="errorPrimerApellido"></label>
                                            </div>
                                        </div>
                                    <?php }else{ ?>
                                        <div class="form-group" id="groupPrimerApellido">
                                            <label class="col-sm-4 control-label">Primer Apellido<span class="asterisk">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" required="" placeholder="" class="form-control" name="clienteNuevo[primerApellido]" id="primerApellido">
                                                <label for="name" class="error" style="display: none" id="errorPrimerApellido"></label>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <?php if($ClientesExistente2[0]['SegundoApellido'] !=""){ ?>
                                        <div class="form-group" id="groupSegundoApellido">
                                            <label class="col-sm-4 control-label">Segundo Apellido</label>
                                            <div class="col-sm-6">
                                                <input type="text" required="" placeholder="" class="form-control" name="clienteNuevo[segundoApellido]" id="segundoApellido" value="<?php echo $ClientesExistente2[0]['SegundoApellido'] ?>" readonly="true">
                                                <label for="name" class="error" style="display: none" id="errorSegundoApellido"></label>
                                            </div>
                                        </div>
                                    <?php }else{ ?>
                                        <div class="form-group" id="groupSegundoApellido">
                                            <label class="col-sm-4 control-label">Segundo Apellido</label>
                                            <div class="col-sm-6">
                                                <input type="text" required="" placeholder="" class="form-control" name="clienteNuevo[segundoApellido]" id="segundoApellido">
                                                <label for="name" class="error" style="display: none" id="errorSegundoApellido"></label>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Código CIIU<span class="asterisk">*</span></label>
                                        <div class="col-sm-6">
                                            <select class="chosen-select" name="clienteNuevo[codigoCiuu]" data-placeholder="Codigo Ciiu" id="codigoCiiunit" style="width:  327px;">
                                                <option value=""></option>
                                                <?php
                                                $codciu = $ClientesExistente2[0]['CodigoCIIU'];
                                                $codigoCiiu = Ciiu::model()->findAll();
                                                foreach ($codigoCiiu as $item) {
                                                    ?>
                                                    <?php if($codciu == $item['CodigoCIIU']){ ?>

                                                        <option value="<?php echo $item['CodigoCIIU'] ?>" selected><?php echo $item['NombreCIIU'] ?> <?php echo $item['CodigoCIIU'] ?></option>

                                                    <?php }else{ ?>
                                                        <option value="<?php echo $item['CodigoCIIU'] ?>"><?php echo $item['NombreCIIU'] ?> <?php echo $item['CodigoCIIU'] ?></option>

                                                    <?php } ?>

                                                    <?php
                                                }

                                                ?>
                                            </select>
                                            <label for="name" class="error" style="display: none" id="errorCodigoCiiuPersona"></label>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-sm-4 control-label"></label>
                                        <div class="col-sm-6">
                                            <?php
                                            $codciu = $ClientesExistente2[0]['CodigoCIIU'];
                                            $ciiu = Clientenuevo::model()->getCodCiiu($codciu);
                                            ?>
                                            <label  class="label-control" name="clienteNuevo[codigoCiuu]" id="codigoCiiu"><?php echo $ciiu[0]['CodigoCIIU']; ?></label>
                                            <label  class="label-control" id="nombreciiu"><?php echo $ciiu[0]['NombreCIIU']; ?></label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Establecimiento <span class="asterisk">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text" required="" placeholder="Establecimiento" class="form-control" name="clienteNuevo[establecimiento]" id="establecimientoPersona" value="<?php echo $ClientesExistente2[0]['Establecimiento'] ?>">
                                            <label for="name" class="error" style="display: none" id="errorEstablecimientoPersona"></label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Ciudades<span class="asterisk">*</span></label>
                                        <div class="col-sm-6">
                                            <select required="" class="chosen-select" id="Ciudades" name="clienteNuevo[ciudades]"  style="width:  327px;">
                                                <option value="0"></option>
                                                <?php
                                                $barrio = $ClientesExistente2[0]['Barrio'];
                                                $localizacion = Clientenuevo::model()->getLocalizacion($barrio);
                                                $ciudadCargada = $localizacion[0]['CodigoCiudad'];
                                                $departametocargado = $localizacion[0]['CodigoDepartamento'];
                                                foreach ($ciudades as $itemCiudades) {
                                                    ?>
                                                    <?php if($ciudadCargada == $itemCiudades['CodigoCiudad'] && $departametocargado == $itemCiudades['CodigoDepartamento']){ ?>

                                                        <option data-ciudad="<?php echo $itemCiudades['CodigoCiudad']; ?>" data-depatamento="<?php echo $itemCiudades['CodigoDepartamento']; ?>" data-barrio="<?php echo $barrio; ?>" selected><?php echo $itemCiudades['NombreCiudad']; ?></option>

                                                    <?php }else{ ?>

                                                        <option data-ciudad="<?php echo $itemCiudades['CodigoCiudad']; ?>" data-depatamento="<?php echo $itemCiudades['CodigoDepartamento']; ?>" data-barrio="<?php echo $barrio; ?>" ><?php echo $itemCiudades['NombreCiudad']; ?></option>

                                                    <?php } ?>
                                                    <?php
                                                }

                                                ?>
                                                <script>
                                                    //alert("entre");
                                                    verificaCiudades('<?php echo $itemCiudades['CodigoCiudad'];?>','<?php echo $itemCiudades['CodigoDepartamento'];?>','<?php echo $barrio;?>');
                                                </script>
                                            </select>
                                            <label for="name" class="error" style="display: none" id="errorCiudades"></label>
                                        </div>
                                        <div class="col-sm-1" id="img-cargar-departamento">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Departamentos<span class="asterisk">*</span></label>
                                        <div class="col-sm-6">
                                            <div id="Departamentos"></div>
                                            <label for="name" class="error" style="display: none" id="errorDepartamentos"></label>
                                        </div>
                                        <div class="col-sm-1" id="img-cargar-ciudades">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Barrio<span class="asterisk">*</span></label>
                                        <div class="col-sm-6">
                                            <div id="Barrios"></div>
                                            <label for="name" class="error"style="display: none" id="errorBarrios"></label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Otro Barrio</label>
                                        <div class="col-sm-6">
                                            <div id="OtroBarrio"></div>
                                            <label for="name" class="error"style="display: none" id="errorBarrios"></label>
                                        </div>
                                        <div class="col-sm-1" id="img-cargar-otrobarrio">

                                        </div>
                                    </div>

                                    <div class="col-md-offset-5">
                                        <label >Direcciones:  (Ej. Calle 97 # 23-60)</label>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-4">
                                            <select class="chosen-select" id="via" style="width: 220px;">
                                                <option value="0">Seleccione</option>
                                                <?php

                                                if ($vias) {
                                                    foreach ($vias as $itemvia) {
                                                        ?>
                                                        <option value="<?php echo $itemvia['Tipo']; ?>"><?php echo $itemvia['Descripcion']; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-sm-5">
                                            <div class="col-sm-6">
                                                <input class="form-control mayusculas" id="direc" style="height: 35px; width:130px;">
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="text-center"><font size="5">#</font></label>
                                            </div>
                                            <div class="col-sm-5">
                                                <input class="form-control mayusculas" id="numero" style="height: 35px;">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="button" class="btn btn-primary" id="agregardireccionclienteverificado" value="Agregar Direccion" style="height:27px;">
                                        </div>
                                    </div>

                                    <br>

                                    <div class="col-md-offset-5">
                                        <label >Complementario:  (Ej. INT 2 AP 505)</label>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"></label>
                                        <div class="col-sm-4">
                                            <select class="chosen-select" id="tipoviacomplemento" style="width: 220px;">
                                                <option value="0">Seleccione</option>
                                                <?php

                                                if ($tipoviacomplemento) {
                                                    foreach ($tipoviacomplemento as $itemviacomplemento) {
                                                        ?>
                                                        <option value="<?php echo $itemviacomplemento['Tipo']; ?>"><?php echo $itemviacomplemento['Descripcion']; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <input class="form-control mayusculas" id="direccioncomplementaria" style="height: 35px;">
                                        </div>
                                        <div class="col-sm-4 col-md-offset-5">
                                            <label for="name" class="error" style="display: none" id="errorTipocomplemento"></label>
                                        </div>
                                    </div>



                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Dirección</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="clienteNuevo[direccion]" id="direccionP" value="<?php echo $ClientesExistente2[0]['Calle'] ?>" readonly="true">
                                            <label for="name" class="error" style="display: none" id="errorDireccion"></label>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Teléfono</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="clienteNuevo[telefono]" id="telefonoP" value="<?php echo $ClientesExistente2[0]['Telefono'] ?>" onkeypress="return FilterInput(event)">
                                            <label for="name" class="error" style="display: none" id="errorTelefono"></label>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Teléfono Móvil</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="clienteNuevo[telefonoMovil]" id="telefonoMovilP" value="<?php echo $ClientesExistente2[0]['TelefonoMovil'] ?>" onkeypress="return FilterInput(event)">
                                            <label for="name" class="error" style="display: none" id="errorTelefonoMovil"></label>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Correo Electrónico</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="clienteNuevo[correo]" id="emailP" onblur="validarEmail()" maxlength="50" value="<?php echo $ClientesExistente2[0]['CorreoElectronico'] ?>">
                                            <label for="name" class="error" style="display: none" id="errorCorreo"></label>
                                        </div>
                                        <div id="ErrorEmail" class="col-sm-5"></div>
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
                                                <?php if($arrayclienteexistente[0]['Status'] == 'Todo' || $arrayclienteexistente[0]['Status'] == ''): ?>
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

<?php }?>

<?php $this->renderPartial('//mensajes/_alertConfirmationClientesRuta');?>


<div class="modal fade" id="alertaFrecuenciaNoSeleccionada" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id="myModalLabel">Mensaje Crear Cliente</h5>
            </div>
            <?php if($arrayclienteexistente[0]['Status'] == 'Todo' || $arrayclienteexistente[0]['Status'] == ''): ?>
                <input type="hidden" value="1" id="status_cliente">
            <?php else: ?>
                <input type="hidden" value="0" id="status_cliente">
            <?php endif ?>            
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


