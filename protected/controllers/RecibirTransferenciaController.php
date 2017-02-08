<?php

class RecibirTransferenciaController extends Controller {

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
                //  'postOnly + delete', // we only allow deletion via POST request
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
            $actionAjax = $estedAction->getActions(ucfirst($controlador) . 'Controller', '');
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
        $arrayDiferentes = $estedAction->diffActions(ucfirst($controlador) . 'Controller', '', $arrayAction);
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

    public function actionIndex($zonaVentas) {
        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/recibirtranferecniaautoventa/recibirtranferecniaautoventa.js', CClientScript::POS_END
        );
        $this->render('index', array('zonaVentas' => $zonaVentas));
    }

    /*
     * se crea la funcion para cargar las transferencias para la zona de ventas
     * @parameters
     * @uses zona ventas
     */
    public function actionAjaxCargarTranferencias() {
        $zonaVentas = Yii::app()->user->getState('_zonaVentas');
        $Transferencias = Transferenciaautoventa::model()->getTransfereciasAutoventasSinAceptar($zonaVentas);
        $arrayTranferencia = array();
        $totalCantidad = 0;
        foreach ($Transferencias as $itemTrans) {
            $totalCantidad = $itemTrans['Cantidad'];
            $Aceptar = '<input type="button" value="Aceptar" class="btn btn-primary Aceptar" data-idTransferencia="' . $itemTrans['IdTransferenciaAutoventa'] . '" data-zona="' . $zonaVentas . '">';
            $json = array(
                'ZonaVentas' => $itemTrans['CodZonaVentas'],
                'FechaTransferenciaAutoventa' => $itemTrans['FechaTransferenciaAutoventa'],
                'HoraEnviado' => $itemTrans['HoraEnviado'],
                'Cantidad' => $totalCantidad,
                'Aceptar' => $Aceptar
            );
            array_push($arrayTranferencia, $json);
        }
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($arrayTranferencia),
            "iTotalDisplayRecords" => count($arrayTranferencia),
            "aaData" => $arrayTranferencia);
        echo json_encode($results);
    }

    /*
     * se crea la funcion para aceptar la transferencia
     * @parameters
     * @_POST id tranferencia
     * @_POTS zona
     */
    public function actionAjaxAceptarTransferencia() {
        if ($_POST) {
            $Id = $_POST['Id'];
            $zonaVentas = $_POST['zona'];
            $TranferenciaAutoventa = Transferenciaautoventa::model()->getTransferencias($Id);
            $Sitio = Transferenciaautoventa::model()->getSitios($zonaVentas);
            foreach ($TranferenciaAutoventa as $itemTransferencia) {
                $portafolio = Transferenciaautoventa::model()->getPortafolio($itemTransferencia['CodVariante']);
                $SaldoAutoventa = Transferenciaautoventa::model()->getSaldosAutoventa($itemTransferencia['CodigoUbicacionDestino'], $itemTransferencia['CodVariante'], $itemTransferencia['Lote']);
                if ($itemTransferencia['CodVariante'] == $SaldoAutoventa['CodigoVariante'] && $itemTransferencia['CodigoUbicacionDestino'] == $SaldoAutoventa['CodigoUbicacion'] && $SaldoAutoventa['LoteArticulo'] == $itemTransferencia['Lote']) {
                    $Saldo = $SaldoAutoventa['Disponible'] + $itemTransferencia['Cantidad'];
                    $UpdateTranferencia = Transferenciaautoventa::model()->UpdateTransFerencia($Id);
                    $UpdateSaldoAurtoventa = Transferenciaautoventa::model()->UpdateSaldo($itemTransferencia['CodigoUbicacionDestino'], $itemTransferencia['CodVariante'], $Saldo);
                    $UpdateMesjeEstado = Transferenciaautoventa::model()->UpdateMensaje($zonaVentas);
                } else {
                    $insertSaldoAutoventa = Transferenciaautoventa::model()->insertSaldoAutoventa($Sitio['CodigoSitio'], $Sitio['Nombre'], $Sitio['CodigoAlmacen'], $Sitio['CodigoUbicacion'], $itemTransferencia['CodVariante'], $itemTransferencia['CodigoArticulo'], $portafolio['CodigoCaracteristica1'], $portafolio['CodigoCaracteristica2'], $itemTransferencia['Lote'], $portafolio['CodigoTipo'], $itemTransferencia['CodigoUnidadMedida'], $itemTransferencia['NombreUnidadMedida'], $itemTransferencia['Cantidad']);
                    $UpdateTranferencia = Transferenciaautoventa::model()->UpdateTransFerencia($Id);
                    $UpdateMesjeEstado = Transferenciaautoventa::model()->UpdateMensaje($zonaVentas);
                }
            }
        }
    }

}
