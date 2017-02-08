<?php

class RuteroController extends Controller {

    public function actionIndex() {
        $this->render('index');
    }

    public function actionMenu() {

        if (!isset($_GET["Zona"])) {
            $zonaVentas = Yii::app()->user->getState('_zonaVentas');
            $zonaVentas = Yii::app()->user->getState('_zonaVentas');
            $PedientesPorFacturar = Consultas::model()->getPendientesPorFacturar($zonaVentas);

            if (count($PedientesPorFacturar) > 0) {
                $this->render('pendientesporfacturar', array('PedientesPorFacturar' => $PedientesPorFacturar));
            } else {
                Yii::app()->user->setFlash('Error', "La zona de ventas no tiene pendientes por facturar");
                $this->render('index');
            }
        } else {
            $this->layout = "mainapp";
            $zona = $_GET["Zona"];
            Yii::app()->clientScript->registerScriptFile(
                    Yii::app()->baseUrl . '/js/rutero/dimensiones.js', CClientScript::POS_END
            );
            Yii::app()->user->setState('_zonaVentas', $zona);
            $zonaVentas = Yii::app()->user->getState('_zonaVentas');
            $PedientesPorFacturar = Consultas::model()->getPendientesPorFacturar($zonaVentas);

            if (count($PedientesPorFacturar) > 0) {
                $this->render('pendientesporfacturarapp', array('PedientesPorFacturar' => $PedientesPorFacturar, 'zoaventas' => $zona));
            } else {
                Yii::app()->user->setFlash('Error', "La zona de ventas no tiene pendientes por facturar");
                $this->render('index');
            }
        }
    }

    /*
     * se crea la funcion para ver la dimensiones de la zona de ventas
     * @parameters
     * @uses zonaVentas
     */

    public function actionDimensionesCumplimiento() {

        if (isset($_GET["Zona"])) {
            $this->layout = "mainapp";
            Yii::app()->clientScript->registerScriptFile(
                    Yii::app()->baseUrl . '/js/rutero/dimensiones.js', CClientScript::POS_END
            );
            $zona = $_GET["Zona"];
            Yii::app()->user->setState('_zonaVentas', $zona);
            $zonaVentas = Yii::app()->user->getState('_zonaVentas');

            $PresupuestoZona = Consultas::model()->getPresupuestoZona($zonaVentas);

            $this->render('Dimensiones', array('PresupuestoZona' => $PresupuestoZona));
        } else {

            Yii::app()->clientScript->registerScriptFile(
                    Yii::app()->baseUrl . '/js/rutero/dimensiones.js', CClientScript::POS_END
            );

            $zonaVentas = Yii::app()->user->getState('_zonaVentas');

            $PresupuestoZona = Consultas::model()->getPresupuestoZona($zonaVentas);

            $this->render('Dimensiones', array('PresupuestoZona' => $PresupuestoZona));
        }
    }

    public function actionAjaxGetFilterClientes() {
        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/rutero/dimensiones.js', CClientScript::POS_END
        );
        $zonaventas = $_POST["zonaVentas"];
        $textFilter = $_POST["filterBuscarCliente"];
        $identificadorBusqueda = $_POST['identificadorBusqueda'];
        if ($identificadorBusqueda == "find") {
            $PedientesPorFacturar = Consultas::model()->getPendientesPorFacturarFilter($zonaventas, $textFilter);
        }else{
             $PedientesPorFacturar = Consultas::model()->getPendientesPorFacturar($zonaventas);
        }
        echo $this->renderPartial('_tablePendientesporfacturarapp', array('PedientesPorFacturar' => $PedientesPorFacturar));
    }

}
