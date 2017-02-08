<?php

class ClientesNuevosController extends Controller {

    public function filters() {
        return array('accessControl'); // perform access control for CRUD operations
    }

    public function accessRules() {
        return array(
            array('allow', // allow authenticated users to access all actions
                'users' => array('@'),
            ),
            array('deny'),
        );
    }

    public function actionClientesNuevos() {
        /*  echo 'buenas';
          die(); */

        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/clienteNuevo/clientenuevo.js', CClientScript::POS_END
        );

        Yii::import('application.extensions.libreria_digito_verificacion');


        $TipoDocumento = $_POST['clienteNuevo']['tipoIdentificacion'];

        $session = new CHttpSession;
        $session->open();

        $codagencia = Yii::app()->user->_Agencia;
        $codAsesor = Yii::app()->user->_cedula;
        $consultaZona = Consultas::model()->getZonaAsesor($codAsesor);
        $consultaCanal = Consultas::model()->getNombreCanal($codAsesor);
        $zonaAsesor = $consultaZona['CodZonaVentas'];
        $NombreCanal = $consultaCanal['NombreCanal'];
        $posicion = $_POST['hour'] . ':' . $_POST['minute'] . ':00';
        $identificador = $_POST['clienteNuevo']['nitCedula'];
        $canal = $session['canalEmpleado'];
        if ($_POST['IddentificadorForm'] == 1) {



            if ($_POST['clienteNuevo']) {

                if ($TipoDocumento == '001' || $TipoDocumento == '008') {

                    $dgv = libreria_digito_verificacion::calcular_digito($identificador);
                    echo $dgv;

                    if ($_POST['clienteNuevo']['barrios'] == '0') {

                        $codBarrio = $_POST['clienteNuevo']['otrobarrio'];
                    } else {

                        $codBarrio = $_POST['clienteNuevo']['barrios'];
                    }


                    if ($_POST['clienteNuevo']['otrobarrio'] == '') {

                        $OtroBarrio = '0';
                    } else {

                        $OtroBarrio = $_POST['clienteNuevo']['otrobarrio'];
                    }

                    if ($_POST['clienteNuevo']['telefono'] == '') {

                        $telefono = '0';
                    } else {

                        $telefono = $_POST['clienteNuevo']['telefono'];
                    }


                    if ($session['Responsable'] == '') {

                        $responsable = '';
                    } else {

                        $responsable = $session['Responsable'];
                    }


                    $RutaSeleccionada = $session['clienteSeleccionado']['diaRuta'];

                    if ($RutaSeleccionada > 0 && $RutaSeleccionada < 7) {
                        $SemanaRuta = "R1";
                    } else if ($RutaSeleccionada > 6 && $RutaSeleccionada < 13) {
                        $SemanaRuta = "R2";
                    } else if ($RutaSeleccionada > 12 && $RutaSeleccionada < 19) {
                        $SemanaRuta = "R3";
                    } else if ($RutaSeleccionada > 18 && $RutaSeleccionada < 25) {
                        $SemanaRuta = "R4";
                    }



                    $rutazonalogistica = $_POST['clienteNuevo']['numeroVisita'];
                    $ZonaLogistica = Consultas::model()->getZonaLogistioca($SemanaRuta, $RutaSeleccionada, $zonaAsesor);

                    $clienteNuevo = array(
                        'CodZonaVentas' => $zonaAsesor,
                        'CodAsesor' => $codAsesor,
                        'CuentaCliente' => $_POST['clienteNuevo']['cuentacliente'],
                        'Identificacion' => $_POST['clienteNuevo']['nitCedula'],
                        'DigitoVerificacion' => $dgv,
                        'CodTipoDocumento' => $_POST['clienteNuevo']['tipoIdentificacion'],
                        'Nombre' => '',
                        'RazonSocial' => $_POST['clienteNuevo']['nombreRazonSocial'],
                        'Establecimiento' => $_POST['clienteNuevo']['establecimiento'],
                        'CodigoCiuu' => $_POST['clienteNuevo']['codigoCiuu'],
                        'PrimerNombre' => $_POST['clienteNuevo']['primerNombre'],
                        'SegundoNombre' => $_POST['clienteNuevo']['segundoNombre'],
                        'PrimerApellido' => $_POST['clienteNuevo']['primerApellido'],
                        'SegundoApellido' => $_POST['clienteNuevo']['segundoApellido'],
                        'Direccion' => $_POST['clienteNuevo']['direccion'],
                        'CodBarrio' => $codBarrio,
                        'Telefono' => $telefono,
                        'TelefonoMovil' => $_POST['clienteNuevo']['telefonoMovil'],
                        'Email' => $_POST['clienteNuevo']['correo'],
                        //'CodCadenadeEmpresa' => $codigoSegmentacion['IdCodigoSegmentacion'],
                        'NumeroVisita' => $_POST['clienteNuevo']['numeroVisita'],
                        'OtroBarrio' => $OtroBarrio,
                        'Posicion' => $posicion,
                        'Latitud' => $_POST['clienteNuevo']['latitud'],
                        'Longitud' => $_POST['clienteNuevo']['longitud'],
                        'ZonaLogistica' => $ZonaLogistica['CodigoZonaLogistica'],
                        'CodigoPostal' => '',
                        'DireccionEstandar' => '',
                        'FechaRegistro' => date('Y-m-d'),
                        'HoraRegistro' => date('H:i:s'),
                        'Estado' => '0',
                        'Generado' => '0',
                        'Enviado' => '0',
                        'ArchivoXml' => '',
                        'IdentificadorEnvio' => '1',
                        'CodigoCanal' => $canal,
                        'NombreCanal' => $NombreCanal,
                        'Responsable' => $responsable
                    );

                    if ($_POST['respuesta'] !== '') {
                        $respuesta = $_POST['clienteNuevo']['respuesta'];
                        $codigoSegmentacion = Consultas::model()->getSegmentacionIdRespuesta($respuesta);
                        $clienteNuevo['CodCadenadeEmpresa'] = $codigoSegmentacion['IdCodigoSegmentacion'];
                    }

                    $model = new Clientenuevo;
                    $model->attributes = $clienteNuevo;


                    if (!$model->validate()) {
                        print_r($model->getErrors());
                    } else {
                        $model->save();

                        $codtipodoc = '9';
                        $estado = '0';

                        $TransferAx = array(
                            'CodTipoDocumentoActivity' => $codtipodoc,
                            'IdDocumento' => $model->Id,
                            'CodigoAgencia' => $codagencia,
                            'EstadoTransaccion' => $estado
                        );


                        $modeltransax = new Transaccionesax;
                        $modeltransax->attributes = $TransferAx;

                        if (!$modeltransax->validate()) {

                            print_r($modeltransax->getErrors());
                        } else {

                            $modeltransax->save();
                        }


                        Yii::app()->user->setFlash('success', "Datos guardados satisfactoriamente, recuerde esperar unos minutos y refrescar la pagina antes de realizar la consulta del cliente. Se sugiere realizar la busqueda por el nombre");

                        $this->redirect('index.php?r=Clientes/ClientesRutas');
                    }
                } else {

                    $Nombre = $_POST['clienteNuevo']['primerNombre'] . '-' . $_POST['clienteNuevo']['primerApellido'];

                    if ($_POST['clienteNuevo']['barrios'] == '0') {

                        $codBarrio = $_POST['clienteNuevo']['otrobarrio'];
                    } else {

                        $codBarrio = $_POST['clienteNuevo']['barrios'];
                    }


                    if ($_POST['clienteNuevo']['otrobarrio'] == '') {

                        $OtroBarrio = '0';
                    } else {

                        $OtroBarrio = $_POST['clienteNuevo']['otrobarrio'];
                    }

                    if ($_POST['clienteNuevo']['telefono'] == '') {

                        $telefono = '0';
                    } else {

                        $telefono = $_POST['clienteNuevo']['telefono'];
                    }


                    if ($session['Responsable'] == '') {

                        $responsable = '';
                    } else {

                        $responsable = $session['Responsable'];
                    }

//                    $respuesta = $_POST['clienteNuevo']['respuesta'];


                    $RutaSeleccionada = $session['clienteSeleccionado']['diaRuta'];

                    if ($RutaSeleccionada > 0 && $RutaSeleccionada < 7) {
                        $SemanaRuta = "R1";
                    } else if ($RutaSeleccionada > 6 && $RutaSeleccionada < 13) {
                        $SemanaRuta = "R2";
                    } else if ($RutaSeleccionada > 12 && $RutaSeleccionada < 19) {
                        $SemanaRuta = "R3";
                    } else if ($RutaSeleccionada > 18 && $RutaSeleccionada < 25) {
                        $SemanaRuta = "R4";
                    }

                    //$codigoSegmentacion = Consultas::model()->getSegmentacionIdRespuesta($respuesta);
                    $rutazonalogistica = $_POST['clienteNuevo']['numeroVisita'];
                    $ZonaLogistica = Consultas::model()->getZonaLogistioca($SemanaRuta, $RutaSeleccionada, $zonaAsesor);


                    $clienteNuevo = array(
                        'CodZonaVentas' => $zonaAsesor,
                        'CodAsesor' => $codAsesor,
                        'CuentaCliente' => $_POST['clienteNuevo']['cuentacliente'],
                        'Identificacion' => $_POST['clienteNuevo']['nitCedula'],
                        'DigitoVerificacion' => '',
                        'CodTipoDocumento' => $_POST['clienteNuevo']['tipoIdentificacion'],
                        'Nombre' => $Nombre,
                        'RazonSocial' => '',
                        'Establecimiento' => $_POST['clienteNuevo']['establecimiento'],
                        'CodigoCiuu' => $_POST['clienteNuevo']['codigoCiuu'],
                        'PrimerNombre' => $_POST['clienteNuevo']['primerNombre'],
                        'SegundoNombre' => $_POST['clienteNuevo']['segundoNombre'],
                        'PrimerApellido' => $_POST['clienteNuevo']['primerApellido'],
                        'SegundoApellido' => $_POST['clienteNuevo']['segundoApellido'],
                        'Direccion' => $_POST['clienteNuevo']['direccion'],
                        'CodBarrio' => $codBarrio,
                        'Telefono' => $telefono,
                        'TelefonoMovil' => $_POST['clienteNuevo']['telefonoMovil'],
                        'Email' => $_POST['clienteNuevo']['correo'],
                        //'CodCadenadeEmpresa' => $codigoSegmentacion['IdCodigoSegmentacion'],
                        'NumeroVisita' => $_POST['clienteNuevo']['numeroVisita'],
                        'OtroBarrio' => $OtroBarrio,
                        'Posicion' => $posicion,
                        'Latitud' => $_POST['clienteNuevo']['latitud'],
                        'Longitud' => $_POST['clienteNuevo']['longitud'],
                        'ZonaLogistica' => $ZonaLogistica['CodigoZonaLogistica'],
                        'CodigoPostal' => '',
                        'DireccionEstandar' => '',
                        'FechaRegistro' => date('Y-m-d'),
                        'HoraRegistro' => date('H:i:s'),
                        'Estado' => '0',
                        'Generado' => '0',
                        'Enviado' => '0',
                        'ArchivoXml' => '',
                        'IdentificadorEnvio' => '1',
                        'CodigoCanal' => $canal,
                        'NombreCanal' => $NombreCanal,
                        'Responsable' => $responsable
                    );

                    if ($_POST['respuesta'] !== '') {

                        $respuesta = $_POST['clienteNuevo']['respuesta'];
                        $codigoSegmentacion = Consultas::model()->getSegmentacionIdRespuesta($respuesta);
                        $clienteNuevo['CodCadenadeEmpresa'] = $codigoSegmentacion['IdCodigoSegmentacion'];
                    }
                    $model = new Clientenuevo;
                    $model->attributes = $clienteNuevo;

                    if (!$model->validate()) {
                        print_r($model->getErrors());
                    } else {
                        $model->save();

                        $codtipodoc = '9';
                        $estado = '0';

                        $TransferAx = array(
                            'CodTipoDocumentoActivity' => $codtipodoc,
                            'IdDocumento' => $model->Id,
                            'CodigoAgencia' => $codagencia,
                            'EstadoTransaccion' => $estado
                        );


                        $modeltransax = new Transaccionesax;
                        $modeltransax->attributes = $TransferAx;

                        if (!$modeltransax->validate()) {

                            print_r($modeltransax->getErrors());
                        } else {

                            $modeltransax->save();
                        }

                        Yii::app()->user->setFlash('success', "Datos guardados satisfactoriamente, recuerde esperar unos minutos antes de realizar la consulta del cliente. Se sugiere realizar la busqueda por el nombre");

                        $this->redirect('index.php?r=Clientes/ClientesRutas');
                    }
                }
            }
        }


        if ($_POST['identificacionCliente']) {

            $session = new CHttpSession;
            $session->open();

            $tipoDocumento = $_POST['tipoIdentificacion'];
            $Identificador = trim($_POST['identificacionCliente']);
            $rutaSeleccionada = $_POST['rutaSeleccionada'];
            $zonaVentas = $_POST['zonaVentas'];


            $update = Clientenuevo::model()->getEliminarClienteVacio();

            $clientenuevomax = Clientenuevo::model()->getMaxClienteNuevo($Identificador);

            $deleteclienteverificadozonaventas = Clientenuevo::model()->getDeleteClienteVerificadoZonaVentas($clientenuevomax);

            $delteclienteverifiacado = Clientenuevo::model()->getEliminarCliente($Identificador);

            $inseertclienteverificado = Clientenuevo::model()->getInsertClienteVerificado($Identificador, $tipoDocumento);

            sleep(20);

            $clienteverificado = Clientenuevo::model()->getClienteVerificado($Identificador);




            $estado = 0;
            if ($clienteverificado[0]['FacturaEntregaEspera'] == "No" || $clienteverificado[0]['FacturaEntregaEspera'] == "no" || $clienteverificado[0]['FacturaEntregaEspera'] == "NO" || $clienteverificado[0]['FacturaEntregaEspera'] == "nO" || $clienteverificado[0]['FacturaEntregaEspera'] == 'Pedido') {

                $estado = 1;
            } else {

                $estado = 0;
            }


            $IdClienteVerificado = $clienteverificado[0]['CuentaCliente'];

            $zonaventascleinteverificado = Clientenuevo::model()->getZovantasVerificadas($IdClienteVerificado);


            $grupoventas = Clientenuevo::model()->getCodGrupoVentas($zonaVentas);
            $ciudades = ModelClientesNuevos::model()->getBuscarCiudades();
            $tipovia = ModelClientesNuevos::model()->getTipovia();
            $tipoviacomplemento = ModelClientesNuevos::model()->getTipoViaComplemento();


            $datosDos = array();
            $datos = array();
            $cont = 0;
            foreach ($zonaventascleinteverificado as $zonas) {

                if ($grupoventas[0]['CodigoGrupoVentas'] == $zonas['CodigoGrupoVentas']) {

                    $cont++;
                }

                $jsonDos = array(
                    'CodigoZonaVentas' => $zonas['CodigoZonaVentas'],
                    'CedulaAsesor' => $zonas['CedulaAsesorComercial'],
                    'NombreZonaVentas' => $zonas['NombreAsesorComercial'],
                    'CodigoGrupoVentas' => $zonas['CodigoGrupoVentas'],
                    'NombreGrupoVentas' => $zonas['NombreGrupoVentas'],
                    'CupoTotal' => $zonas['CupoTotal']);

                array_push($datosDos, $jsonDos);
            }

            if ($cont > 0 && $estado = 1) {

                $GrupoVentasIguales = '1';
            } else {

                $GrupoVentasIguales = '2';
            }


            if ($clienteverificado[0]['Origen'] == "CIFIN" || $clienteverificado[0]['Origen'] == "") {
                //if ($clienteverificado[0]['CuentaCliente'] == "") {

                $arrayclientenoexistente = array(
                    'Identificador' => $clienteverificado[0]['Identificador'],
                    'CodigoTipoDocumento' => $clienteverificado[0]['CodigoTipoDocumento'],
                    'Estado' => $estado,
                    'CuentaCliente' => $clienteverificado[0]['CuentaCliente'],
                    'TipoDocumento' => $clienteverificado[0]['TipoDocumento'],
                    'TipoRegistro' => $clienteverificado[0]['TipoRegistro'],
                    'CodigoCIIU' => $clienteverificado[0]['CodigoCIIU'],
                    'RazonSocial' => $clienteverificado[0]['RazonSocial'],
                    'Establecimiento' => $clienteverificado[0]['Establecimiento'],
                    'PrimerNombre' => $clienteverificado[0]['PrimerNombre'],
                    'SegundoNombre' => $clienteverificado[0]['SegundoNombre'],
                    'PrimerApellido' => $clienteverificado[0]['PrimerApellido'],
                    'SegundoApellido' => $clienteverificado[0]['SegundoApellido'],
                    'NumeroIdentificacion' => $clienteverificado[0]['NumeroIdentificacion'],
                    'DigitoVerificacion' => $clienteverificado[0]['DigitoVerificacion'],
                    'TipoNegocio' => $clienteverificado[0]['TipoNegocio'],
                    'FacturaEntregaEspera' => $clienteverificado[0]['FacturaEntregaEspera'],
                    'Ciudad' => $clienteverificado[0]['Ciudad'],
                    'Barrio' => $clienteverificado[0]['Barrio'],
                    'Calle' => $clienteverificado[0]['Calle'],
                    'Telefono' => $clienteverificado[0]['Telefono'],
                    'Telefono2' => $clienteverificado[0]['Telefono2'],
                    'CorreoElectronico' => $clienteverificado[0]['CorreoElectronico'],
                    'CarteraVencida' => $clienteverificado[0]['CarteraVencida'],
                    'FechaRegistro' => $clienteverificado[0]['FechaRegistro'],
                    'HoraRegistro' => $clienteverificado[0]['HoraRegistro'],
                    'ZonasVentas' => $datosDos,
                    'GrupoVentasIguales' => $GrupoVentasIguales,
                    'Origen' => $clienteverificado[0]['Origen']
                );

                array_push($datos, $arrayclientenoexistente);
                $session['clientenoexistente'] = $datos;


                $this->render('formularios/formClienteNoExistente', array(
                    'arrayclientenoexistente' => $datos,
                    'ciudades' => $ciudades,
                    'vias' => $tipovia,
                    'tipoviacomplemento' => $tipoviacomplemento
                ));
            } elseif ($clienteverificado[0]['Origen'] == 'AX') {

                $arrayclienteexistente = array(
                    'Identificador' => $clienteverificado[0]['Identificador'],
                    'CodigoTipoDocumento' => $clienteverificado[0]['CodigoTipoDocumento'],
                    'Estado' => $estado,
                    'CuentaCliente' => $clienteverificado[0]['CuentaCliente'],
                    'TipoDocumento' => $clienteverificado[0]['TipoDocumento'],
                    'TipoRegistro' => $clienteverificado[0]['TipoRegistro'],
                    'CodigoCIIU' => $clienteverificado[0]['CodigoCIIU'],
                    'RazonSocial' => $clienteverificado[0]['RazonSocial'],
                    'Establecimiento' => $clienteverificado[0]['Establecimiento'],
                    'PrimerNombre' => $clienteverificado[0]['PrimerNombre'],
                    'SegundoNombre' => $clienteverificado[0]['SegundoNombre'],
                    'PrimerApellido' => $clienteverificado[0]['PrimerApellido'],
                    'SegundoApellido' => $clienteverificado[0]['SegundoApellido'],
                    'NumeroIdentificacion' => $clienteverificado[0]['NumeroIdentificacion'],
                    'DigitoVerificacion' => $clienteverificado[0]['DigitoVerificacion'],
                    'TipoNegocio' => $clienteverificado[0]['TipoNegocio'],
                    'FacturaEntregaEspera' => $clienteverificado[0]['FacturaEntregaEspera'],
                    'Ciudad' => $clienteverificado[0]['Ciudad'],
                    'Barrio' => $clienteverificado[0]['Barrio'],
                    'Calle' => $clienteverificado[0]['Calle'],
                    'Telefono' => $clienteverificado[0]['Telefono'],
                    'Telefono2' => $clienteverificado[0]['Telefono2'],
                    'TelefonoMovil' => $clienteverificado[0]['TelefonoMovil'],
                    'CorreoElectronico' => $clienteverificado[0]['CorreoElectronico'],
                    'CarteraVencida' => $clienteverificado[0]['CarteraVencida'],
                    'FechaRegistro' => $clienteverificado[0]['FechaRegistro'],
                    'HoraRegistro' => $clienteverificado[0]['HoraRegistro'],
                    'ZonasVentas' => $datosDos,
                    'GrupoVentasIguales' => $GrupoVentasIguales,
                    'Origen' => $clienteverificado[0]['Origen'],
                    'Status' => $clienteverificado[0]['Status']
                );

                /* echo 'entre aca';
                  echo '<pre>';
                  print_r($arrayclienteexistente);
                  exit(); */

                array_push($datos, $arrayclienteexistente);
                $session['clienteexistente'] = $datos;
                $this->render('formularios/formClienteExistente', array(
                    'arrayclienteexistente' => $datos,
                    'ciudades' => $ciudades,
                    'vias' => $tipovia,
                    'tipoviacomplemento' => $tipoviacomplemento
                ));
            }
        }
    }

    public function actionCargarPreguntaNueva() {

        sleep(2);

        $pregunta = $_POST['pregunta'];
        $respuesta = $_POST['respuesta'];
        $siguientePregunta = $_POST['siguientePregunta'];

        $session = new CHttpSession;
        $session->open();

        $encuesta = array(
            'pregunta' => $pregunta,
            'respuesta' => $respuesta,
            'siguientePregunta' => $siguientePregunta
        );

        if (count($session['encuesta']) == 0) {
            $totalEncuesta = array();
            array_push($totalEncuesta, $encuesta);
            $session['encuesta'] = $totalEncuesta;
        } else {
            $totalEncuesta = $session['encuesta'];
            array_push($totalEncuesta, $encuesta);
            $session['encuesta'] = $totalEncuesta;
        }

        if ($siguientePregunta == 0) {
            echo "0";
        } else {
            echo $this->renderPartial('formularios/_cargarNuevaPregunta', array('siguientePregunta' => $siguientePregunta), true);
        }
    }

    public function actionGetEncuesta() {

        $session = new CHttpSession;
        $session->open();
        foreach ($session['encuesta'] as $itemSession) {
            $idRespuesta = $itemSession['respuesta'];
        }

        //$codigoSegmentacion = Consultas::model()->getSegmentacionIdRespuesta($idRespuesta);

        echo '<div class="alert alert-success">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">x—</button>
                        <strong>Encuesta completa.!</strong>
                      </div>';

        /* echo '<table class="table table-hover">';
          echo '<tr>';
          echo '<td>Segmento</td>';
          echo '<td>SubSegmento</td>';
          echo '<td>Tipo de negocio</td>';
          echo '</tr>';
          echo '<tr>';
          echo '<td>'.$codigoSegmentacion['NomSegmento'].'</td>';
          echo '<td>'.$codigoSegmentacion['NomCanal'].'</td>';
          echo '<td>'.$codigoSegmentacion['NomTipoNegocio'].'</td>';
          echo '</tr>';
          echo '</table>'; */

        echo '<div class="row">
			                  <div class="col-sm-9 col-sm-offset-3 text-center">                    
			                    
			                    <input type="button" id="cargar-formulario-registrar" class="btn btn-primary" value="Formulario registrar" /> 
			                    <input type="button" id="cargar-formulario-enrutar" class="btn btn-primary" value="Enrutar cliente" />  
			                               
			                  </div>
			                </div>';
    }

    public function actionFormularioClienteExisteVerificado($identificador, $CuentaCliente = '', $Identificacion = '') {

        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/clienteNuevo/clienteverificado.js', CClientScript::POS_END
        );

        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/funciones.js', CClientScript::POS_END
        );

        Yii::import('application.extensions.libreria_digito_verificacion');


        if ($_POST['IddentificadorForm'] == 1) {


            if ($_POST['clienteNuevo']) {


                $TipoDocumento = $_POST['clienteNuevo']['tipoIdentificacion'];


                $session = new CHttpSession;
                $session->open();
                $codagencia = Yii::app()->user->_Agencia;
                $codAsesor = Yii::app()->user->_cedula;
                $consultaZona = Consultas::model()->getZonaAsesor($codAsesor);
                $zonaAsesor = $consultaZona['CodZonaVentas'];
                $posicion = $_POST['hour'] . ':' . $_POST['minute'] . ':00';
                $identificador = $_POST['clienteNuevo']['nitCedula'];
                $canal = $session['canalEmpleado'];

                if ($TipoDocumento == '001') {
                    $dgv = libreria_digito_verificacion::calcular_digito($identificador);

                    if ($_POST['clienteNuevo']['otrobarrio'] == '') {

                        $OtroBarrio = '0';
                    } else {

                        $OtroBarrio = $_POST['clienteNuevo']['otrobarrio'];
                    }

                    if ($_POST['clienteNuevo']['telefono'] == '') {

                        $telefono = '0';
                    } else {

                        $telefono = $_POST['clienteNuevo']['telefono'];
                    }


                    if ($session['Responsable'] == '') {

                        $responsable = '';
                    } else {

                        $responsable = $session['Responsable'];
                    }

                    $respuesta = $_POST['clienteNuevo']['respuesta'];

                    $codigoSegmentacion = Consultas::model()->getSegmentacionIdRespuesta($respuesta);


                    $clienteNuevo = array(
                        'CodZonaVentas' => $zonaAsesor,
                        'CodAsesor' => $codAsesor,
                        'CuentaCliente' => $_POST['clienteNuevo']['cuentacliente'],
                        'Identificacion' => $_POST['clienteNuevo']['nitCedula'],
                        'DigitoVerificacion' => $dgv,
                        'CodTipoDocumento' => $_POST['clienteNuevo']['tipoIdentificacion'],
                        'Nombre' => '',
                        'RazonSocial' => $_POST['clienteNuevo']['nombreRazonSocial'],
                        'Establecimiento' => $_POST['clienteNuevo']['establecimiento'],
                        'CodigoCiuu' => $_POST['clienteNuevo']['codigoCiuu'],
                        'PrimerNombre' => '',
                        'SegundoNombre' => '',
                        'PrimerApellido' => '',
                        'SegundoApellido' => '',
                        'Direccion' => $_POST['clienteNuevo']['direccion'],
                        'CodBarrio' => $_POST['clienteNuevo']['barrios'],
                        'Telefono' => $telefono,
                        'TelefonoMovil' => $_POST['clienteNuevo']['telefonoMovil'],
                        'Email' => $_POST['clienteNuevo']['correo'],
                        //'CodCadenadeEmpresa' => $codigoSegmentacion['IdCodigoSegmentacion'],
                        'NumeroVisita' => $_POST['clienteNuevo']['numeroVisita'],
                        'OtroBarrio' => $OtroBarrio,
                        'Posicion' => $posicion,
                        'Latitud' => '',
                        'Longitud' => '',
                        'ZonaLogistica' => '',
                        'CodigoPostal' => '',
                        'DireccionEstandar' => '',
                        'FechaRegistro' => date('Y-m-d'),
                        'HoraRegistro' => date('H:i:s'),
                        'Estado' => '0',
                        'Generado' => '0',
                        'Enviado' => '0',
                        'ArchivoXml' => '',
                        'IdentificadorEnvio' => '1',
                        'CodigoCanal' => $canal,
                        'Responsable' => $responsable
                    );

                    if ($_POST['respuesta'] !== '') {

                        $respuesta = $_POST['clienteNuevo']['respuesta'];
                        $codigoSegmentacion = Consultas::model()->getSegmentacionIdRespuesta($respuesta);
                        $clienteNuevo['CodCadenadeEmpresa'] = $codigoSegmentacion['IdCodigoSegmentacion'];
                    }
                    $model = new Clientenuevo;
                    $model->attributes = $clienteNuevo;


                    if (!$model->validate()) {
                        print_r($model->getErrors());
                    } else {
                        $model->save();

                        $codtipodoc = '9';
                        $estado = '0';

                        $TransferAx = array(
                            'CodTipoDocumentoActivity' => $codtipodoc,
                            'IdDocumento' => $model->Id,
                            'CodigoAgencia' => $codagencia,
                            'EstadoTransaccion' => $estado
                        );


                        $modeltransax = new Transaccionesax;
                        $modeltransax->attributes = $TransferAx;

                        if (!$modeltransax->validate()) {

                            print_r($modeltransax->getErrors());
                        } else {

                            $modeltransax->save();
                        }

                        Yii::app()->user->setFlash('success', "Datos guardados satisfactoriamente, recuerde esperar unos minutos antes de realizar la consulta del cliente. Se sugiere realizar la busqueda por el nombre");
                        $this->redirect('index.php?r=Clientes/ClientesRutas');
                    }
                } else {

                    $Nombre = $_POST['clienteNuevo']['primerNombre'] . '-' . $_POST['clienteNuevo']['primerApellido'];
                    if ($_POST['clienteNuevo']['otrobarrio'] == '') {

                        $OtroBarrio = '0';
                    } else {

                        $OtroBarrio = $_POST['clienteNuevo']['otrobarrio'];
                    }

                    if ($_POST['clienteNuevo']['telefono'] == '') {

                        $telefono = '0';
                    } else {

                        $telefono = $_POST['clienteNuevo']['telefono'];
                    }


                    if ($session['Responsable'] == '') {

                        $responsable = '';
                    } else {

                        $responsable = $session['Responsable'];
                    }

                    $respuesta = $_POST['clienteNuevo']['respuesta'];

                    $codigoSegmentacion = Consultas::model()->getSegmentacionIdRespuesta($respuesta);

                    $clienteNuevo = array(
                        'CodZonaVentas' => $zonaAsesor,
                        'CodAsesor' => $codAsesor,
                        'CuentaCliente' => $_POST['clienteNuevo']['cuentacliente'],
                        'Identificacion' => $_POST['clienteNuevo']['nitCedula'],
                        'DigitoVerificacion' => $dgv,
                        'CodTipoDocumento' => $_POST['clienteNuevo']['tipoIdentificacion'],
                        'Nombre' => $Nombre,
                        'RazonSocial' => '',
                        'Establecimiento' => $_POST['clienteNuevo']['establecimiento'],
                        'CodigoCiuu' => $_POST['clienteNuevo']['codigoCiuu'],
                        'PrimerNombre' => $_POST['clienteNuevo']['primerNombre'],
                        'SegundoNombre' => $_POST['clienteNuevo']['segundoNombre'],
                        'PrimerApellido' => $_POST['clienteNuevo']['primerApellido'],
                        'SegundoApellido' => $_POST['clienteNuevo']['segundoApellido'],
                        'Direccion' => $_POST['clienteNuevo']['direccion'],
                        'CodBarrio' => $_POST['clienteNuevo']['barrios'],
                        'Telefono' => $telefono,
                        'TelefonoMovil' => $_POST['clienteNuevo']['telefonoMovil'],
                        'Email' => $_POST['clienteNuevo']['correo'],
                        //'CodCadenadeEmpresa' => $codigoSegmentacion['IdCodigoSegmentacion'],
                        'NumeroVisita' => $_POST['clienteNuevo']['numeroVisita'],
                        'OtroBarrio' => $OtroBarrio,
                        'Posicion' => $posicion,
                        'Latitud' => '',
                        'Longitud' => '',
                        'ZonaLogistica' => '',
                        'CodigoPostal' => '',
                        'DireccionEstandar' => '',
                        'FechaRegistro' => date('Y-m-d'),
                        'HoraRegistro' => date('H:i:s'),
                        'Estado' => '0',
                        'Generado' => '0',
                        'Enviado' => '0',
                        'ArchivoXml' => '',
                        'IdentificadorEnvio' => '1',
                        'CodigoCanal' => $canal,
                        'Responsable' => $responsable
                    );
                    if ($_POST['respuesta'] !== '') {

                        $respuesta = $_POST['clienteNuevo']['respuesta'];
                        $codigoSegmentacion = Consultas::model()->getSegmentacionIdRespuesta($respuesta);
                        $clienteNuevo['CodCadenadeEmpresa'] = $codigoSegmentacion['IdCodigoSegmentacion'];
                    }

                    $model = new Clientenuevo;
                    $model->attributes = $clienteNuevo;

                    if (!$model->validate()) {
                        print_r($model->getErrors());
                    } else {
                        $model->save();


                        $codtipodoc = '9';
                        $estado = '0';

                        $TransferAx = array(
                            'CodTipoDocumentoActivity' => $codtipodoc,
                            'IdDocumento' => $model->Id,
                            'CodigoAgencia' => $codagencia,
                            'EstadoTransaccion' => $estado
                        );


                        $modeltransax = new Transaccionesax;
                        $modeltransax->attributes = $TransferAx;

                        if (!$modeltransax->validate()) {

                            print_r($modeltransax->getErrors());
                        } else {

                            $modeltransax->save();
                        }

                        Yii::app()->user->setFlash('success', "Datos guardados satisfactoriamente, recuerde esperar unos minutos antes de realizar la consulta del cliente. Se sugiere realizar la busqueda por el nombre");

                        $this->redirect('index.php?r=Clientes/ClientesRutas');
                    }
                }
            }
        } else {


            if ($Identificacion != "" && $CuentaCliente != "") {

                $clienteverificado = Clientenuevo::model()->getDatosClientes($Identificacion, $CuentaCliente);

                $DatosClienteExistente = array();
                $arrayclienteexistente = array(
                    'Identificador' => $clienteverificado[0]['Identificador'],
                    'CodigoTipoDocumento' => $clienteverificado[0]['CodigoTipoDocumento'],
                    'Estado' => $estado,
                    'CuentaCliente' => $clienteverificado[0]['CuentaCliente'],
                    'TipoDocumento' => $clienteverificado[0]['TipoDocumento'],
                    'TipoRegistro' => $clienteverificado[0]['TipoRegistro'],
                    'CodigoCIIU' => $clienteverificado[0]['CodigoCIIU'],
                    'RazonSocial' => $clienteverificado[0]['RazonSocial'],
                    'Establecimiento' => $clienteverificado[0]['Establecimiento'],
                    'PrimerNombre' => $clienteverificado[0]['PrimerNombre'],
                    'SegundoNombre' => $clienteverificado[0]['SegundoNombre'],
                    'PrimerApellido' => $clienteverificado[0]['PrimerApellido'],
                    'SegundoApellido' => $clienteverificado[0]['SegundoApellido'],
                    'NumeroIdentificacion' => $clienteverificado[0]['NumeroIdentificacion'],
                    'DigitoVerificacion' => $clienteverificado[0]['DigitoVerificacion'],
                    'TipoNegocio' => $clienteverificado[0]['TipoNegocio'],
                    'FacturaEntregaEspera' => $clienteverificado[0]['FacturaEntregaEspera'],
                    'Ciudad' => $clienteverificado[0]['Ciudad'],
                    'Barrio' => $clienteverificado[0]['Barrio'],
                    'Calle' => $clienteverificado[0]['Calle'],
                    'Telefono' => $clienteverificado[0]['Telefono'],
                    'Telefono2' => $clienteverificado[0]['Telefono2'],
                    'TelefonoMovil' => $clienteverificado[0]['TelefonoMovil'],
                    'CorreoElectronico' => $clienteverificado[0]['CorreoElectronico'],
                    'CarteraVencida' => $clienteverificado[0]['CarteraVencida'],
                    'FechaRegistro' => $clienteverificado[0]['FechaRegistro'],
                    'HoraRegistro' => $clienteverificado[0]['HoraRegistro'],
                    'Origen' => $clienteverificado[0]['Origen']
                );

                array_push($DatosClienteExistente, $arrayclienteexistente);
                $session['clienteexistente'] = $DatosClienteExistente;

                $ciudades = ModelClientesNuevos::model()->getBuscarCiudades();
                $tipovia = ModelClientesNuevos::model()->getTipovia();
                $tipoviacomplemento = ModelClientesNuevos::model()->getTipoViaComplemento();

                $this->render('formularios/formClienteExitentesVerificados', array(
                    'identificador' => $identificador,
                    'ciudades' => $ciudades,
                    'vias' => $tipovia,
                    'tipoviacomplemento' => $tipoviacomplemento
                ));
            } else {



                $ciudades = ModelClientesNuevos::model()->getBuscarCiudades();
                $tipovia = ModelClientesNuevos::model()->getTipovia();
                $tipoviacomplemento = ModelClientesNuevos::model()->getTipoViaComplemento();

                $this->render('formularios/formClienteExitentesVerificados', array(
                    'identificador' => $identificador,
                    'ciudades' => $ciudades,
                    'vias' => $tipovia,
                    'tipoviacomplemento' => $tipoviacomplemento
                ));
            }
        }
    }

    public function actionAjaxDepartamento() {

        if ($_POST) {

            $codciudad = $_POST['codciudad'];
            $coddepartamento = $_POST['coddepartamento'];

            $select = "";

            $departamentos = ModelClientesNuevos::model()->getDepartamento($codciudad, $coddepartamento);
            $select.='<select class="chosen-select" id="Departamento" name="clienteNuevo[departamentos]" style="width:  327px;" readonly="true">
                                          ';
            foreach ($departamentos as $itemdepartamento) {

                $select.='
                
                      <option data-departamento="' . $itemdepartamento['CodigoDepartamento'] . '"  data-ciudad="' . $itemdepartamento['CodigoCiudad'] . '">' . $itemdepartamento['NombreDepartamento'] . '</option>  
                        
                        ';
            }

            $select.='</select>';

            echo $select;
        }
    }

    public function actionAjaxBarrios() {

        if ($_POST) {

            $coddepartamento = $_POST['departamento'];
            $codciudad = $_POST['ciudad'];
            $codbarrio = $_POST['codbarrio'];


            $select = "";

            $barrios = ModelClientesNuevos::model()->getBarrios($coddepartamento, $codciudad);
            $select.='<select class="chosen-select Barrios98" id="BarriosSelect" name="clienteNuevo[barrios]" style="width:  327px;">
                      <option value="">Seleccione</option>
                      <option value="0">Otro Barrio</option>
                ';
            foreach ($barrios as $itemBarrio) {

                if ($codbarrio == $itemBarrio['CodigoBarrio']) {

                    $select.='
                
                      <option   value="' . $itemBarrio['CodigoBarrio'] . '" selected>' . $itemBarrio['NombreBarrio'] . '</option>  
                         
                        ';
                } else {

                    $select.='
                
                      <option  value="' . $itemBarrio['CodigoBarrio'] . '">' . $itemBarrio['NombreBarrio'] . '</option>  
                        
                        ';
                }
            }

            $select.='</select>';

            echo $select;
        }
    }

    public function actionAjaxOtroBarrioBarrios() {

        if ($_POST) {

            $coddepartamento = $_POST['departamento'];
            $codciudad = $_POST['ciudad'];

            $otrosBarrios = ModelClientesNuevos::model()->getOtrosBarrio($codciudad, $coddepartamento);

            $inpuOtroBarrio.='';

            $inpuOtroBarrio.='<input type="text" class="form-control"  value="' . $otrosBarrios['NombreBarrio'] . '" readonly="true">';
            $inpuOtroBarrio.='<input type="hidden" class="form-control" id="OtroBarrio" name="clienteNuevo[otrobarrio]" value="' . $otrosBarrios['CodigoBarrio'] . '">';


            echo $inpuOtroBarrio;
        }
    }

    public function actionCalculaRuta() {

        $session = new CHttpSession;
        $session->open();
        $clienteSeleccionado = $session['clienteSeleccionado'];

        if ($_POST) {

            $diaRuta = $clienteSeleccionado['diaRuta'];
            $frecuanecia = $_POST['frecuencia'];

            $Ruta = Clientenuevo::model()->getVisita($frecuanecia, $diaRuta);

            echo json_encode($Ruta);
        }
    }

    public function actionAjaxDatosClientes() {


        if ($_POST) {

            $idtenficacion = $_POST['iddentificacion'];
            $cuentacliente = $_POST['cuentacliente'];

            $DatosCliente = Clientenuevo::model()->getDatosClientes($idtenficacion, $cuentacliente);


            foreach ($DatosCliente as $itemdatos) {

                $NombreCiuu = Clientenuevo::model()->getCodCiiu($itemdatos['CodigoCIIU']);
                $Localizacion = Clientenuevo::model()->getLocalizacion($itemdatos['Barrio']);


                $estado = 0;
                if (($itemdatos['FacturaEntregaEspera'] == "No") || ($itemdatos['FacturaEntregaEspera'] == "no") || ($itemdatos['FacturaEntregaEspera'] == "NO" || $itemdatos['FacturaEntregaEspera'] == "Pedido")) {
                    $estado = 1;
                } else {
                    $estado = 0;
                }

                $json = array(
                    'Identificador' => $itemdatos['Identificador'],
                    'CodigoTipoDocumento' => $itemdatos['CodigoTipoDocumento'],
                    'CuentaCliente' => $itemdatos['CuentaCliente'],
                    'TipoDocumento' => $itemdatos['TipoDocumento'],
                    'CodigoCIIU' => $itemdatos['CodigoCIIU'],
                    'RazonSocial' => $itemdatos['RazonSocial'],
                    'PrimerNombre' => $itemdatos['PrimerNombre'],
                    'SegundoNombre' => $itemdatos['SegundoNombre'],
                    'PrimerApellido' => $itemdatos['PrimerApellido'],
                    'SegundoApellido' => $itemdatos['SegundoApellido'],
                    'Establecimiento' => $itemdatos['Establecimiento'],
                    'DigitoVerificacion' => $itemdatos['DigitoVerificacion'],
                    'TipoNegocio' => $itemdatos['TipoNegocio'],
                    'FacturaEntregaEspera' => $itemdatos['FacturaEntregaEspera'],
                    'Ciudad' => $itemdatos['Ciudad'],
                    'Barrio' => $itemdatos['Barrio'],
                    'Calle' => $itemdatos['Calle'],
                    'Telefono' => $itemdatos['Telefono'],
                    'TelefonoMovil' => $itemdatos['TelefonoMovil'],
                    'CorreoElectronico' => $itemdatos['CorreoElectronico'],
                    'Origen' => $itemdatos['Origen'],
                    'NombreCiuu' => $NombreCiuu[0]['NombreCIIU'],
                    'CodigoCiudad' => $Localizacion[0]['CodigoCiudad'],
                    'CodigoDepartamento' => $Localizacion[0]['CodigoDepartamento'],
                    'NombreDepartamento' => $Localizacion[0]['NombreDepartamento'],
                    'NombreBarrio' => $Localizacion[0]['NombreBarrio'],
                    'Estado' => $estado
                );
            }


            echo json_encode($json);
        }
    }

    public function actionAjaxZonaClientes() {

        $CuentaCliente = $_POST['cuentacliente'];

        $zonaventascleinteverificado = Clientenuevo::model()->getZovantasVerificadas($CuentaCliente);

        $datosDos = array();
        $vistaZonasAtendidas = "";
        foreach ($zonaventascleinteverificado as $zona) {

            if ($zona['CodigoGrupoVentas'] != "" && $zona['CodigoZonaVentas'] != "") {
                $vistaZonasAtendidas = $vistaZonasAtendidas . ' <div class="row">
                <div class="col-sm-5">  
                    <label class="text-center"><font color="#0033CC"><b>Grupo Ventas:</b></font></label>
                </div>
                <div class="col-sm-4">
                    <label>' . $zona['CodigoGrupoVentas'] . '</label>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-5">  
                    <label><font color="#0033CC"><b>Nombre Grupo Ventas:</b></font></label>
                </div>
                <div class="col-sm-4">
                    <label>' . $zona['NombreGrupoVentas'] . '</label>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-5">  
                    <label><font color="#0033CC"><b>Código Zona Ventas:</b></font></label>
                </div>
                <div class="col-sm-4">
                    <label>' . $zona['CodigoZonaVentas'] . '</label>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-5">  
                    <label><font color="#0033CC"><b>Nombre Zona Ventas:</b></font></label>
                </div>
                <div class="col-sm-7">
                    <label>' . $zona['NombreAsesorComercial'] . '</label>
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
            </div>';
            }
        }
        echo $vistaZonasAtendidas;
        $session = new CHttpSession;
        $session->open();
        $session['DatosZona'] = $datosDos;
    }

    public function actionAjaxZonaClientesCedula() {

        $CuentaCliente = $_POST['cuentacliente'];

        $zonaventascleinteverificado = Clientenuevo::model()->getZovantasVerificadas($CuentaCliente);
        $vistaZonasAtendidas = "";
        $datosDosCedulas = array();
        foreach ($zonaventascleinteverificado as $zona) {

            if ($zona['CodigoGrupoVentas'] != "" && $zona['CodigoZonaVentas'] != "") {
                $vistaZonasAtendidas = $vistaZonasAtendidas . '<div class="row">
                <div class="col-sm-5">
                    <label class="text-center"><font color="#0033CC"><b>Grupo Ventas:</b></font></label>
                </div>
                <div class="col-sm-4">
                    <label>' . $zona['CodigoGrupoVentas'] . '</label>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-5">
                    <label><font color="#0033CC"><b>Nombre Grupo Ventas:</b></font></label>
                </div>
                <div class="col-sm-4">
                    <label>' . $zona['NombreGrupoVentas'] . '</label>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-5">
                    <label><font color="#0033CC"><b>Código Zona Ventas:</b></font></label>
                </div>
                <div class="col-sm-4">
                    <label>' . $zona['CodigoZonaVentas'] . '</label>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-5">
                    <label><font color="#0033CC"><b>Nombre Zona Ventas:</b></font></label>
                </div>
                <div class="col-sm-7">
                    <label>' . $zona['NombreZonaVentas'] . '</label>
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
            </div>';
            }
        }
        echo $vistaZonasAtendidas;
        $session = new CHttpSession;
        $session->open();
        $session['DatosZonasCedulas'] = $datosDosCedulas;
    }

}
