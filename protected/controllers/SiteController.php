<?php

class SiteController extends Controller {

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        $session = new CHttpSession;
        $session->open();
        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/site/login.js', CClientScript::POS_END
        );
        $this->layout = 'login';
        $model = new LoginForm;
        // if it is ajax validation request
        /* if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
          {
          echo CActiveForm::validate($model);
          Yii::app()->end();
          } */
        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $ValidarPermisosWeb = Consultas::model()->getValidarPermisosWeb($_POST['LoginForm']['username']);
            $ValidarPermisosWebZonaNoExistentes = Consultas::model()->getPermisosWebZonaNoExitentes($_POST['LoginForm']['username']);
            $Administradores = Consultas::model()->getAdministradores($_POST['LoginForm']['username']);
            if ($_POST['LoginForm']['username'] != $Administradores['Usuario']) {
                if ($ValidarPermisosWeb['FechaFinal'] != "" && $ValidarPermisosWeb['FechaInicial'] != "" || $ValidarPermisosWebZonaNoExistentes['zonaventa'] == 0) {
                    $fechaActual = date('Y-m-d');
                    if ($fechaActual > $ValidarPermisosWeb['FechaFinal'] || $ValidarPermisosWebZonaNoExistentes['zonaventa'] == 0) {
                        Yii::app()->user->logout();
                        Yii::app()->user->setFlash('webnodisponible', "1");
                        $this->render('login', array('model' => $model));
                    } else {
                        $model->attributes = $_POST['LoginForm'];
                        // validate user input and redirect to the previous page if valid
                        if ($model->validate() && $model->login()) {
                            if (Yii::app()->user->_idPerfil == 3) {
                                $validarIdentificacion = Consultas::model()->getValidarIdentificacion(Yii::app()->user->_cedula);
                                if ($validarIdentificacion) {
                                    $session['canalEmpleado'] = $validarIdentificacion['CodigoCanal'];
                                } else {
                                    //$model=array();
                                    Yii::app()->user->logout();
                                    $this->render('login', array('model' => $model));
                                    exit();
                                }
                            }
                            if (isset(Yii::app()->user->_FechaRetiro)) {
                                echo Yii::app()->user->_cedula;
                                if (Yii::app()->user->_FechaRetiro > "0000-00-00") {
                                    Yii::app()->user->setFlash('formResponsable', "1");
                                    $this->render('login', array('model' => $model));
                                } else {
                                    $this->redirect(array('site/inicio'));
                                }
                            } else {
                                $this->redirect(array('site/inicio'));
                            }
                        } else {
                            $this->render('login', array('model' => $model));
                        }
                    }
                }
            } else {
                $model->attributes = $_POST['LoginForm'];
                // validate user input and redirect to the previous page if valid
                if ($model->validate() && $model->login()) {
                    if (Yii::app()->user->_idPerfil == 3) {
                        $validarIdentificacion = Consultas::model()->getValidarIdentificacion(Yii::app()->user->_cedula);
                        if ($validarIdentificacion) {
                            $session['canalEmpleado'] = $validarIdentificacion['CodigoCanal'];
                        } else {
                            //$model=array();
                            Yii::app()->user->logout();
                            $this->render('login', array('model' => $model));
                            exit();
                        }
                    }
                    if (isset(Yii::app()->user->_FechaRetiro)) {
                        echo Yii::app()->user->_cedula;
                        if (Yii::app()->user->_FechaRetiro > "0000-00-00") {
                            Yii::app()->user->setFlash('formResponsable', "1");
                            $this->render('login', array('model' => $model));
                        } else {
                            $this->redirect(array('site/inicio'));
                        }
                    } else {
                        $this->redirect(array('site/inicio'));
                    }
                } else {
                    $this->render('login', array('model' => $model));
                }
            }
        } else {
            Yii::app()->user->logout();
            $this->render('login', array('model' => $model));
        }
    }

    public function actionInicio() {
        $this->render('index');
        $cedula = Yii::app()->getUser()->getState('_cedula');
        $zonaventas = Yii::app()->getUser()->getState('_zonaVentas');
        $ZonaVentas = $zonaventas != "" ? $ZonaVentas = $zonaventas : $ZonaVentas = $cedula;
        $Fecha = date('Y-m-d');
        $Hora = date('H:i:s');
        $insertIntoLogIngreso = Consultas::model()->InsertLogIngreso($ZonaVentas, $Fecha, $Hora);
    }

    /*
     * se crea la funcion para el modulo de control version
     */

    public function actionControlVersion() {
        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/site/controlversion.js', CClientScript::POS_END
        );
        $this->render('control');
    }

    /*
     * se crea la funcion para mostrar los registros de actualizacion de version
     * @return JSON 
     */

    public function actionAjaxActualizarVersion() {
        $report = array();
        $ControlVersion = Consultas::model()->getAsesoresComercial();
        foreach ($ControlVersion as $imtemControlVersion) {
            $Check = '<input type="checkbox" class="chckVersion" value="' . $imtemControlVersion['CodAsesor'] . '">';
            $agencia = Consultas::model()->getAgencias($imtemControlVersion['Agencia']);
            $json = array(
                'CodZonaVentas' => $imtemControlVersion['CodZonaVentas'],
                'Cedula' => $imtemControlVersion['Cedula'],
                'Nombre' => $imtemControlVersion['Nombre'],
                'Clave' => $imtemControlVersion['Clave'],
                'Version' => $imtemControlVersion['Version'],
                'NuevaVersion' => $imtemControlVersion['NuevaVersion'],
                'Agencia' => $agencia['Nombre'],
                'Actualizar' => $Check
            );
            array_push($report, $json);
        }
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($report),
            "iTotalDisplayRecords" => count($report),
            "aaData" => $report);
        echo json_encode($results);
    }

    /*
     * se crea la funcion de actualizacion de version
     * @parameters
     * @_POST  (Array) Versiones 
     */

    public function actionAjaxActulizarVersion() {
        if ($_POST) {
            $version = $_POST['version'];
            $UltimaVersion = Consultas::model()->getUltimaVersion();
            foreach ($version as $asesores) {
                $updateVersion = Consultas::model()->getUpdateVersion($asesores, $UltimaVersion['version']);
            }
        }
    }

    /*
     * se crea la funcion para la vista de permisos web 
     */

    public function actionPermisosPaginWeb() {
        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/site/permisospaginaweb.js', CClientScript::POS_END
        );
        $Agencias = Consultas::model()->getAgenciasPaginaWeb();
        $this->render('permisospaginaweb', array('Agencias' => $Agencias));
    }

    /*
     * se crea la funcion para cargar la zona de ventas que se encuentan en la agencia selecionada
     * @parameters
     * @_POST  codigo agencia
     */

    public function actionAjaxZonaVentasAgencia() {
        if ($_POST) {
            $CodAgencia = $_POST['agencia'];
            $option = "";
            $option.=' <select id="selectchosezonaventas2" name="ZoanVentas" class="form-control chosen-select" data-placeholder="Seleccione un zona ventas"> <option value=""></option>';
            $zonaVentas = Consultas::model()->getZonaVentasxAgencia($CodAgencia);
            foreach ($zonaVentas as $itemZonaVentas) {
                $option.='<option  value="' . $itemZonaVentas['CodZonaVentas'] . '">' . $itemZonaVentas['CodZonaVentas'] . '-' . $itemZonaVentas['NombreZonadeVentas'] . '</option>';
            }
            $option.='</select>';
            echo $option;
        }
    }

    /*
     * se crea la funcion para guardar  la configuracion de permisos
     * @parameters
     * @_POST agencia
     * @_POST zona ventas
     * @_POST fecha inicial
     * @_POST fecha final
     * @_POST observacion
     */

    public function actionAjaxGuardarConfiguracion() {
        if ($_POST) {
            $agencia = $_POST['agencia'];
            $zona = $_POST['CodZonaVentas'];
            $fechaini = $_POST['fechaini'];
            $fechafin = $_POST['fechafin'];
            $observacion = $_POST['Observacion'];
            Consultas::model()->InsertPermisoPaginaWeb($agencia, $zona, $fechaini, $fechafin, $observacion);
        }
    }

    /*
     * se crea la funcion para cargar la fechas anterior de la zona de ventas
     * @parameters
     * @_POST zonaventas
     */

    public function actionAjaxCargarFecha() {
        if ($_POST) {
            $zona = $_POST['zona'];
            $Fechas = Consultas::model()->getValidarPermisosWeb($zona);
            $FechasAnterior = array(
                'FechaInicial' => $Fechas['FechaInicial'],
                'FechaFinal' => $Fechas['FechaFinal']
            );
            echo json_encode($FechasAnterior);
        }
    }

    /*
     * se crea la funcion para cargar la tabla de versiones
     */

    public function actionAjaxTablaVersiones() {
        $this->renderPartial('_TablaVersiones');
    }

    /*
     * se crea la funcion para cargar  la informacion de versiones
     */

    public function actionAjaxVersionesAnteriores() {
        $arrayVersiones = array();
        $Versiones = Consultas::model()->getVersiones();
        foreach ($Versiones as $ItemVersiones) {
            $json = array(
                'Fecha' => $ItemVersiones['Fecha'],
                'Hora' => $ItemVersiones['Hora'],
                'Observacion' => $ItemVersiones['Observacion'],
                'Version' => $ItemVersiones['Version'],
            );
            array_push($arrayVersiones, $json);
        }
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($arrayVersiones),
            "iTotalDisplayRecords" => count($arrayVersiones),
            "aaData" => $arrayVersiones);
        echo json_encode($results);
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact() {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" .
                        "Reply-To: {$model->email}\r\n" .
                        "MIME-Version: 1.0\r\n" .
                        "Content-Type: text/plain; charset=UTF-8";
                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Displays the login page
     */
    public function actionLogin() {
        $this->layout = 'login';
        $model = new LoginForm;
        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login())
                $this->redirect(array('site/inicio'));
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(array('/'));
    }

    public function actionAjaxValidarIdentificacion() {
        $session = new CHttpSession;
        $session->open();
        if ($session['Idenficacion']) {
            unset($session['Idenficacion']);
        }
        $txtIdentificacion = $_POST['txtIdentificacion'];
        $validarIdentificacion = Consultas::model()->getValidarIdentificacion($txtIdentificacion);
        if ($validarIdentificacion) {
            $session['Responsable'] = $validarIdentificacion['NumeroIdentidad'];
            $session['CZV'] = $validarIdentificacion['CodigoZonaVentas'];
            echo '1';
        } else {
            echo '0';
        }
    }

    /*
     * ace se realiza la funcion para loguearse desde el link del mensaje del dahsboar
     * 
     */

    public function actionDescuentosLink($agencia, $grupoVentas, $IdPedido, $proveedor, $id, $token) {
        $DatosAdmin = Consultas::model()->getDatosAdministrador($id);
        $usuario = $DatosAdmin['Usuario'];
        $clave = $DatosAdmin['Clave'];
        $toke = $DatosAdmin['Token'];
        if ($toke == $token) {
            $userIdentity = new UserIdentity($usuario, $clave);
            $userIdentity->authenticate();
            if ($userIdentity->errorCode === UserIdentity::ERROR_NONE) {
                Yii::app()->user->login($userIdentity, 0);
            }
            //Consultas::model()->UpdateToken($id);
            $this->redirect(array('reportes/AprovacionDocumentos/AjaxDetalleDescuentos', 'agencia' => $agencia, 'grupoVentas' => $grupoVentas, 'idPedido' => $IdPedido, 'proveedor' => $proveedor));
        }
    }

    public function actionCoordenadaPedido() {
        if (isset($_POST)) {
            $CuentaCliente = $_POST["CuentaCliente"];
            $Longitud = $_POST["Longitud"];
            $Latitud = $_POST["Latitud"];
            $CodZonaVentas = $_POST["CodZonaVentas"];
            $CodAsesor = $_POST["CodAsesor"];
            $pedidoMaquina = $_POST["pedidoMaquina"];
            $agencia = $_POST["agencia"];
            $origenCoordenada = $_POST["origenCoordenada"];
            $query = "SELECT IdPedido FROM `pedidos` WHERE CodZonaVentas='$CodZonaVentas' AND CuentaCliente='$CuentaCliente' AND IdentificadorEnvio='0' AND PedidoMaquina='$pedidoMaquina'";
            $idPedido = Consultas::model()->idpedidocoordenada($agencia, $query);
            $idPedido = $idPedido["IdPedido"];
            $query = "INSERT INTO `coordenadas`(`CuentaCliente`,`IdDocumento`,`Origen`,`Longitud`,`Latitud`,`Fecha`,`Hora`,`CodZonaVentas`,`CodAsesor`) VALUES
            ('$CuentaCliente','$idPedido','1','$Longitud','$Latitud',CURDATE(),CURTIME(),'$CodZonaVentas','$CodAsesor')";
            Consultas::model()->insertCoordenadaPedido($agencia, $query);
            //validamos el pedido para poder hacer el insert y recibimo cual es la agencia
            echo "OK";
        }
    }

    public function actionCoordenadaFactura() {
        if (isset($_POST)) {
            $CuentaCliente = $_POST["CuentaCliente"];
            $Longitud = $_POST["Longitud"];
            $Latitud = $_POST["Latitud"];
            $CodZonaVentas = $_POST["CodZonaVentas"];
            $CodAsesor = $_POST["CodAsesor"];
            $pedidoMaquina = $_POST["pedidoMaquina"];
            $agencia = $_POST["agencia"];
            $origenCoordenada = $_POST["origenCoordenada"];
            $query = "SELECT IdPedido FROM `pedidos` WHERE CodZonaVentas='$CodZonaVentas' AND CuentaCliente='$CuentaCliente' AND IdentificadorEnvio='0' AND PedidoMaquina='$pedidoMaquina'";
            $idPedido = Consultas::model()->idpedidocoordenada($agencia, $query);
            $idPedido = $idPedido["IdPedido"];
            $query = "INSERT INTO `coordenadas`(`CuentaCliente`, `IdDocumento`, `Origen`, `Longitud`, `Latitud`, `Fecha`, `Hora`, `CodZonaVentas`, `CodAsesor`) VALUES
            ('$CuentaCliente','$idPedido','$origenCoordenada','$Longitud','$Latitud',CURDATE(),CURTIME(),'$CodZonaVentas','$CodAsesor')";
            Consultas::model()->insertCoordenadaPedido($agencia, $query);
            //validamos el pedido para poder hacer el insert y recibimo cual es la agencia
            echo "OK";
        }
    }

    public function actionCoordenadaClienteNuevo() {
        if (isset($_POST)) {
            $CuentaCliente = $_POST["CuentaCliente"];
            $Longitud = $_POST["Longitud"];
            $Latitud = $_POST["Latitud"];
            $CodZonaVentas = $_POST["CodZonaVentas"];
            $CodAsesor = $_POST["CodAsesor"];
            $pedidoMaquina = $_POST["pedidoMaquina"];
            $agencia = $_POST["agencia"];
            $origenCoordenada = $_POST["origenCoordenada"];
            $query = "SELECT `Id` FROM `clientenuevo` WHERE `CodZonaVentas`='$CodZonaVentas' AND `Identificacion`='$CuentaCliente' AND `FechaRegistro`=CURDATE() AND `Latitud` IS NULL AND `Longitud` IS NULL ORDER BY Id DESC LIMIT 1;";
            $idClienteNuevo = Consultas::model()->idpedidocoordenada($agencia, $query);
            $idClienteNuevo = $idClienteNuevo["Id"];
            $query = "INSERT INTO `coordenadas`(`CuentaCliente`, `IdDocumento`, `Origen`, `Longitud`, `Latitud`, `Fecha`, `Hora`, `CodZonaVentas`, `CodAsesor`) VALUES
            ('$CuentaCliente','$idClienteNuevo','$origenCoordenada','$Longitud','$Latitud',CURDATE(),CURTIME(),'$CodZonaVentas','$CodAsesor')";
            Consultas::model()->insertCoordenadaPedido($agencia, $query);
            $sqlUpdate = "UPDATE `clientenuevo` SET `Latitud`='$Longitud',`Longitud`='$Latitud' WHERE Id='$idClienteNuevo';";
            Consultas::model()->insertCoordenadaPedido($agencia, $sqlUpdate);
            //validamos el pedido para poder hacer el insert y recibimo cual es la agencia
            echo "OK";
        }
    }

    public function actionCoordenadaNoVenta() {
        if (isset($_POST)) {
            $CuentaCliente = $_POST["CuentaCliente"];
            $Longitud = $_POST["Longitud"];
            $Latitud = $_POST["Latitud"];
            $CodZonaVentas = $_POST["CodZonaVentas"];
            $CodAsesor = $_POST["CodAsesor"];
            $pedidoMaquina = $_POST["pedidoMaquina"];
            $agencia = $_POST["agencia"];
            $origenCoordenada = $_POST["origenCoordenada"];
            $query = "SELECT Id FROM `noventas` WHERE CodZonaVentas = '$CodZonaVentas' AND CuentaCliente = '$CuentaCliente' AND IdentificadorEnvio = '0' AND FechaNoVenta = CURDATE()";
            $idNoVenta = Consultas::model()->idpedidocoordenada($agencia, $query);
            $idNoVenta = $idPedido["Id"];
            $query = "INSERT INTO `coordenadas`(`CuentaCliente`, `IdDocumento`, `Origen`, `Longitud`, `Latitud`, `Fecha`, `Hora`, `CodZonaVentas`, `CodAsesor`) VALUES
            ('$CuentaCliente','$idNoVenta','$origenCoordenada','$Longitud','$Latitud',CURDATE(),CURTIME(),'$CodZonaVentas','$CodAsesor')";
            Consultas::model()->insertCoordenadaPedido($agencia, $query);
            //validamos el pedido para poder hacer el insert y recibimo cual es la agencia
            echo "OK";
        }
    }

    public function actionGenerarXMLPedido() {
        $idPedido;
        $idTipoDoc = "1";
        $CodAgencia = "002";
        $xml = '<?xml version="1.0" encoding="utf-8"?>';
        $xml .= '<panel>';
        //Consultamos los distintos pedidos
        $DistintosPedidos = ServiceAltipal::model()->getDistictPedidos($CodAgencia);
        foreach ($DistintosPedidos as $value) {
            # code...
            $idPedido = $value['IdPedido'];
            $coundetalles = ServiceAltipal::model()->getCountDetallePedidos($idPedido, $CodAgencia);
            if ($coundetalles[0]['detallepedido'] > 0) {
                $InfoXMl = ServiceAltipal::model()->getPedidoPreventaService($idPedido, $idTipoDoc, $CodAgencia);
                foreach ($InfoXMl as $itemInfo) {
                    $salesOrigin = $itemInfo['Web'] == 1 ? '002' : '001';
                    $codAdvaisor = $itemInfo['Responsable'] == "" ? $itemInfo['CodAsesor'] : $itemInfo['Responsable'];
                    $xml .= '<Header>';
                    $xml .= '<OrderType>pedido de venta</OrderType>';
                    $xml .= '<CustAccount>' . $itemInfo['CuentaCliente'] . '</CustAccount>';
                    if ($itemInfo['Conjunto'] == '002' || $itemInfo['Conjunto'] == '005') {
                        $xml .= '<SalesOrder>' . $itemInfo['NroFactura'] . '</SalesOrder>';
                    } else {
                        $xml .= '<SalesOrder>' . $CodAgencia . '-' . $itemInfo['IdPedido'] . '</SalesOrder>';
                    }
                    $xml .= '<Route>' . trim($itemInfo['Ruta']) . '</Route>';
                    $xml .= '<TaxGroup>' . $itemInfo['CodigoGrupodeImpuestos'] . '</TaxGroup>';
                    $xml .= '<AdvisorCode>' . $codAdvaisor . '</AdvisorCode>';
                    $xml .= '<SalesArea>' . $itemInfo['CodZonaVentas'] . '</SalesArea>';
                    $xml .= '<LogisticsAreaCode>' . $itemInfo['CodigoZonaLogistica'] . '</LogisticsAreaCode>';
                    $xml .= '<SalesGroup>' . $itemInfo['CodGrupoVenta'] . '</SalesGroup>';
                    $xml .= '<SalesOrigin>' . $salesOrigin . '</SalesOrigin>';
                    $xml .= '<SalesType>' . $itemInfo['Conjunto'] . '</SalesType>';
                    $xml .= '<Observations>' . $itemInfo['Observacion'] . '</Observations>';
                    $xml .= '<DeliveryDate>' . $itemInfo['FechaEntrega'] . '</DeliveryDate>';
                    $xml .= '<PaymentCondition>' . $itemInfo['Plazo'] . '</PaymentCondition>';
                    $InfoXMLDetail = ServiceAltipal::model()->getDetallePedidoPreventaService($itemInfo['IdPedido'], $CodAgencia);
                    foreach ($InfoXMLDetail as $Itemdetail) {
                        $cont = 0;
                        //$contActividaEspecial=0;
                        if ($Itemdetail['IdAcuerdoLinea'] == 0) {
                            $Itemdetail['IdAcuerdoLinea'] = '';
                        }
                        if ($Itemdetail['CodigoTipo'] == "KD" || $Itemdetail['CodigoTipo'] == "KV") {
                            $xml .= '<Detail>';
                            $xml .= '<VariantCode>' . $Itemdetail['CodVariante'] . '</VariantCode>';
                            $xml .= '<MeasureUnit>' . $Itemdetail['NombreUnidadMedida'] . '</MeasureUnit>';
                            $xml .= '<LotArticle>' . $Itemdetail['CodLote'] . '</LotArticle>';
                            $xml .= '<Quantity>0</Quantity>';
                            $xml .= '<Site>' . $itemInfo['CodigoSitio'] . '</Site>';
                            $xml .= '<SalesPrice>0</SalesPrice>';
                            $xml .= '<LineDiscount>' . $Itemdetail['DsctoLinea'] . '</LineDiscount>';
                            $xml .= '<MultiLineDiscount>' . $Itemdetail['DsctoMultiLinea'] . '</MultiLineDiscount>';
                            $xml .= '<SpecialAltipalDiscount>0</SpecialAltipalDiscount>';
                            $xml .= '<SpecialVendDiscount>0</SpecialVendDiscount>';
                            $xml .= '<KitQuantity>' . $Itemdetail['Cantidad'] . '</KitQuantity>';
                            $xml .= '<KitItemId>0</KitItemId>';
                            $xml .= '<ComponentQty>0</ComponentQty>';
                            $xml .='<agreementid>0</agreementid>';
                            $xml .= '</Detail>';
                        } else {
                            if ($itemInfo['AutorizaDescuentoEspecial'] == 1 || $itemInfo['ActividadEspecial'] == 1) {
                                $infoaprobacion = ServiceAltipal::model()->getPedidoDescuentoAprovado($Itemdetail['Id'], $CodAgencia);
                                /* echo '<pre>';
                                  print_r($infoaprobacion); */
                                $QuienAutorizaDscto = 0;
                                $EstadoRevisadoAltipal = 0;
                                $EstadoRevisadoProveedor = 0;
                                $EstadoRechazoAltipal = 0;
                                $EstadoRechazoProveedor = 0;
                                foreach ($infoaprobacion as $ItemAproba):
                                    //$cont=0;
                                    $QuienAutorizaDscto = $ItemAproba['QuienAutorizaDscto'];
                                    $EstadoRevisadoAltipal = $ItemAproba['EstadoRevisadoAltipal'];
                                    $EstadoRevisadoProveedor = $ItemAproba['EstadoRevisadoProveedor'];
                                    $EstadoRechazoAltipal = $ItemAproba['EstadoRechazoAltipal'];
                                    $EstadoRechazoProveedor = $ItemAproba['EstadoRechazoProveedor'];
                                    if ($QuienAutorizaDscto == 4) {
                                        if ($EstadoRevisadoAltipal > 0 && $EstadoRechazoAltipal == 0) {
                                            $xml .= '<Detail>';
                                            $xml .= '<VariantCode>' . $Itemdetail['CodVariante'] . '</VariantCode>';
                                            $xml .= '<MeasureUnit>' . $Itemdetail['NombreUnidadMedida'] . '</MeasureUnit>';
                                            $xml .= '<LotArticle>' . $Itemdetail['CodLote'] . '</LotArticle>';
                                            $xml .= '<Quantity>' . $Itemdetail['Cantidad'] . '</Quantity>';
                                            $xml .= '<Site>' . $itemInfo['CodigoSitio'] . '</Site>';
                                            $xml .= '<SalesPrice>' . $Itemdetail['ValorUnitario'] . '</SalesPrice>';
                                            $xml .= '<LineDiscount>' . $Itemdetail['DsctoLinea'] . '</LineDiscount>';
                                            $xml .= '<MultiLineDiscount>' . $Itemdetail['DsctoMultiLinea'] . '</MultiLineDiscount>';
                                            $xml .= '<SpecialAltipalDiscount>' . $Itemdetail['DsctoEspecialAltipal'] . '</SpecialAltipalDiscount>';
                                            $xml .= '<SpecialVendDiscount>' . $Itemdetail['DsctoEspecialProveedor'] . '</SpecialVendDiscount>';
                                            $xml .= '<KitQuantity>0</KitQuantity>';
                                            $xml .= '<KitItemId>0</KitItemId>';
                                            $xml .= '<ComponentQty>0</ComponentQty>';
                                            $xml .='<agreementid>' . $Itemdetail['IdAcuerdoLinea'] . '</agreementid>';
                                            $xml .= '</Detail>';
                                        }
                                        $cont++;
                                    }
                                    if ($QuienAutorizaDscto == 3) {
                                        if ($EstadoRevisadoAltipal > 0 && $EstadoRevisadoProveedor > 0) {
                                            $xml .= '<Detail>';
                                            $xml .= '<VariantCode>' . $Itemdetail['CodVariante'] . '</VariantCode>';
                                            $xml .= '<MeasureUnit>' . $Itemdetail['NombreUnidadMedida'] . '</MeasureUnit>';
                                            $xml .= '<LotArticle>' . $Itemdetail['CodLote'] . '</LotArticle>';
                                            $xml .= '<Quantity>' . $Itemdetail['Cantidad'] . '</Quantity>';
                                            $xml .= '<Site>' . $itemInfo['CodigoSitio'] . '</Site>';
                                            $xml .= '<SalesPrice>' . $Itemdetail['ValorUnitario'] . '</SalesPrice>';
                                            $xml .= '<LineDiscount>' . $Itemdetail['DsctoLinea'] . '</LineDiscount>';
                                            $xml .= '<MultiLineDiscount>' . $Itemdetail['DsctoMultiLinea'] . '</MultiLineDiscount>';
                                            $xml .= '<SpecialAltipalDiscount>' . $Itemdetail['DsctoEspecialAltipal'] . '</SpecialAltipalDiscount>';
                                            $xml .= '<SpecialVendDiscount>' . $Itemdetail['DsctoEspecialProveedor'] . '</SpecialVendDiscount>';
                                            $xml .= '<KitQuantity>0</KitQuantity>';
                                            $xml .= '<KitItemId>0</KitItemId>';
                                            $xml .= '<ComponentQty>0</ComponentQty>';
                                            $xml .='<agreementid>' . $Itemdetail['IdAcuerdoLinea'] . '</agreementid>';
                                            $xml .= '</Detail>';
                                        }
                                        $cont++;
                                    }
                                    if ($QuienAutorizaDscto == 2) {
                                        if ($EstadoRevisadoProveedor > 0 && $EstadoRechazoProveedor == 0) {
                                            $xml .= '<Detail>';
                                            $xml .= '<VariantCode>' . $Itemdetail['CodVariante'] . '</VariantCode>';
                                            $xml .= '<MeasureUnit>' . $Itemdetail['NombreUnidadMedida'] . '</MeasureUnit>';
                                            $xml .= '<LotArticle>' . $Itemdetail['CodLote'] . '</LotArticle>';
                                            $xml .= '<Quantity>' . $Itemdetail['Cantidad'] . '</Quantity>';
                                            $xml .= '<Site>' . $itemInfo['CodigoSitio'] . '</Site>';
                                            $xml .= '<SalesPrice>' . $Itemdetail['ValorUnitario'] . '</SalesPrice>';
                                            $xml .= '<LineDiscount>' . $Itemdetail['DsctoLinea'] . '</LineDiscount>';
                                            $xml .= '<MultiLineDiscount>' . $Itemdetail['DsctoMultiLinea'] . '</MultiLineDiscount>';
                                            $xml .= '<SpecialAltipalDiscount>' . $Itemdetail['DsctoEspecialAltipal'] . '</SpecialAltipalDiscount>';
                                            $xml .= '<SpecialVendDiscount>' . $Itemdetail['DsctoEspecialProveedor'] . '</SpecialVendDiscount>';
                                            $xml .= '<KitQuantity>0</KitQuantity>';
                                            $xml .= '<KitItemId>0</KitItemId>';
                                            $xml .= '<ComponentQty>0</ComponentQty>';
                                            $xml .='<agreementid>' . $Itemdetail['IdAcuerdoLinea'] . '</agreementid>';
                                            $xml .= '</Detail>';
                                        }
                                        $cont++;
                                    }
                                    if ($QuienAutorizaDscto == 1) {
                                        if ($EstadoRevisadoAltipal > 0 && $EstadoRechazoAltipal == 0) {
                                            $xml .= '<Detail>';
                                            $xml .= '<VariantCode>' . $Itemdetail['CodVariante'] . '</VariantCode>';
                                            $xml .= '<MeasureUnit>' . $Itemdetail['NombreUnidadMedida'] . '</MeasureUnit>';
                                            $xml .= '<LotArticle>' . $Itemdetail['CodLote'] . '</LotArticle>';
                                            $xml .= '<Quantity>' . $Itemdetail['Cantidad'] . '</Quantity>';
                                            $xml .= '<Site>' . $itemInfo['CodigoSitio'] . '</Site>';
                                            $xml .= '<SalesPrice>' . $Itemdetail['ValorUnitario'] . '</SalesPrice>';
                                            $xml .= '<LineDiscount>' . $Itemdetail['DsctoLinea'] . '</LineDiscount>';
                                            $xml .= '<MultiLineDiscount>' . $Itemdetail['DsctoMultiLinea'] . '</MultiLineDiscount>';
                                            $xml .= '<SpecialAltipalDiscount>' . $Itemdetail['DsctoEspecialAltipal'] . '</SpecialAltipalDiscount>';
                                            $xml .= '<SpecialVendDiscount>' . $Itemdetail['DsctoEspecialProveedor'] . '</SpecialVendDiscount>';
                                            $xml .= '<KitQuantity>0</KitQuantity>';
                                            $xml .= '<KitItemId>0</KitItemId>';
                                            $xml .= '<ComponentQty>0</ComponentQty>';
                                            $xml .='<agreementid>' . $Itemdetail['IdAcuerdoLinea'] . '</agreementid>';
                                            $xml .= '</Detail>';
                                        }
                                        $cont++;
                                    }
                                endforeach;
                                if ($cont == 0) {
                                    $xml .= '<Detail>';
                                    $xml .= '<VariantCode>' . $Itemdetail['CodVariante'] . '</VariantCode>';
                                    $xml .= '<MeasureUnit>' . $Itemdetail['NombreUnidadMedida'] . '</MeasureUnit>';
                                    $xml .= '<LotArticle>' . $Itemdetail['CodLote'] . '</LotArticle>';
                                    $xml .= '<Quantity>' . $Itemdetail['Cantidad'] . '</Quantity>';
                                    $xml .= '<Site>' . $itemInfo['CodigoSitio'] . '</Site>';
                                    $xml .= '<SalesPrice>' . $Itemdetail['ValorUnitario'] . '</SalesPrice>';
                                    $xml .= '<LineDiscount>' . $Itemdetail['DsctoLinea'] . '</LineDiscount>';
                                    $xml .= '<MultiLineDiscount>' . $Itemdetail['DsctoMultiLinea'] . '</MultiLineDiscount>';
                                    $xml .= '<SpecialAltipalDiscount>' . $Itemdetail['DsctoEspecialAltipal'] . '</SpecialAltipalDiscount>';
                                    $xml .= '<SpecialVendDiscount>' . $Itemdetail['DsctoEspecialProveedor'] . '</SpecialVendDiscount>';
                                    $xml .= '<KitQuantity>0</KitQuantity>';
                                    $xml .= '<KitItemId>0</KitItemId>';
                                    $xml .= '<ComponentQty>0</ComponentQty>';
                                    $xml .='<agreementid>' . $Itemdetail['IdAcuerdoLinea'] . '</agreementid>';
                                    $xml .= '</Detail>';
                                }
                            } else {
                                $xml .= '<Detail>';
                                $xml .= '<VariantCode>' . $Itemdetail['CodVariante'] . '</VariantCode>';
                                $xml .= '<MeasureUnit>' . $Itemdetail['NombreUnidadMedida'] . '</MeasureUnit>';
                                $xml .= '<LotArticle>' . $Itemdetail['CodLote'] . '</LotArticle>';
                                $xml .= '<Quantity>' . $Itemdetail['Cantidad'] . '</Quantity>';
                                $xml .= '<Site>' . $itemInfo['CodigoSitio'] . '</Site>';
                                $xml .= '<SalesPrice>' . $Itemdetail['ValorUnitario'] . '</SalesPrice>';
                                $xml .= '<LineDiscount>' . $Itemdetail['DsctoLinea'] . '</LineDiscount>';
                                $xml .= '<MultiLineDiscount>' . $Itemdetail['DsctoMultiLinea'] . '</MultiLineDiscount>';
                                $xml .= '<SpecialAltipalDiscount>' . $Itemdetail['DsctoEspecialAltipal'] . '</SpecialAltipalDiscount>';
                                $xml .= '<SpecialVendDiscount>' . $Itemdetail['DsctoEspecialProveedor'] . '</SpecialVendDiscount>';
                                $xml .= '<KitQuantity>0</KitQuantity>';
                                $xml .= '<KitItemId>0</KitItemId>';
                                $xml .= '<ComponentQty>0</ComponentQty>';
                                $xml .= '<agreementid>' . $Itemdetail['IdAcuerdoLinea'] . '</agreementid>';
                                $xml .= '</Detail>';
                            }
                        }
                        if ($Itemdetail['CodigoTipo'] == "KD" || $Itemdetail['CodigoTipo'] == "KV") {
                            $InfoXMLDetailKD = ServiceAltipal::model()->getPedidoDetalleKidService($Itemdetail['Id'], $CodAgencia);
                            foreach ($InfoXMLDetailKD as $itemKit) {
                                //$totalkit = $Itemdetail['Cantidad'] * $itemKit['Cantidad'];
                                $totalkit = $Itemdetail['Cantidad'];
                                $totalPrecioVentaBaseVariante = $itemKit['PrecioVentaBaseVariante'] * $Itemdetail['Cantidad'];
                                $totalPrecioVentaBaseVariante = $itemKit['PrecioVentaBaseVariante'] / $itemKit['Cantidad'];
                                $xml .= '<Detail>';
                                $xml .= '<VariantCode>' . $itemKit['CodigoArticuloComponente'] . '</VariantCode>';
                                $xml .= '<MeasureUnit>' . $itemKit['CodigoUnidadMedida'] . '</MeasureUnit>';
                                $xml .= '<LotArticle>' . $Itemdetail['CodLote'] . '</LotArticle>';
                                $xml .= '<Quantity>0</Quantity>';
                                $xml .= '<Site>' . $itemInfo['CodigoSitio'] . '</Site>';
                                // se cambia por los nuevos requerimientos, se le pregunta a yudi y dice que es en los componentes y no en el encabezado $xml .= '<SalesPrice>' . $totalPrecioVentaBaseVariante . '</SalesPrice>';
                                $xml .= '<SalesPrice>' . $totalPrecioVentaBaseVariante . '</SalesPrice>';
                                $xml .= '<LineDiscount>0</LineDiscount>';
                                $xml .= '<MultiLineDiscount>0</MultiLineDiscount>';
                                $xml .= '<SpecialAltipalDiscount>0</SpecialAltipalDiscount>';
                                $xml .= '<SpecialVendDiscount>0</SpecialVendDiscount>';
                                $xml .= '<KitQuantity>' . $totalkit . '</KitQuantity>';
                                $xml .= '<KitItemId>' . $Itemdetail['CodigoArticulo'] . '</KitItemId>';
                                $xml .= '<ComponentQty>' . $itemKit['Cantidad'] . '</ComponentQty>';
                                $xml .='<agreementid>0</agreementid>';
                                $xml .= '</Detail>';
                            }
                        }
                    }
                    $xml .= '</Header>';
                }
            }
        }
        $xml .= '</panel>';
        $manejador = fopen('pedidos.XML', 'a+');
        fputs($manejador, $xml);
        fclose($manejador);
        echo $xml;
    }
}
