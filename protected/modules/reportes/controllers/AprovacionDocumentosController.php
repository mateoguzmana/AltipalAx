<?php

class AprovacionDocumentosController extends Controller {

    private $modulo = "reportes";

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
//'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function accessRules() {
        if (!Yii::app()->getUser()->hasState('_cedula')) {
            $this->redirect('index.php');
        }
        $cedula = Yii::app()->user->_cedula;
        $Criteria = new CDbCriteria();
        $Criteria->condition = "Cedula=$cedula";
        $idPerfil = Yii::app()->user->_idPerfil;
        $controlador = Yii::app()->controller->getId();
        $PerfilAcciones = Consultas::model()->getPerfilAcciones($idPerfil, $controlador);
        Yii::import('application.extensions.function.Action');
        $estedAction = new Action();
        try {
            $actionAjax = $estedAction->getActions(ucfirst($controlador) . 'Controller', $this->modulo);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        $acciones = array();
        foreach ($PerfilAcciones as $itemAccion) {
            array_push($acciones, $itemAccion['Descripcion']);
        }
        foreach ($actionAjax as $item) {
            $dato = strtolower('ajax' . $item);
            array_push($acciones, $dato);
        }
        /* validacion para no mostrar botones */
        $arrayAction = Listalink::model()->findPerfil(ucfirst($controlador), $idPerfil);
        $arrayDiferentes = $estedAction->diffActions(ucfirst($controlador) . 'Controller', $this->modulo, $arrayAction);
        $session = new CHttpSession;
        $session->open();
        $session['diferencia'] = $arrayDiferentes;
        if (count($acciones) <= 0) {
            return array(
                array('deny',
                    'users' => array('*'),
                ),
            );
        } else {
            return array(
                array('allow',
                    'actions' => $acciones,
                    'users' => array('@'),
                ),
                array('deny',
                    'users' => array('*'),
                ),
            );
        }
    }

    public function actionMenuAprovaciones() {
        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/scripts/reportes/AprovacionDocumentos/menuaprobaciones.js', CClientScript::POS_END
        );
        $this->render('menuAprovaciones');
    }

    public function actionDescuentos() {
        $idPerfil = Yii::app()->user->_idPerfil;
        $id = Yii::app()->user->getState('_Id');
        if ($idPerfil == 29) {
            $peidosDescuentosCartera = AprovacionDocumentos::model()->getPedidosDescuentosAdminCartera($id);
            $pedidos = count($peidosDescuentosCartera);
            if ($pedidos > 0) {
                $this->render('descuentos', array('pedidosDescuentos' => $peidosDescuentosCartera));
            } else {
                $_SESSION["AprobarDes"] = 1;
                echo "<script language='javascript'>window.location.href='index.php?r=reportes/AprovacionDocumentos/MenuAprovaciones';</script>";
            }
        } else {
            $tipoUsuario = Yii::app()->user->_tipoUsuario;
            $cedulaUsuario = Yii::app()->user->_cedula;
            $consulta = new Multiple;
            $agencia = $consulta->getAgencias($cedulaUsuario);
            $cuentaProveedorAdministrador = AprovacionDocumentos::model()->getProveedorAdministrador($cedulaUsuario);
            $proveedor = $cuentaProveedorAdministrador['CodigoProveedor'];
            Yii::app()->clientScript->registerScriptFile(
                    Yii::app()->baseUrl . '/scripts/reportes/AprovacionDocumentos/descuentos.js', CClientScript::POS_END
            );
            $pedidosDescuentos = AprovacionDocumentos::model()->getPedidosDescuentos($tipoUsuario, $proveedor, $id);
            $pedidos = count($pedidosDescuentos);
            if ($pedidos > 0) {
                $this->render('descuentos', array('pedidosDescuentos' => $pedidosDescuentos, 'proveedor' => $proveedor, 'agencias' => $agencia));
            } else {
                $_SESSION["AprobarDes"] = 1;
                echo "<script language='javascript'>window.location.href='index.php?r=reportes/AprovacionDocumentos/MenuAprovaciones';</script>";
            }
        }
    }

    public function actionAprobarTransConsignacion() {
        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/scripts/reportes/AprovacionDocumentos/transferenciaconsignacion.js', CClientScript::POS_END
        );
        $id = Yii::app()->user->getState('_Id');
        $totaltansferenia = AprovacionDocumentos::model()->getTotalTransConsigSinAprovar($id);
        $transferencias = AprovacionDocumentos::model()->getTransConsigSinAprovar($id);
        $totalransconsig = count($totaltansferenia);
        $transconsig = count($transferencias);
        if ($totalransconsig > 0 && $transconsig > 0) {
            $this->render('transferenciaconsignacion', array(
                'totaltansferenia' => $totaltansferenia,
                'transferencias' => $transferencias
            ));
        } else {
            $_SESSION["AprobarTrans"] = 1;
            echo "<script language='javascript'>window.location.href='index.php?r=reportes/AprovacionDocumentos/MenuAprovaciones';</script>";
        }
    }

    public function actionAprobarDevoluciones() {
        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/scripts/reportes/AprovacionDocumentos/devoluciones.js', CClientScript::POS_END
        );
        $cedulaUsuario = Yii::app()->user->_cedula;
        $id = Yii::app()->user->getState('_Id');
        $totaldevolucion = AprovacionDocumentos::model()->getTotalDevoluciones($id);
        $devoluciones = AprovacionDocumentos::model()->getDevolucionesSinAprovar($id);
        if (count($totaldevolucion) > 0 && count($devoluciones) > 0) {
            $this->render('devoluciones', array(
                'totaldevolucion' => $totaldevolucion,
                'devoluciones' => $devoluciones
            ));
        } else {
            $_SESSION["AprobarDevol"] = 1;
            echo "<script language='javascript'>window.location.href='index.php?r=reportes/AprovacionDocumentos/MenuAprovaciones';</script>";
        }
    }

    public function actionAjaxDetalleDevoluciones($agencia, $grupoVentas) {
        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/scripts/reportes/AprovacionDocumentos/devolucionesDetalle.js', CClientScript::POS_END
        );
        $informationDevoluciones = AprovacionDocumentos::model()->getInforamcionDevoluciones($agencia, $grupoVentas);
        $conteoInformacionDevoluciones = count($informationDevoluciones);
        if ($conteoInformacionDevoluciones > 0) {
            $this->render('aprovarDevolucionDetalle', array(
                'informationDevoluciones' => $informationDevoluciones,
                'agencia' => $agencia
            ));
        } else {
            echo "<script language='javascript'>window.location.href='index.php?r=reportes/AprovacionDocumentos/AprobarDevoluciones';</script>";
        }
    }

    public function actionAjaxDetalladoDevoluciones() {
        if ($_POST) {
            $iddevoluciones = $_POST['idDevoluciones'];
            $agencia = $_POST['agencia'];
            $InformacionDetalladaDevoluciones = AprovacionDocumentos::model()->getinforamcionDevolucionDetalle($iddevoluciones, $agencia);
            echo $this->renderPartial('_detalledevolucion', array(
                'InformacionDetalladaDevoluciones' => $InformacionDetalladaDevoluciones,
                'agencia' => $agencia
            ));
        }
    }

    public function actionAjaxGuardaAprovacionDevoluciones() {
        if ($_POST) {
            $iddevolucion = $_POST['id'];
            $array = $_POST['estado'];
            $agencia = $_POST['agencia'];
            $arrayRechazados = $_POST['estadorechazado'];
            $observacion = $_POST['observacion'];
            $valordevolucion = $_POST['valordevolucion'];
            $zona = $_POST['zona'];
            $cliente = $_POST['cliente'];
            $asesor = $_POST['asesor'];
            $user = Yii::app()->user->getState('_usuario');
            $cedula = Yii::app()->user->getState('_cedula');
            $fecha = date('Y-m-d');
            $hora = date('H:i:s');
            $inserObservacion = AprovacionDocumentos::model()->getObservacion($iddevolucion, $observacion, $agencia);
            $valorarray = count($array);
            if ($valorarray > 0) {
                $inserttrans = AprovacionDocumentos::model()->getInsertTansaccionesDevoluciones($iddevolucion, $agencia);
                AprovacionDocumentos::model()->getUpdateAutirzaDevolucionApro($iddevolucion, $agencia, $user, $fecha, $hora);
            } else {
                AprovacionDocumentos::model()->getUpdateAutirzaDevolucionRecha($iddevolucion, $agencia, $user, $fecha, $hora);
            }
            foreach ($array as $item) {
                $updateAprovado = AprovacionDocumentos::model()->getUpdateProdcutosDevolucionaAutorizado($iddevolucion, $item, $agencia);
            }
            foreach ($arrayRechazados as $itemRehazado) {
                $updateRechazado = AprovacionDocumentos::model()->getUpdateProdcutosDevolucionRechazar($iddevolucion, $itemRehazado, $agencia);
            }
            $DescPedido = AprovacionDocumentos::model()->getDescrPedido($iddevolucion);
            $total = 0;
            foreach ($DescPedido as $ItemDesPe) {
                $total = $total + $ItemDesPe['ValorTotalProducto'];
            }
            $Recalcularvalordevolcuion = $valordevolucion - $total;
            AprovacionDocumentos::model()->getUpdateValorDevolucion($iddevolucion, $agencia, $Recalcularvalordevolcuion);
            $productoAprovados = AprovacionDocumentos::model()->getCountAutorizadoAprova($iddevolucion);
            $productoRechzados = AprovacionDocumentos::model()->getCountAutorizadoRechaz($iddevolucion);
            echo $productoAprovados[0]['aprovadas'] . ' > 0' . '&&' . $productoRechzados[0]['rechazadas'] . '>0';
            if ($productoAprovados[0]['aprovadas'] > 0 && $productoRechzados[0]['rechazadas'] > 0) {
                echo 'entre';
                $msg = 'La Devolucion para el cliente : ' . $cliente . ' fue Aprobada Incompleta';
                $insertmsg = AprovacionDocumentos::model()->getInsertmensaje($zona, $cedula, $agencia, $msg, $asesor);
            } else if ($productoAprovados[0]['aprovadas'] > 0 && $productoRechzados[0]['rechazadas'] == 0) {
                $msg = 'La Devolucion para el cliente : ' . $cliente . ' fue Aprobada Completamente';
                $insertmsg = AprovacionDocumentos::model()->getInsertmensaje($zona, $cedula, $agencia, $msg, $asesor);
            } else if ($productoRechzados[0]['rechazadas'] > 0 && $$productoAprovados[0]['aprovadas'] == 0) {
                $msg = 'La Devolucion para el cliente : ' . $cliente . ' fue Rechazada Completamente';
                $insertmsg = AprovacionDocumentos::model()->getInsertmensaje($zona, $cedula, $agencia, $msg, $asesor);
            }
        }
    }

    public function actionAjaxDetalleTransferenciaConsignacion($agencia, $grupoVentas) {
        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/scripts/reportes/AprovacionDocumentos/transferenciaconsignacionDetalle.js', CClientScript::POS_END
        );
        $Information = AprovacionDocumentos::model()->getinforamcionTrasnmfererncia($agencia, $grupoVentas);

        $conteoInformacionCOnsignacion = count($Information);
        if ($conteoInformacionCOnsignacion > 0) {

            $this->render('aprovarTranfereciasConsignacionDetalle', array(
                'Information' => $Information,
                'agencia' => $agencia
            ));
        } else {
            echo "<script language='javascript'>window.location.href='index.php?r=reportes/AprovacionDocumentos/AprobarTransConsignacion';</script>";
        }
    }

    public function actionAjaxDetalladoTransConsignacion() {
        if ($_POST) {
            $id = $_POST['idTransferenciaConsignacion'];
            $agencia = $_POST['agencia'];
            $InformacionDetalladaTransConsignacion = AprovacionDocumentos::model()->getinforamcionTrasnmferernciaDetalle($id, $agencia);
            echo $this->renderPartial('_detalletransferenciaconsignacion', array(
                'InformacionDetalladaTransConsignacion' => $InformacionDetalladaTransConsignacion,
                'agencia' => $agencia
            ));
        }
    }

    public function actionAjaxGuardaAprovacionTransferenciaConsignacion() {
        if ($_POST) {
            $estado = $_POST['estado'];
            $idtransferencia = $_POST['id'];
            $agencia = $_POST['agencia'];
            $zona = $_POST['zona'];
            $asesor = $_POST['asesor'];
            $cliente = $_POST['cliente'];
            $remitente = Yii::app()->user->getState('_cedula');
            $msgAuto = 'La transferencia consignación para el cliente ' . $cliente . ' fue autorizada';
            $msgRecha = 'La transferencia consignación para el cliente ' . $cliente . ' fue rechazada';
            foreach ($estado as $itemestado) {
                $itemestado;
            }
            if ($itemestado == 1) {
                $update = AprovacionDocumentos::model()->getUpdateEstadoTGransferenciaConsignacion($idtransferencia, $agencia);
                AprovacionDocumentos::model()->InsertTransaAxTransConsig($idtransferencia, $agencia);
                AprovacionDocumentos::model()->getInsertmensaje($zona, $remitente, $agencia, $msgAuto, $asesor);
            } else if ($itemestado == 0) {
                $update = AprovacionDocumentos::model()->getUpdateEstadoTGransferenciaConsignacionRecha($idtransferencia, $agencia);
                AprovacionDocumentos::model()->getInsertmensaje($zona, $remitente, $agencia, $msgRecha, $asesor);
            }
        }
    }

    public function actionAprobarNotasCredito() {
        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/scripts/reportes/AprovacionDocumentos/notascreditoAprobacion.js', CClientScript::POS_END
        );
        $id = Yii::app()->user->getState('_Id');
        $idPerfil = Yii::app()->user->getState('_idPerfil');
        $conceptos = AprovacionDocumentos::model()->conceptosAdministradorNotasCredito($id);

///entra al if se el usuario logueado en session tiene el id de perfil 29

        if ($idPerfil == 29) {
            $NotsaAdminCartera = array();
            $notasCreditoAdminCartera = AprovacionDocumentos::model()->getNotasCreditoAdminCartera($conceptos, $id);
            foreach ($notasCreditoAdminCartera as $itemNotasAdmin) {
                $datoNotaAdminCartera = array(
                    'CodZonaVentas' => $itemNotasAdmin['CodZonaVentas'],
                    'NombreGrupoVentas' => $itemNotasAdmin['NombreGrupoVentas'],
                    'CodAgencia' => $itemNotasAdmin['CodAgencia'],
                    'Nombre' => $itemNotasAdmin['Nombre'],
                    'Valor' => $itemNotasAdmin['Valor'],
                    'CodigoGrupoVentas' => $itemNotasAdmin['CodigoGrupoVentas'],
                    'TotalNota' => $itemNotasAdmin['TotalNota'],
                    'CantidadNotas' => $itemNotasAdmin['CantidadNotas']
                );
                array_push($NotsaAdminCartera, $datoNotaAdminCartera);
            }
            $notasAdminCartera = count($NotsaAdminCartera);
            if ($notasAdminCartera > 0) {
                $this->render('aprobarNotasCredito', array('notasCredito' => $NotsaAdminCartera));
            } else {
                $_SESSION["AprobarNotas"] = 1;
                echo "<script language='javascript'>window.location.href='index.php?r=reportes/AprovacionDocumentos/MenuAprovaciones';</script>";
            }
        } else {
            //Entra aca si no es el perfil de adminnistrador cartera
            $tipoUsuario = Yii::app()->user->_tipoUsuario;
            $cedulaUsuario = Yii::app()->user->_cedula;
            $proveedor = '';
            if ($tipoUsuario == '2') {
                $cuentaProveedorAdministrador = AprovacionDocumentos::model()->getProveedorAdministrador($cedulaUsuario);
                $proveedor = $cuentaProveedorAdministrador['CodigoProveedor'];
            }
            $cnc = array();
            $notasCredito = AprovacionDocumentos::model()->getNotasCredito($conceptos, $tipoUsuario, $proveedor, $id);
            foreach ($notasCredito as $itemnotascrediot) {
                $dato = array(
                    'CodZonaVentas' => $itemnotascrediot['CodZonaVentas'],
                    'NombreGrupoVentas' => $itemnotascrediot['NombreGrupoVentas'],
                    'CodAgencia' => $itemnotascrediot['CodAgencia'],
                    'Nombre' => $itemnotascrediot['Nombre'],
                    'Valor' => $itemnotascrediot['Valor'],
                    'CodigoGrupoVentas' => $itemnotascrediot['CodigoGrupoVentas'],
                    'TotalNota' => $itemnotascrediot['TotalNota'],
                    'CantidadNotas' => $itemnotascrediot['CantidadNotas']
                );
                array_push($cnc, $dato);
            }
            $notas = count($cnc);
            if ($notas > 0) {
                $this->render('aprobarNotasCredito', array('notasCredito' => $cnc));
            } else {
                $_SESSION["AprobarNotas"] = 1;
                echo "<script language='javascript'>window.location.href='index.php?r=reportes/AprovacionDocumentos/MenuAprovaciones';</script>";
            }
        }
    }

    public function actionAjaxAprovarNotasCredito($agencia, $grupoVentas) {
        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/scripts/reportes/AprovacionDocumentos/notascredito.js', CClientScript::POS_END
        );
        $idPerfil = Yii::app()->user->getState('_idPerfil');
        if ($idPerfil == 29) {
            $tipoUsuario = Yii::app()->user->_tipoUsuario;
            $InformacionNotaCreditoAdminCartera = AprovacionDocumentos::model()->getInformacionNotasCreditoAdminCarter($agencia, $grupoVentas, $tipoUsuario, $proveedor);
            if (isset($_GET['ex'])) {
                $this->renderPartial('notasCreditoExcel', array(
                    'InformacionNotaCredito' => $InformacionNotaCreditoAdminCartera,
                    'agencia' => $agencia,
                    'grupoVentas' => $grupoVentas
                ));
            } else {
                $this->render('aprovarNotasCreditoDetalle', array(
                    'InformacionNotaCredito' => $InformacionNotaCreditoAdminCartera,
                    'agencia' => $agencia,
                    'grupoVentas' => $grupoVentas
                ));
            }
        } else {
            $tipoUsuario = Yii::app()->user->_tipoUsuario;
            $cedulaUsuario = Yii::app()->user->_cedula;
            $cuentaProveedorAdministrador = AprovacionDocumentos::model()->getProveedorAdministrador($cedulaUsuario);
            $proveedor = $cuentaProveedorAdministrador['CodigoProveedor'];
            $InformacionNotaCredito = AprovacionDocumentos::model()->getInformacionNotasCredito($agencia, $grupoVentas, $tipoUsuario, $proveedor);
            $contarInformacionNotas = count($InformacionNotaCredito);
            /*echo '<pre>';
            print_r($contarInformacionNotas);
            exit();*/
            if ($contarInformacionNotas > 0) {
                if (isset($_GET['ex'])) {
                    $this->renderPartial('notasCreditoExcel', array(
                        'InformacionNotaCredito' => $InformacionNotaCredito,
                        'agencia' => $agencia,
                        'grupoVentas' => $grupoVentas
                    ));
                } else {
                    $this->render('aprovarNotasCreditoDetalle', array(
                        'InformacionNotaCredito' => $InformacionNotaCredito,
                        'agencia' => $agencia,
                        'grupoVentas' => $grupoVentas
                    ));
                }
            } else {
                echo "<script language='javascript'>window.location.href='http://altipal.datosmovil.info/altipalAx/index.php?r=reportes/AprovacionDocumentos/AprobarNotasCredito';</script>";
            }
        }
    }

    public function actionAjaxRechazarNotaCredito() {
        if ($_POST) {
            $id = $_POST['id'];
            $Comentario = $_POST['comnentario'];
            $agencia = $_POST['agencia'];
            $user = Yii::app()->user->getState('_usuario');
            $idPerfil = Yii::app()->user->getState('_idPerfil');
            $Factura = $_POST['factura'];
            $cliente = $_POST['cli'];
            $valor = $_POST['valor'];
            $remitente = $_POST['remitente'];
            $zona = $_POST['zona'];
            $fecha = date('Y-m-d');
            $hora = date('H:i:s');
            $asesor = $_POST['asesor'];
            if ($idPerfil == 29) {
                $Mensaje = 'La Nota Credito para la factura "' . $Factura . '" del cliente "' . $cliente . '" por valor de "' . $valor . '" fue Rechazada - "' . $Comentario . '"';
                $actualizar = AprovacionDocumentos::model()->UpdateRechazarNotaCreditoAdminCartera($id, $Comentario, $agencia, $user, $fecha, $hora);
                $insertMsg = AprovacionDocumentos::model()->InsertMensajeNotasCredito($remitente, $zona, $fecha, $hora, $Mensaje, $asesor, $agencia);
            } else {
                $Mensaje = 'La Nota Credito para la factura "' . $Factura . '" del cliente "' . $cliente . '" por valor de "' . $valor . '" fue Rechazada - "' . $Comentario . '"';
                $actualizar = AprovacionDocumentos::model()->UpdateRechazarNotaCredito($id, $Comentario, $agencia, $user, $fecha, $hora);
                $insertMsg = AprovacionDocumentos::model()->InsertMensajeNotasCredito($remitente, $zona, $fecha, $hora, $Mensaje, $asesor, $agencia);
            }
        }
    }

    public function actionAjaxAutorizarNotaCredito() {
        if ($_POST) {
            $id = $_POST['id'];
            $agencia = $_POST['agencia'];
            $user = Yii::app()->user->getState('_usuario');
            $idPerfil = Yii::app()->user->getState('_idPerfil');
            $Factura = $_POST['factura'];
            $cliente = $_POST['cli'];
            $valor = $_POST['valor'];
            $remitente = $_POST['remitente'];
            $zona = $_POST['zona'];
            $fecha = date('Y-m-d');
            $hora = date('H:i:s');
            $asesor = $_POST['asesor'];
            $coddinamica = $_POST['coddinamica'];
            $valordinamica = $_POST['valordinamica'];
            if ($idPerfil == 29) {
                $Mensaje = 'La Nota Credito para la factura ' . $Factura . ' del cliente ' . $cliente . ' por valor de ' . $valor . ' fue Autorizada';
                $actualizar = AprovacionDocumentos::model()->UpdateAutorizarNotaCreditoAdminCartera($id, $agencia, $user, $fecha, $hora);
                $insert = AprovacionDocumentos::model()->InsertTransaccionesNotasCredito($id, $agencia);
                $insertMsg = AprovacionDocumentos::model()->InsertMensajeNotasCredito($remitente, $zona, $fecha, $hora, $Mensaje, $asesor, $agencia);
            } else {
                $Mensaje = 'La Nota Credito para la factura ' . $Factura . ' del cliente ' . $cliente . ' por valor de ' . $valor . ' fue Autorizada';
                $actualizar = AprovacionDocumentos::model()->UpdateAutorizarNotaCredito($id, $agencia, $user, $fecha, $hora);
                $insert = AprovacionDocumentos::model()->InsertTransaccionesNotasCredito($id, $agencia);
                $insertMsg = AprovacionDocumentos::model()->InsertMensajeNotasCredito($remitente, $zona, $fecha, $hora, $Mensaje, $asesor, $agencia);
                $updateDinamica = AprovacionDocumentos::model()->getUpdateSaldoDinamica($coddinamica, $valordinamica, $agencia);
                $updateCodDinamica = AprovacionDocumentos::model()->getUpdateNotaDinamica($id, $coddinamica, $agencia);
            }
        }
    }

    public function actionAjaxDetalleFactura() {
        if ($_POST) {
            $numerofactura = $_POST['numfactu'];
            $detalle = AprovacionDocumentos::model()->Detallefactura($numerofactura);
            $tabla = "";
            $tabla.='<table class="table table-hover table-bordered mb30">
                <tr>
                <th nowrap="nowrap">Numero Factura: </th>
                <th class="text-center">' . $detalle[0]['NumeroFactura'] . '</th>
                <th class="text-center">Fecha: </th>
                <th class="text-center">' . $detalle[0]['FechaFactura'] . '</th>
                <th class="text-center">Cliente: </th>
                <th nowrap="nowrap">' . $detalle[0]['NombreCliente'] . '</th>
                <th class="text-center" nowrap="nowrap">Valor Factura: </th>
                <th nowrap="nowrap">' . number_format($detalle[0]['ValorNetoFactura'], '2', ',', '.') . '</th>
                </tr>
                <tr>
                <th>No</th>
                <th class="text-center">Código Artículo</th>
                <th nowrap="nowrap" class="text-center">Descripción del equipo</th>
                <th class="text-center" colspan="2">Proveedor</th>
                <th class="text-center">Cantidad</th>
                <th colspan="2" class="text-center">Total Artículo</th>
                </tr>';
            $cont = 0;
            foreach ($detalle as $ItemDetalle) {
                $cont++;
                $tabla.='
                <tr>
                    <td>' . $cont . '</td>
                    <td>' . $ItemDetalle['CodigoVariante'] . '</td>
                    <td>' . $ItemDetalle['NombreArticulo'] . '</td>
                    <td colspan="2">' . $ItemDetalle['NombreCuentaProveedor'] . ' -- ' . $ItemDetalle['CodigoCuentaProveedor'] . '</td>
                    <td class="text-center">' . $ItemDetalle['CantidadFacturada'] . '</td>
                    <td colspan="2" class="text-center">' . number_format($ItemDetalle['ValorNetoArticulo'], '2', ',', '.') . '</td>
                </tr>';
            }
            $tabla.='</table>';
            echo $tabla;
        }
    }

    public function actionAjaxDetalleFotos() {
        $cont = 0;
        if ($_POST) {
            $id = $_POST['id'];
            $agencia = $_POST['agencia'];
            $fotos = AprovacionDocumentos::model()->getDetalleFotosNotasCreditoDias($id, $agencia);
            echo $fotos;
            $detallefoto = "";
            $detallefoto.='
                 <div class="row">
                      <div class="col-sm-12">
                          <div class="row filemanager">';
            foreach ($fotos as $itemFoto) {
                $cont++;
                $detallefoto.='<div class="col-xs-6 col-sm-4 col-md-3 image">
              <div class="thmb">
                  <div class="thmb-prev">
                  <a href="imagenes/' . $itemFoto['Nombre'] . '" data-rel="prettyPhoto">
                    <img src="imagenes/' . $itemFoto['Nombre'] . '" class="img-responsive" alt="" />
                  </a>
                </div>
                <h5 class="fm-title"><a href="#">' . $itemFoto['Nombre'] . '</a></h5>
                <small class="text-muted">Foto</small>
              </div><!-- thmb -->
            </div><!-- col-xs-6 -->';
            }
            $detallefoto.='</div><!-- row -->
                 </div><!-- col-sm-9 -->
             </div>';
            if ($cont == 0) {
                $detallefoto = "";
            }
            echo $detallefoto;
        }
    }

    public function actionAprobarActividadEspecial() {
        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/scripts/reportes/AprovacionDocumentos/actividadespecial.js', CClientScript::POS_END
        );
        $id = Yii::app()->user->getState('_Id');
        $ActividaEspecial = AprovacionDocumentos::model()->getActividaEspecial($id);
        $pedidosActividadespecial = count($ActividaEspecial);
        if ($pedidosActividadespecial > 0) {
            $this->render('actividadespecial', array('ActividaEspecial' => $ActividaEspecial));
        } else {
            $_SESSION["AprobarActiv"] = 1;
            echo "<script language='javascript'>window.location.href='index.php?r=reportes/AprovacionDocumentos/MenuAprovaciones';</script>";
        }
    }

    public function actionAjaxAprovarActividadEspecial($agencia, $grupoVentas) {
        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/scripts/reportes/AprovacionDocumentos/actividadespeciaDetalle.js', CClientScript::POS_END
        );
        $InformacionPedidoActiEspecial = AprovacionDocumentos::model()->getInforActividadEspecial($agencia, $grupoVentas);
        $conteoActividadEspecial = count($InformacionPedidoActiEspecial);
        if ($conteoActividadEspecial > 0) {
            $this->render('aprovarActividadEspecialDetalle', array('InformacionPedidoActiEspecial' => $InformacionPedidoActiEspecial, 'agencia' => $agencia));
        } else {
            echo "<script language='javascript'>window.location.href='index.php?r=reportes/AprovacionDocumentos/AprobarActividadEspecial';</script>";
        }
    }

    public function actionAjaxDetalladoPedidoActividadEspecial() {
        if ($_POST) {
            $idPedido = $_POST['idPedido'];
            $agencia = $_POST['agencia'];
            $detallePedidoActiEspecial = AprovacionDocumentos::model()->getDetallePedidoActividadEspecial($idPedido, $agencia);
            $this->renderPartial('_detallepedidosactividadespecial', array('detallePedidoActiEspecial' => $detallePedidoActiEspecial, 'agencia' => $agencia));
        }
    }

    public function actionAjaxGuardaAprovacionPedidosActividadEspecial() {
        if ($_POST) {
            $id = $_POST['id'];
            $estado = $_POST['estado'];
            $agencia = $_POST['agencia'];
            $diasplazo = $_POST['diasplazo'];
            $zona = $_POST['zona'];
            $asesor = $_POST['asesor'];
            $cliente = $_POST['cliente'];
            $remitente = Yii::app()->user->getState('_cedula');
            $msgAuto = 'El pedido # ' . $id . ' con actividad especial para el cliente ' . $cliente . ' fue autorizado';
            $msgRecha = 'El pedido # ' . $id . ' con actividad especial para el cliente ' . $cliente . ' fue rechazado';
            foreach ($estado as $itemestado) {
                $itemestado;
            }
            if ($itemestado == 1) {
                $estadoPedidoActual = AprovacionDocumentos::model()->getEstadoPedidoActual($id, $agencia);
                if ($estadoPedidoActual == 2) {
                    $estadoPedidoNuevo = 1;
                    AprovacionDocumentos::model()->getUpdateEstadoPedidosActiEspecial($id, $agencia, $diasplazo, $estadoPedidoNuevo);
                    AprovacionDocumentos::model()->getInsertmensaje($zona, $remitente, $agencia, $msgAuto, $asesor);
                } else {
                    $estadoPedidoNuevo = 0;
                    AprovacionDocumentos::model()->getUpdateEstadoPedidosActiEspecial($id, $agencia, $diasplazo, $estadoPedidoNuevo);
                    AprovacionDocumentos::model()->InsertPedidosActiEspecialTransAx($id, $agencia);
                    AprovacionDocumentos::model()->getInsertmensaje($zona, $remitente, $agencia, $msgAuto, $asesor);
                }
            } else if ($itemestado == 0) {
                AprovacionDocumentos::model()->getUpdateEstadoPedidosActiEspecialRecha($id, $agencia);
                AprovacionDocumentos::model()->getInsertmensaje($zona, $remitente, $agencia, $msgRecha, $asesor);
            }
        }
    }

    public function actionAjaxDetalleDescuentos($agencia, $grupoVentas, $idPedido = '', $proveedor = '') {
        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/scripts/reportes/AprovacionDocumentos/descuentosDetalle.js', CClientScript::POS_END
        );
        $idPerfil = Yii::app()->user->_idPerfil;
        if ($idPerfil == 29) {
            $pedidosGrupoVentas = AprovacionDocumentos::model()->getPedidosGrupoVentasAdminCartera($agencia, $grupoVentas);
            $this->render('descuentosDetalle', array('pedidosGrupoVentas' => $pedidosGrupoVentas));
        } else {
            $PedidoExistente = "";
            $RegistroExistente = AprovacionDocumentos::model()->getConuntTransaccionesAx($idPedido, $agencia);
            if ($RegistroExistente[0]['existe'] > '0') {
                $PedidoExistente = '1';
                Yii::app()->user->setFlash('success', "Ya se ha gestionado el descuento para el pedido : <b>#" . $idPedido . '</b>');
            }
            $tipoUsuario = Yii::app()->user->_tipoUsuario;
            $cedulaUsuario = Yii::app()->user->_cedula;
            $cuentaProveedorAdministrador = AprovacionDocumentos::model()->getProveedorAdministrador($cedulaUsuario);
            $proveedor = $cuentaProveedorAdministrador['CodigoProveedor'];
            $pedidosGrupoVentasDetalle = AprovacionDocumentos::model()->getPedidosGrupoVentasDetalle($agencia, $grupoVentas, $tipoUsuario, $idPedido, $proveedor);
            $GestionoProducto = 0;
            foreach ($pedidosGrupoVentasDetalle as $itemDetalle) {
                $ProductoAprobado = AprovacionDocumentos::model()->getDetalleAprobado($itemDetalle['IdDescripcionPedido'], $itemDetalle['Agencia']);
                if ($ProductoAprobado['ProductoAprobado'] > 0) {
                    $GestionoProducto = '2';
                    Yii::app()->user->setFlash('success', "Ya usted ha gestionado el descuento para el pedido : <b>#" . $idPedido . '</b>');
                }
            }
            $pedidosGrupoVentas = AprovacionDocumentos::model()->getPedidosGrupoVentas($agencia, $grupoVentas, $tipoUsuario, $proveedor);
            $countpedidosGrupoVentas = count($pedidosGrupoVentas);
            // echo($countpedidosGrupoVentas);
            // die();
            if ($countpedidosGrupoVentas > 0) {
                $this->render('descuentosDetalle', array('pedidosGrupoVentas' => $pedidosGrupoVentas, 'idPedido' => $idPedido, 'CodAgencia' => $agencia, 'GrupoVentas' => $grupoVentas, 'PedidoExistente' => $PedidoExistente, 'GestionoProducto' => $GestionoProducto));
            } else {
                echo "<script language='javascript'>window.location.href='index.php?r=reportes/AprovacionDocumentos/Descuentos';</script>";
            }
        }
    }

    public function actionAjaxDetallePedido() {
        if ($_POST) {
            $agencia = $_POST['agencia'];
            $grupoVentas = $_POST['grupoVentas'];
            $idPedido = $_POST['idPedido'];
            $idPerfil = Yii::app()->user->_idPerfil;
            if ($idPerfil == 29) {
                $pedidosGrupoVentasDetalle = AprovacionDocumentos::model()->getPedidosGrupoVentasDetalleAdminCartera($agencia, $grupoVentas, $idPedido);
                echo $this->renderPartial('_detallePedido', array('pedidosGrupoVentasDetalle' => $pedidosGrupoVentasDetalle));
            } else {
                $tipoUsuario = Yii::app()->user->_tipoUsuario;
                $cedulaUsuario = Yii::app()->user->_cedula;
                $cuentaProveedorAdministrador = AprovacionDocumentos::model()->getProveedorAdministrador($cedulaUsuario);
                $proveedor = $cuentaProveedorAdministrador['CodigoProveedor'];
                $pedidosGrupoVentasDetalle = AprovacionDocumentos::model()->getPedidosGrupoVentasDetalle($agencia, $grupoVentas, $tipoUsuario, $idPedido, $proveedor);
                echo $this->renderPartial('_detallePedido', array('pedidosGrupoVentasDetalle' => $pedidosGrupoVentasDetalle));
            }
        }
    }

    public function actionAjaxGuardarPedido() {
        if ($_POST) {
            $idPedido = $_POST['idPedido'];
            $idDescripcionPedido = $_POST['idDescripcionPedido'];
            $descuentoAltipal = $_POST['descuentoAltipal'];
            $descuentoProveedor = $_POST['descuentoProveedor'];
            $cedulaUsuario = $_POST['cedulaUsuario'];
            $nombreusuario = $_POST['nombreusuario'];
            $agencia = $_POST['agencia'];
            $motivo = $_POST['motivo'];
            $actividadEspecial = $_POST['actividadespecial'];
            $valordinamica = $_POST['ValorDinamica'];
            $CodDinamica = $_POST['CodDinamica'];
            $tipoUsuario = Yii::app()->user->_tipoUsuario;
            $idPerfil = Yii::app()->user->_idPerfil;
            $estadoRechazo = $motivo ? '1' : '0';
            $fechaRegistro = date('Y-m-d');
            $horaRegistro = date('H:i:s');
            if ($idPerfil == 29) {
                $QuienAutorizaDscto = 4;
                $aprovacionInsert = AprovacionDocumentos::model()->insertAutorizacionPedidoAdminCartera($agencia, $tipoUsuario, $idPedido, $idDescripcionPedido, $QuienAutorizaDscto, $estadoRechazo, $motivo, $cedulaUsuario, $nombreusuario, $fechaRegistro, $horaRegistro);
                Yii::app()->user->setFlash('success', "Se ha gestionado el descuento para el pedido : <b>#" . $idPedido . '</b>');
                $consultarPedidos = AprovacionDocumentos::model()->pedidodosaprovados($idPedido, $agencia);
                foreach ($consultarPedidos as $consultarPedidos) {
                    $QuienAutorizaDscto = $consultarPedidos['QuienAutorizaDscto'];
                    $EstadoRevisadoAltipal = $consultarPedidos['EstadoRevisadoAltipal'];
                    $EstadoRechazoAltipal = $consultarPedidos['EstadoRechazoAltipal'];
                    if ($QuienAutorizaDscto == 4) {
                        if ($EstadoRevisadoAltipal > 0 && $EstadoRechazoAltipal == 0) {
                            AprovacionDocumentos::model()->UpdateEstadoPedidoDesEspecialAdminCartera($idPedido, $agencia, $estadoRechazo);
                            AprovacionDocumentos::model()->getUpdateSaldoDinamica($CodDinamica, $valordinamica, $agencia);
                            AprovacionDocumentos::model()->getUpdateDescripcionPedidoDinamca($idDescripcionPedido, $CodDinamica, $agencia);
                            $RegistroExistente = AprovacionDocumentos::model()->getConuntTransaccionesAx($idPedido, $agencia);
                            if ($RegistroExistente[0]['existe'] == 0) {
                                AprovacionDocumentos::model()->InsertTransAxDescuentoEspecial($idPedido, $agencia, $estadoRechazo);
                            }
                        }
                    }
                }
            } else {
                if ($descuentoAltipal > 0 && $descuentoProveedor > 0) {
                    $QuienAutorizaDscto = 3;
                } else if ($descuentoAltipal > 0) {
                    $QuienAutorizaDscto = 1;
                } else if ($descuentoProveedor > 0) {
                    $QuienAutorizaDscto = 2;
                }
                if ($actividadEspecial == 1) {
                    if ($descuentoAltipal > 0 && $descuentoProveedor > 0) {
                        $QuienAutorizaDscto = 3;
                    } else if ($descuentoAltipal > 0) {
                        $QuienAutorizaDscto = 1;
                    }
                    $aprovacionInsert = AprovacionDocumentos::model()->insertAutorizacionPedido($agencia, $tipoUsuario, $idPedido, $idDescripcionPedido, $QuienAutorizaDscto, $estadoRechazo, $motivo, $cedulaUsuario, $nombreusuario, $fechaRegistro, $horaRegistro);
                } else {
                    $aprovacionInsert = AprovacionDocumentos::model()->insertAutorizacionPedido($agencia, $tipoUsuario, $idPedido, $idDescripcionPedido, $QuienAutorizaDscto, $estadoRechazo, $motivo, $cedulaUsuario, $nombreusuario, $fechaRegistro, $horaRegistro);
                    if ($valordinamica != '') {
                        AprovacionDocumentos::model()->getUpdateSaldoDinamica($CodDinamica, $valordinamica, $agencia);
                        AprovacionDocumentos::model()->getUpdateDescripcionPedidoDinamca($idDescripcionPedido, $CodDinamica, $agencia);
                    }
                }
                Yii::app()->user->setFlash('success', "Se ha gestionado el descuento para el pedido : <b>#" . $idPedido . '</b>');
                $consultarPedidos = AprovacionDocumentos::model()->pedidodosaprovados($idPedido, $agencia);
                $AcumuladorPedidos = 0;
                $ConPedidoAltipal = AprovacionDocumentos::model()->getPedidosAltipal($idPedido, $agencia);
                $ConPedidoProveedor = AprovacionDocumentos::model()->getPedidosProveedor($idPedido, $agencia);
                $ConAprovacionPedido = AprovacionDocumentos::model()->getPedidosAprovados($idPedido, $agencia);
                $AcumuladorPedidos = $ConPedidoAltipal[0]['descripcionssinaprobarAltipal'] + $ConPedidoProveedor[0]['productosaenviarProveedor'];
                if ($QuienAutorizaDscto == 3) {
                    $ContPedidoCompartido = AprovacionDocumentos::model()->getPedidosCompartido($idPedido, $agencia);
                    $ConAprovacionPedido = AprovacionDocumentos::model()->getPedidosAprovadosCompartidos($idPedido, $agencia);
                    $AcumuladorPedidos = $ContPedidoCompartido['productosaenviarCompatidos'];
                }
                if ($AcumuladorPedidos == $ConAprovacionPedido[0]['productosaenviar']) {
                    foreach ($consultarPedidos as $consultarPedidos) {
                        $QuienAutorizaDscto = $consultarPedidos['QuienAutorizaDscto'];
                        $EstadoRevisadoAltipal = $consultarPedidos['EstadoRevisadoAltipal'];
                        $EstadoRevisadoProveedor = $consultarPedidos['EstadoRevisadoProveedor'];
                        $EstadoRechazoAltipal = $consultarPedidos['EstadoRechazoAltipal'];
                        $EstadoRechazoProveedor = $consultarPedidos['EstadoRechazoProveedor'];
                        if ($QuienAutorizaDscto == 3) {
                            if ($EstadoRevisadoAltipal > 0 && $EstadoRevisadoProveedor > 0) {
                                if ($actividadEspecial == 1) {
                                    AprovacionDocumentos::model()->getUpdateEstadoPedidoActividadEspecial($idPedido, $agencia, $estadoRechazo);
                                } else {
                                    AprovacionDocumentos::model()->UpdateEstadoPedidoDesEspecial($idPedido, $agencia, $estadoRechazo);
                                }
                            }
                        } else if ($QuienAutorizaDscto == 2) {
                            echo 'entre a autorizar 2' . '<br>';
                            if ($EstadoRevisadoProveedor > 0 && $EstadoRechazoProveedor == 0) {
                                if ($actividadEspecial == 1) {
                                    AprovacionDocumentos::model()->getUpdateEstadoPedidoActividadEspecial($idPedido, $agencia, $estadoRechazo);
                                } else {
                                    AprovacionDocumentos::model()->UpdateEstadoPedidoDesEspecial($idPedido, $agencia, $estadoRechazo);
                                }
                            }
                        } else if ($QuienAutorizaDscto == 1) {
                            if ($EstadoRevisadoAltipal > 0 && $EstadoRechazoAltipal == 0) {
                                if ($actividadEspecial == 1) {
                                    AprovacionDocumentos::model()->getUpdateEstadoPedidoActividadEspecial($idPedido, $agencia, $estadoRechazo);
                                } else {
                                    AprovacionDocumentos::model()->UpdateEstadoPedidoDesEspecial($idPedido, $agencia, $estadoRechazo);
                                }
                            }
                        }
                    }
                    if ($actividadEspecial != 1) {
                        $RegistroExistente = AprovacionDocumentos::model()->getConuntTransaccionesAx($idPedido, $agencia);
                        if ($RegistroExistente[0]['existe'] == 0) {
                            AprovacionDocumentos::model()->InsertTransAxDescuentoEspecial($idPedido, $agencia, $estadoRechazo);
                        }
                    }
                }
            }
        }
    }

    public function loadModel($id) {
        $model = Aprovacionpedido::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function actionAjaxDinamica() {
        if ($_POST) {
            $agencia = $_POST['agencia'];
            $coddinamica = $_POST['coddinamica'];
            $valoreDinamicas = AprovacionDocumentos::model()->getValoresDinamicas($agencia, $coddinamica);
            $Valores = array(
                'ValorDinamica' => $valoreDinamicas['ValorTotalDinamica'],
                'SaldoDinamica' => $valoreDinamicas['Saldo']
            );
            echo json_encode($Valores);
        }
    }

// Uncomment the following methods and override them if needed
    /*
      public function filters()
      {
      // return the filter configuration for this controller, e.g.:
      return array(
      'inlineFilterName',
      array(
      'class'=>'path.to.FilterClass',
      'propertyName'=>'propertyValue',
      ),
      );
      }

      public function actions()
      {
      // return external action classes, e.g.:
      return array(
      'action1'=>'path.to.ActionClass',
      'action2'=>array(
      'class'=>'path.to.AnotherActionClass',
      'propertyName'=>'propertyValue',
      ),
      );
      }
     */
}
