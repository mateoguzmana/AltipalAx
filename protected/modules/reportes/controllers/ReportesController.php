<?php

class ReportesController extends Controller {

    private $modulo = "reportes";

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
        $Criteria->condition = "Cedula = $cedula";

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

    public function obtenerCanales() {
        return Consultas::model()->getCanales();
    }

    public function actionMenu() {
        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/scripts/reportes/Reportes/Menu.js', CClientScript::POS_END
        );

        $this->render('menu');
    }

    public function actionAcumuladoMes() {

        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/scripts/reportes/Reportes/ReportesMes.js', CClientScript::POS_END
        );

        $TotalCobertura = ReporteMes::model()->getTotalCoberturaMes();
        $TotalClientesCobertura = ReporteMes::model()->getTotalesClientesCoberturaMes();
        $TotalVolumen = ReporteMes::model()->getTotalVolumenMes();
        $TotalPedidosDiaMes = ReporteMes::model()->getTotalesPedidosDiaMes();
        $TotalFectividad = ReporteMes::model()->getEfectividadMes();
        $fechasPedidos = ReporteMes::model()->FechaPedidos();
        $PedidosMesCanal = ReporteMes::model()->getPedidosMesCanal();
        $TotalValorAgenciaPedido = ReporteMes::model()->getPedidosValorMes();
        $TotalEjecutadoVolumen = ReporteMes::model()->getTotalVolumenEjecutadoMes();
        $TotalEjecutadoCobertura = ReporteMes::model()->getTotalesClientesCoberturaMesEjecutado();


        $arrayCanales = array();
        foreach ($PedidosMesCanal as $item) {
            array_push($arrayCanales, $item['NombreCanal']);
        }
        $arrayCanalesUni = array_unique($arrayCanales);

        $ArrayCanalesCompletos = array();

        foreach ($arrayCanalesUni as $Canales) {
            $CodCanales = 0;
            $NombreCanal = "";
            $ValorPedidoCanal = "";
            foreach ($PedidosMesCanal as $item) {
                if ($Canales == $item['NombreCanal']) {
                    $ValorPedidoCanal+=$item['ValorPedidoCanal'];
                    $NombreCanal = $item['NombreCanal'];
                    $CodCanales = $item['CodigoCanal'];
                }
            }
            array_push($ArrayCanalesCompletos, array('ValorPedidoCanal' => $ValorPedidoCanal, 'CodCanal' => $CodCanales, 'NombreCanal' => $NombreCanal));
        }



        foreach ($fechasPedidos as $key => $itemFecha) {
            $FechaUnicas[$itemFecha['FechaPedido']] = $itemFecha['FechaPedido'];
        }


        foreach ($TotalClientesCobertura as $itemCliente) {
            $ClientesCobertura = $ClientesCobertura + $itemCliente['PedidosMesActual'];
        }

        foreach ($TotalPedidosDiaMes as $ItemPedidos) {
            $PedidosDia = $PedidosDia + $ItemPedidos['TotalPedidos'];
        }

        foreach ($TotalFectividad as $itemEfectivida) {
            $EfectividadPresupuesto = $itemEfectivida['EfectividadPresupuestada'];
            $EfectividadTotal = $itemEfectivida['EfectividadTotal'];
        }


        $GraficaDias[0]['PedidosMesActual'] = 0;
        $GraficaDias[0]['TotalPedidoMensual'] = 0;
        $GraficaDias[1]['PedidosMesActual'] = 0;
        $GraficaDias[1]['TotalPedidoMensual'] = 0;
        $GraficaDias[2]['PedidosMesActual'] = 0;
        $GraficaDias[2]['TotalPedidoMensual'] = 0;
        $GraficaDias[3]['PedidosMesActual'] = 0;
        $GraficaDias[3]['TotalPedidoMensual'] = 0;
        $GraficaDias[4]['PedidosMesActual'] = 0;
        $GraficaDias[4]['TotalPedidoMensual'] = 0;
        $GraficaDias[5]['PedidosMesActual'] = 0;
        $GraficaDias[5]['TotalPedidoMensual'] = 0;
        $GraficaDias[6]['PedidosMesActual'] = 0;
        $GraficaDias[6]['TotalPedidoMensual'] = 0;

        foreach ($FechaUnicas as $ItemFecha) {


            $PedidosMes = ReporteMes::model()->PedidosMes($ItemFecha);
            $fechats = strtotime($ItemFecha);
            $ValorParcial = 0;
            $cantidadParcial = 0;
            foreach ($PedidosMes as $keyPedido => $itemValoresPedidos) {
                $ValorParcial += $itemValoresPedidos['TotalPedidoMensual'];
                $cantidadParcial += $itemValoresPedidos['PedidosMesActual'];
            }

            switch (date('w', $fechats)) {
                case 0:

                    $GraficaDias[0]['Dia'] = "Domingo";
                    $GraficaDias[0]['PedidosMesActual'] += $cantidadParcial;
                    $GraficaDias[0]['TotalPedidoMensual'] += $ValorParcial;
                    break;
                case 1:
                    $GraficaDias[1]['Dia'] = "Lunes";
                    $GraficaDias[1]['PedidosMesActual'] += $cantidadParcial;
                    $GraficaDias[1]['TotalPedidoMensual'] += $ValorParcial;
                    break;
                case 2:

                    $GraficaDias[2]['Dia'] = "Martes";
                    $GraficaDias[2]['PedidosMesActual'] += $cantidadParcial;
                    $GraficaDias[2]['TotalPedidoMensual'] += $ValorParcial;
                    break;
                case 3:

                    $GraficaDias[3]['Dia'] = "Miercoles";
                    $GraficaDias[3]['PedidosMesActual'] += $cantidadParcial;
                    $GraficaDias[3]['TotalPedidoMensual'] += $ValorParcial;
                    break;
                case 4:

                    $GraficaDias[4]['Dia'] = "Jueves";
                    $GraficaDias[4]['PedidosMesActual'] += $cantidadParcial;
                    $GraficaDias[4]['TotalPedidoMensual'] += $ValorParcial;
                    break;
                case 5:

                    $GraficaDias[5]['Dia'] = "Viernes";
                    $GraficaDias[5]['PedidosMesActual'] += $cantidadParcial;
                    $GraficaDias[5]['TotalPedidoMensual'] += $ValorParcial;
                    break;
                case 6:

                    $GraficaDias[6]['Dia'] = "Sabado";
                    $GraficaDias[6]['PedidosMesActual'] += $cantidadParcial;
                    $GraficaDias[6]['TotalPedidoMensual'] += $ValorParcial;
                    break;
            }
        }

        foreach ($PedidosMes as $itemPedidomes) {
            $TotalPedidos = $TotalPedidos + $itemPedidomes['PedidosMesActual'];
            $TotalValorPedidos = $TotalValorPedidos + $itemPedidomes['TotalPedidoMensual'];
        }


        $this->render('AcumuladoMes', array('TotalCobertura' => $TotalCobertura, 'ClientesCobertura' => $ClientesCobertura, 'TotalVolumen' => $TotalVolumen, 'TotalPedidosDiaMes' => $PedidosDia, 'EfectividadPresupuesto' => $EfectividadPresupuesto, 'EfectividadTotal' => $EfectividadTotal, 'GraficaDias' => $GraficaDias, 'PedidosMesCanal' => $ArrayCanalesCompletos, 'TotalValorAgenciaPedido' => $TotalValorAgenciaPedido['Valor'], 'TotalEjecutadoVolumen' => $TotalEjecutadoVolumen['EjecutadoVolumen'], 'TotalEjecutadoCobertura' => $TotalEjecutadoCobertura['EjecutadoCobertura']));
    }

    public function actionAjaxCargarVentasCanaldia() {

        if ($_POST) {

            $dia = $_POST['dia'];

            $Canales = ReporteMes::model()->Canales();
            $PedidosMesDia = ReporteMes::model()->PedidosMesDia();
            $dias = array('Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo');

            $arrayCanales = array();
            foreach ($Canales as $item) {
                array_push($arrayCanales, $item['NombreCanal']);
            }
            $arrayCanalesUni = array_unique($arrayCanales);

            //echo '<pre>';
            //print_r($arrayCanalesUni);

            $ArrayCanalesCompletos = array();

            foreach ($arrayCanalesUni as $Canales) {
                $CodCanales = 0;
                $NombreCanal = "";
                $ValorPedidoCanal = "";
                foreach ($PedidosMesDia as $item) {
                    if ($Canales == $item['NombreCanal']) {

                        $fecha = $dias[date('N', strtotime($item['FechaPedido'])) - 1];

                        if ($dia == $fecha) {

                            $ValorPedidoCanal+=$item['ValorPedidoCanal'];
                            $NombreCanal = $item['NombreCanal'];
                            $CodCanales = $item['CodigoCanal'];
                        }
                    }
                }
                array_push($ArrayCanalesCompletos, array('ValorPedidoCanal' => $ValorPedidoCanal, 'CodCanal' => $CodCanales, 'NombreCanal' => $NombreCanal));
            }



            $this->renderPartial('PedidosDiaCanal', array('PedidosDiaCanal' => $ArrayCanalesCompletos));
            //echo '<pre>';
            //print_r($ArrayCanalesCompletos);
        }
    }

    public function actionAcumuladoDiario() {

        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/scripts/reportes/Reportes/ReporteAcumuladoDia.js', CClientScript::POS_END
        );
        $cedula = Yii::app()->getUser()->getState('_cedula');

        $Agencias = ReporteAcumuladoDia::model()->getAgencias($cedula);
        $totales = Resportes::model()->getSumaByCountpedidos();
        $totalesrecaudos = Resportes::model()->getSumaByCountrecaudos();
        $totalclientes = Resportes::model()->getCountCliente();
        $PedidosDiarioCanal = ReporteAcumuladoDia::model()->getPedidosDiarioCanal();

        $arrayCanales = array();
        foreach ($PedidosDiarioCanal as $item) {
            array_push($arrayCanales, $item['NombreCanal']);
        }
        $arrayCanalesUni = array_unique($arrayCanales);

        $ArrayCanalesCompletos = array();

        foreach ($arrayCanalesUni as $Canales) {
            $CodCanales = 0;
            $NombreCanal = "";
            $ClientesCanal = "";
            foreach ($PedidosDiarioCanal as $item) {
                if ($Canales == $item['NombreCanal']) {
                    $ClientesCanal+=$item['ClientesCanal'];
                    $NombreCanal = $item['NombreCanal'];
                    $CodCanales = $item['CodigoCanal'];
                }
            }
            array_push($ArrayCanalesCompletos, array('ClientesCanal' => $ClientesCanal, 'CodCanal' => $CodCanales, 'NombreCanal' => $NombreCanal));
        }

        $this->render('AcumuladoDia', array(
            'totales' => $totales,
            'totalesrecaudos' => $totalesrecaudos,
            'totalclientes' => $totalclientes,
            'Agencias' => $Agencias,
            'Efectividad' => $ArrayCanalesCompletos
        ));
    }

    public function actionAjaxCargarGruposVentas() {

        if ($_POST) {

            $Agencia = $_POST['agencia'];

            $aghtml = '';


            $Ag = ReporteAcumuladoDia::model()->getGruposVentaxAgecnia($Agencia);

            $aghtml.=' <select id="selectchosegrupventas2" name="GruposVentas" class="form-control chosen-select" data-placeholder="Seleccione un grupo ventas"> <option value=""></option>';
            foreach ($Ag as $itemGruVentas) {

                $aghtml.='
                     
                     <option  value="' . $itemGruVentas['codigoGrupo'] . '">' . $itemGruVentas['NombreGrupoVentas'] . '</option>
                      ';
            }

            $aghtml.='</select>';

            echo $aghtml;
        }
    }

    public function actionAjaxCargarZonasVentas() {


        if ($_POST) {

            $GrupoVentas = $_POST['grupoventa'];
            $agencia = $_POST['agencia'];

            $gruhtml = '';


            $Gru = ReporteAcumuladoDia::model()->getZonasVentasXGruposNombre($GrupoVentas, $agencia);

            $gruhtml.=' <select id="selectchosezonaventas2" name="ZonaVentas" class="form-control chosen-select" data-placeholder="Seleccione una zona venta"> <option value=""></option>';
            foreach ($Gru as $itemZonVentas) {

                $gruhtml.='<option  value="' . $itemZonVentas['CodZonaVentas'] . '">' . $itemZonVentas['CodZonaVentas'] . ' - ' . $itemZonVentas['Nombre'] . ' </option>';
            }

            $gruhtml.='</select>';

            echo $gruhtml;
        }
    }

    public function actionAjaxCargarGraficaZonasVentas() {

        if ($_POST) {

            $zona = $_POST['zona'];
            $fecha = $_POST['fecha'];
            $agencia = $_POST['agencia'];

            $reportexzona = ReporteAcumuladoDia::model()->getCargaGraficaPorZonaVentasPedidos($zona, $fecha, $agencia);
            $reportexzonarecaudos = ReporteAcumuladoDia::model()->getCargaGraficaPorZonaVentasRecuados($zona, $fecha, $agencia);
            $reportexzonaclientesnuevo = ReporteAcumuladoDia::model()->getCargaGraficaPorZonaVentasClientesNuevos($zona, $fecha, $agencia);
            $PedidosDiarioCanalzonaVentas = ReporteAcumuladoDia::model()->getPedidosDiarioCanalZona($zona, $fecha, $agencia);

            $arrayCanales = array();
            foreach ($PedidosDiarioCanalzonaVentas as $item) {
                array_push($arrayCanales, $item['NombreCanal']);
            }
            $arrayCanalesUni = array_unique($arrayCanales);

            $ArrayCanalesCompletos = array();

            foreach ($arrayCanalesUni as $Canales) {
                $CodCanales = 0;
                $NombreCanal = "";
                $ClientesCanal = "";
                foreach ($PedidosDiarioCanalzonaVentas as $item) {
                    if ($Canales == $item['NombreCanal']) {
                        $ClientesCanal+=$item['ClientesCanal'];
                        $NombreCanal = $item['NombreCanal'];
                        $CodCanales = $item['CodigoCanal'];
                    }
                }
                array_push($ArrayCanalesCompletos, array('ClientesCanal' => $ClientesCanal, 'CodCanal' => $CodCanales, 'NombreCanal' => $NombreCanal));
            }


            $this->renderPartial('_RAcumuladoDiaxZonaVentas', array(
                'reportexzona' => $reportexzona,
                'reportexzonarecaudos' => $reportexzonarecaudos,
                'reportexzonaclientesnuevo' => $reportexzonaclientesnuevo,
                'reportexzonaefectividad' => $ArrayCanalesCompletos,
                'zona' => $zona
            ));
        }
    }

    public function actionAjaxCargarGraficaFecha() {

        if ($_POST) {

            $fecha = $_POST['fecha'];
            $agencia = $_POST['agencia'];

            $reportexfechapedido = ReporteAcumuladoDia::model()->getCargaGraficaPorFechaPedidos($fecha, $agencia);
            $reportexfecharecaudo = ReporteAcumuladoDia::model()->getCargaGraficaPorFechaRecaudo($fecha, $agencia);
            $reportexfechaclientenuevos = ReporteAcumuladoDia::model()->getCargaGraficaPorFechaClientesNuevos($fecha, $agencia);
            $PedidosDiarioCanalFecha = ReporteAcumuladoDia::model()->getPedidosDiarioCanalAgencia($fecha, $agencia);

            $arrayCanales = array();
            foreach ($PedidosDiarioCanalFecha as $item) {
                array_push($arrayCanales, $item['NombreCanal']);
            }
            $arrayCanalesUni = array_unique($arrayCanales);

            $ArrayCanalesCompletos = array();

            foreach ($arrayCanalesUni as $Canales) {
                $CodCanales = 0;
                $NombreCanal = "";
                $ClientesCanal = "";
                foreach ($PedidosDiarioCanalFecha as $item) {
                    if ($Canales == $item['NombreCanal']) {
                        $ClientesCanal+=$item['ClientesCanal'];
                        $NombreCanal = $item['NombreCanal'];
                        $CodCanales = $item['CodigoCanal'];
                    }
                }
                array_push($ArrayCanalesCompletos, array('ClientesCanal' => $ClientesCanal, 'CodCanal' => $CodCanales, 'NombreCanal' => $NombreCanal));
            }

            $this->renderPartial('_RAcumuladoDiaxDias', array(
                'reportexfechapedido' => $reportexfechapedido,
                'reportexfecharecaudo' => $reportexfecharecaudo,
                'reportexfechaclientenuevos' => $reportexfechaclientenuevos,
                'reportexafechaefectividad' => $ArrayCanalesCompletos,
                'Agencia' => $agencia
            ));
        }
    }

    public function actionAjaxCargarGraficaGrupoVenta() {

        if ($_POST) {

            $fecha = $_POST['fecha'];
            $grupo = $_POST['grupo'];
            $agencia = $_POST['agencia'];

            $reportexgrupoventapedido = ReporteAcumuladoDia::model()->getCargarGraficaPorGrupoVentasPedidos($grupo, $fecha, $agencia);
            $reportexgrupoventarecaudos = ReporteAcumuladoDia::model()->getCargarGraficaPorGrupoVentasRecaudos($grupo, $fecha, $agencia);
            $reportexgrupoventaclientesnuevos = ReporteAcumuladoDia::model()->getCargarGraficaPorGrupoVentasClientesNuevos($grupo, $fecha, $agencia);
            $PedidosDiarioCanalGrupoVentas = ReporteAcumuladoDia::model()->getPedidosDiarioCanalGrupo($grupo, $fecha, $agencia);

            $arrayCanales = array();
            foreach ($PedidosDiarioCanalGrupoVentas as $item) {
                array_push($arrayCanales, $item['NombreCanal']);
            }
            $arrayCanalesUni = array_unique($arrayCanales);

            $ArrayCanalesCompletos = array();

            foreach ($arrayCanalesUni as $Canales) {
                $CodCanales = 0;
                $NombreCanal = "";
                $ClientesCanal = "";
                foreach ($PedidosDiarioCanalGrupoVentas as $item) {
                    if ($Canales == $item['NombreCanal']) {
                        $ClientesCanal+=$item['ClientesCanal'];
                        $NombreCanal = $item['NombreCanal'];
                        $CodCanales = $item['CodigoCanal'];
                    }
                }
                array_push($ArrayCanalesCompletos, array('ClientesCanal' => $ClientesCanal, 'CodCanal' => $CodCanales, 'NombreCanal' => $NombreCanal));
            }


            $this->renderPartial('_RAcumuladoDiaxGrupVen', array(
                'reportexgrupoventapedido' => $reportexgrupoventapedido,
                'reportexgrupoventarecaudos' => $reportexgrupoventarecaudos,
                'reportexgrupoventaclientesnuevos' => $reportexgrupoventaclientesnuevos,
                'reportexgrupoventaefectividad' => $ArrayCanalesCompletos,
                'Agencia' => $agencia
            ));
        }
    }

    public function actionAjaxCargarGraficaAgencia() {

        if ($_POST) {

            $fecha = $_POST['fecha'];
            $gencia = $_POST['agencia'];

            $reportexagenciapedido = ReporteAcumuladoDia::model()->getCargarGraficaAgenciaPedidos($gencia, $fecha);
            $reportexagenciarecaudos = ReporteAcumuladoDia::model()->getCargarGraficaAgenciaRecaudos($gencia, $fecha);
            $reportexagenciaclientesnuevo = ReporteAcumuladoDia::model()->getCargarGraficaAgenciaClienteNuevo($gencia, $fecha);
            $PedidosDiarioCanalAgencia = ReporteAcumuladoDia::model()->getPedidosDiarioCanalAgencia($gencia);

            $arrayCanales = array();
            foreach ($PedidosDiarioCanalAgencia as $item) {
                array_push($arrayCanales, $item['NombreCanal']);
            }
            $arrayCanalesUni = array_unique($arrayCanales);

            $ArrayCanalesCompletos = array();

            foreach ($arrayCanalesUni as $Canales) {
                $CodCanales = 0;
                $NombreCanal = "";
                $ClientesCanal = "";
                foreach ($PedidosDiarioCanalAgencia as $item) {
                    if ($Canales == $item['NombreCanal']) {
                        $ClientesCanal+=$item['ClientesCanal'];
                        $NombreCanal = $item['NombreCanal'];
                        $CodCanales = $item['CodigoCanal'];
                    }
                }
                array_push($ArrayCanalesCompletos, array('ClientesCanal' => $ClientesCanal, 'CodCanal' => $CodCanales, 'NombreCanal' => $NombreCanal));
            }



            $this->renderPartial('_RAcumuladoDiaxAgencia', array(
                'reportexagenciapedido' => $reportexagenciapedido,
                'reportexagenciarecaudos' => $reportexagenciarecaudos,
                'reportexagenciaclientesnuevo' => $reportexagenciaclientesnuevo,
                'reportexagenciaefectividad' => $ArrayCanalesCompletos,
                'Agencia' => $gencia
            ));
        }
    }

    public function actionVentas() {


        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/scripts/reportes/Reportes/ReporteVentas.js', CClientScript::POS_END
        );

        $cedula = Yii::app()->getUser()->getState('_cedula');

        $AgenciasVentas = ReporteVentas::model()->getAgencias($cedula);
        $compradores = ReporteVentas::model()->getCompradores();
        $productosvendidos = ReporteVentas::model()->getProductosVendidos();
        $ventasproveedor = ReporteVentas::model()->getVentasProveedor();


        $this->render('Ventas', array(
            'compradores' => $compradores,
            'productosvendidos' => $productosvendidos,
            'ventasproveedor' => $ventasproveedor,
            'AgenciasVentas' => $AgenciasVentas
        ));
    }

    public function actionAjaxCargarGraficaVentasZonasVentas() {


        if ($_POST) {

            $zona = $_POST['zona'];
            $fecha = $_POST['fecha'];

            $reporteventasxzona = ReporteVentas::model()->getCargaGraficaPorZonaVentasCompradores($zona, $fecha);
            $reportexzonaproductosvendidos = ReporteVentas::model()->getCargaGraficaPorZonaVentasProductosVendidos($zona, $fecha);
            $reportexzonaventasproveedor = ReporteVentas::model()->getCargaGraficaPorZonaVentasProveedorxVentas($zona, $fecha);

            $this->renderPartial('_RVentasxZovaVentas', array(
                'reporteventasxzona' => $reporteventasxzona,
                'reportexzonaproductosvendidos' => $reportexzonaproductosvendidos,
                'reportexzonaventasproveedor' => $reportexzonaventasproveedor
            ));
        }
    }

    public function actionAjaxCargarGraficaVentasFecha() {


        if ($_POST) {


            $fecha = $_POST['fecha'];
            $agencia = $_POST['agencia'];

            $reporteventasxfecha = ReporteVentas::model()->getCargaGraficaPorFechaCompradores($fecha, $agencia);
            $reportexfechaproductosvendidos = ReporteVentas::model()->getCargaGraficaPorFechaVentasProductosVendidos($fecha, $agencia);
            $reportexfechaventasproveedor = ReporteVentas::model()->getCargaGraficaPorFechaVentasProveedorxVentas($fecha, $agencia);

            $this->renderPartial('_RVentasxFecha', array(
                'reporteventasxfecha' => $reporteventasxfecha,
                'reportexfechaproductosvendidos' => $reportexfechaproductosvendidos,
                'reportexfechaventasproveedor' => $reportexfechaventasproveedor
            ));
        }
    }

    public function actionAjaxCargarGraficaVentasGrupoVenta() {

        if ($_POST) {

            $fecha = $_POST['fecha'];
            $grupo = $_POST['grupo'];
            $gencia = $_POST['agencia'];

            $reportexgrupoventacomprador = ReporteVentas::model()->getCargarGraficaPorGrupoVentasCompradores($grupo, $fecha, $gencia);
            $reportexgrupoventaproductovendidos = ReporteVentas::model()->getCargarGraficaPorGrupoVentasProductosVendidos($grupo, $fecha, $gencia);
            $reportexgrupoventaventasXproveedor = ReporteVentas::model()->getCargarGraficaPorGrupoVentasProveedorXVentas($grupo, $fecha, $gencia);
            $this->renderPartial('_RVentasxGrupoVentas', array(
                'reportexgrupoventacomprador' => $reportexgrupoventacomprador,
                'reportexgrupoventaproductovendidos' => $reportexgrupoventaproductovendidos,
                'reportexgrupoventaventasXproveedor' => $reportexgrupoventaventasXproveedor
            ));
        }
    }

    public function actionAjaxCargarGraficaVentasAgencia() {

        if ($_POST) {

            $fecha = $_POST['fecha'];
            $gencia = $_POST['agencia'];

            $reportexagenciacompradores = ReporteVentas::model()->getCargarGraficaAgenciaCompradores($gencia, $fecha);
            $reportexagenciaproductosvendidos = ReporteVentas::model()->getCargarGraficaAgenciaProductosVendidos($gencia, $fecha);
            $reportexagenciaventasxproveedor = ReporteVentas::model()->getCargarGraficaAgenciaVentasXProveedor($gencia, $fecha);
            $this->renderPartial('_RVentasxAgencia', array(
                'reportexagenciacompradores' => $reportexagenciacompradores,
                'reportexagenciaproductosvendidos' => $reportexagenciaproductosvendidos,
                'reportexagenciaventasxproveedor' => $reportexagenciaventasxproveedor
            ));
        }
    }

    public function actionAjaxCargarProveedor() {


        if ($_POST) {

            $ZonaVentas = $_POST['zonaventas'];
            $agencia = $_POST['agencia'];

            $proveehtml = '';


            $Prove = ReporteAcumuladoDia::model()->getProveedoresXZonaVentas($ZonaVentas, $agencia);

            $proveehtml.=' <select id="selectchoseproveedor2" name="Proveedor" class="form-control chosen-select" data-placeholder="Seleccione un proveedor"> <option value=""></option>';
            foreach ($Prove as $itemProveedor) {

                $proveehtml.='
                     
                     <option  value="' . $itemProveedor['CodigoCuentaProveedor'] . '">' . $itemProveedor['NombreCuentaProveedor'] . '</option>
                      ';
            }

            $proveehtml.='</select>';

            echo $proveehtml;
        }
    }

    public function actionAjaxCargarGraficaVentasProveedor() {

        if ($_POST) {

            $fecha = $_POST['fecha'];
            $proveedor = $_POST['proveedor'];

            $reportexproveedorcompradores = ReporteVentas::model()->getCargarGraficaProveedorCompradores($proveedor, $fecha);
            $reportexproveedorproductosvendidos = ReporteVentas::model()->getCargarGraficaProveedorProductosVendidos($proveedor, $fecha);
            $reportexproveedorventasxproveedor = ReporteVentas::model()->getCargarGraficaProveedorVentasXProveedor($proveedor, $fecha);
            $this->renderPartial('_RVentasxProveedor', array(
                'reportexproveedorcompradores' => $reportexproveedorcompradores,
                'reportexproveedorproductosvendidos' => $reportexproveedorproductosvendidos,
                'reportexproveedorventasxproveedor' => $reportexproveedorventasxproveedor
            ));
        }
    }

    public function actionAjaxCargarGraficaVentasCanal() {

        if ($_POST) {

            $fecha = $_POST['fecha'];
            $canal = $_POST['canal'];
            $agencia = $_POST['agencia'];


            $reportexClientesCompradoresxCanal = ReporteVentas::model()->getGraficaCompradoresxCanal($fecha, $canal, $agencia);
            $reportexClientesxProductosVendidosxCanal = ReporteVentas::model()->getProductosVendidosXCanal($fecha, $canal, $agencia);
            $reportexClientesxVantasPorProveedorXCanal = ReporteVentas::model()->getGraficaVantasPorProveedorXCanal($fecha, $canal, $agencia);
            $this->renderPartial('_RVentasxCanal', array(
                'reportexClientesCompradoresxCanal' => $reportexClientesCompradoresxCanal,
                'reportexClientesxProductosVendidosxCanal' => $reportexClientesxProductosVendidosxCanal,
                'reportexClientesxVantasPorProveedorXCanal' => $reportexClientesxVantasPorProveedorXCanal
            ));
        }
    }

    public function actionClientes() {


        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/scripts/reportes/Reportes/ReporteClientes.js', CClientScript::POS_END
        );

        $cedula = Yii::app()->getUser()->getState('_cedula');

        $Agencias = ReporteClientes::model()->getAgencias($cedula);
        $clientescarteravenciada = ReporteClientes::model()->getGraficaClientes();
        $noventas = ReporteClientes::model()->getGraficaNoVentas();
        $notascredito = ReporteClientes::model()->getGraficaNotasCredito();

        $this->render('Clientes', array(
            'clientescarteravenciada' => $clientescarteravenciada,
            'noventas' => $noventas,
            'notascredito' => $notascredito,
            'Agencias' => $Agencias
        ));
    }

    public function actionAjaxCargarGraficaClientesXZonasVentas() {

        if ($_POST) {


            $zonaVentas = $_POST['zona'];
            $fecha = $_POST['fecha'];
            $agencia = $_POST['agencia'];

            $reportexClientesNotaCreditoxZona = ReporteClientes::model()->getGraficaNotasCreditoxZona($fecha, $zonaVentas, $agencia);
            $reportexClientesxNoventasxZona = ReporteClientes::model()->getGraficaNoVentasXZona($fecha, $zonaVentas, $agencia);
            $reportexClientesxCarteraVencidaXZona = ReporteClientes::model()->getGraficaclientesCarteraVenciadaXZona($fecha, $zonaVentas, $agencia);
            $this->renderPartial('_RClientesxZonaVentas', array(
                'reportexClientesNotaCreditoxZona' => $reportexClientesNotaCreditoxZona,
                'reportexClientesxNoventasxZona' => $reportexClientesxNoventasxZona,
                'reportexClientesxCarteraVencidaXZona' => $reportexClientesxCarteraVencidaXZona
            ));
        }
    }

    public function actionAjaxCargarGraficaClientesXGruposVentas() {

        if ($_POST) {


            $grupo = $_POST['grupo'];
            $fecha = $_POST['fecha'];
            $agencia = $_POST['agencia'];

            $reportexClientesNotaCreditoxGrupo = ReporteClientes::model()->getGraficaNotasCreditoxGrupo($fecha, $grupo, $agencia);
            $reportexClientesxNoventasxGrupo = ReporteClientes::model()->getGraficaNoVentasXGrupo($fecha, $grupo, $agencia);
            $reportexClientesxCarteraVencidaXGrupo = ReporteClientes::model()->getGraficaclientesCarteraVenciadaXGrupo($fecha, $grupo, $agencia);
            $this->renderPartial('_RClientesxGrupoVentas', array(
                'reportexClientesNotaCreditoxGrupo' => $reportexClientesNotaCreditoxGrupo,
                'reportexClientesxNoventasxGrupo' => $reportexClientesxNoventasxGrupo,
                'reportexClientesxCarteraVencidaXGrupo' => $reportexClientesxCarteraVencidaXGrupo
            ));
        }
    }

    public function actionAjaxCargarGraficaClientesXFecha() {


        if ($_POST) {


            $fecha = $_POST['fecha'];
            $agencia = $_POST['agencia'];

            $reportexClientesNotaCreditoxFecha = ReporteClientes::model()->getGraficaNotasCreditoxFecha($fecha, $agencia);
            $reportexClientesxNoventasxFecha = ReporteClientes::model()->getGraficaNoVentasXFecha($fecha, $agencia);
            $reportexClientesxCarteraVencidaXFecha = ReporteClientes::model()->getGraficaclientesCarteraVenciadaXFecha($fecha, $agencia);
            $this->renderPartial('_RClientesxFecha', array(
                'reportexClientesNotaCreditoxFecha' => $reportexClientesNotaCreditoxFecha,
                'reportexClientesxNoventasxFecha' => $reportexClientesxNoventasxFecha,
                'reportexClientesxCarteraVencidaXFecha' => $reportexClientesxCarteraVencidaXFecha
            ));
        }
    }

    public function actionAjaxCargarGraficaClientesXCanal() {


        if ($_POST) {

            $canal = $_POST['canal'];
            $fecha = $_POST['fecha'];
            $agencia = $_POST['agencia'];

            $reportexClientesNotaCreditoxCanal = ReporteClientes::model()->getGraficaNotasCreditoxCanal($fecha, $canal, $agencia);
            $reportexClientesxNoventasxCanal = ReporteClientes::model()->getGraficaNoVentasXCanal($fecha, $canal, $agencia);
            $reportexClientesxCarteraVencidaXCanal = ReporteClientes::model()->getGraficaclientesCarteraVenciadaXCanal($fecha, $canal, $agencia);
            $this->renderPartial('_RClientesxCanal', array(
                'reportexClientesNotaCreditoxCanal' => $reportexClientesNotaCreditoxCanal,
                'reportexClientesxNoventasxCanal' => $reportexClientesxNoventasxCanal,
                'reportexClientesxCarteraVencidaXCanal' => $reportexClientesxCarteraVencidaXCanal
            ));
        }
    }

    public function actionAjaxCargarGraficaClienteXAgencia() {


        if ($_POST) {

            $agencia = $_POST['agencia'];
            $fecha = $_POST['fecha'];


            $reportexClientesNotaCreditoxAgencia = ReporteClientes::model()->getGraficaNotasCreditoxAgencia($fecha, $agencia);
            $reportexClientesxNoventasxAgencia = ReporteClientes::model()->getGraficaNoVentasXAgencia($fecha, $agencia);
            $reportexClientesxCarteraVencidaXAgencia = ReporteClientes::model()->getGraficaclientesCarteraVenciadaXAgencia($fecha, $agencia);
            $this->renderPartial('_RClientesxAgencia', array(
                'reportexClientesNotaCreditoxAgencia' => $reportexClientesNotaCreditoxAgencia,
                'reportexClientesxNoventasxAgencia' => $reportexClientesxNoventasxAgencia,
                'reportexClientesxCarteraVencidaXAgencia' => $reportexClientesxCarteraVencidaXAgencia
            ));
        }
    }

    public function actionZonaVentas() {


        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/scripts/reportes/Reportes/ReporteZonaVentas.js', CClientScript::POS_END
        );

        $cedula = Yii::app()->getUser()->getState('_cedula');

        $Agencias = ReporteZonaVentas::model()->getAgencias($cedula);

        //comento las consultas ya que estas son globales pero se debe son filtrar
        //$Frecuencias = ReporteZonaVentas::model()->getGraficaEfectividad();
        //$Noventames = ReporteZonaVentas::model()->getGraficaNoVentasMes();
        //$ProfundidadGlobal = ReporteZonaVentas::model()->getProfundidadGlobal();

        $this->render('ZonaVentas', array(
            'Agencias' => $Agencias,
            'Frecuencias' => $Frecuencias,
            'Noventames' => $Noventames,
            'ProfundidadGlobal' => $ProfundidadGlobal
        ));
    }

    public function actionAjaxCargarGraficaProfundidadTipoGlobal() {

        if ($_POST) {

            $tipo = $_POST['tipo'];

            $ProfundidadGlobalTipo = ReporteZonaVentas::model()->getProfundidadGlobalTipo($tipo);

            $this->renderPartial('ZonaVentas', array(
                'ProfundidadGlobal' => $ProfundidadGlobalTipo
            ));
        }
    }

    public function actionAjaxCargarGruposVentasSolo() {


        $aghtml = '';


        $Grupo = ReporteZonaVentas::model()->getGruposVenta();

        $aghtml.=' <select id="selectchosegrupventas2" name="GruposVentas" class="form-control chosen-select" data-placeholder="Seleccione un grupo ventas"> <option value=""></option>';
        foreach ($Grupo as $itemGruVentas) {

            $aghtml.='
                     
                     <option  value="' . $itemGruVentas['CodigoGrupoVentas'] . '">' . $itemGruVentas['NombreGrupoVentas'] . '</option>
                      ';
        }

        $aghtml.='</select>';

        echo $aghtml;
    }

    public function actionAjaxCargarGraficaAgenciaZonaVentas() {

        if ($_POST) {

            $gencia = $_POST['agencia'];

            $reportexagenciaEfectividadClientesAgencia = ReporteZonaVentas::model()->getClientesAgencia($gencia);
            $reportexagenciaNoVentasMes = ReporteZonaVentas::model()->getGraficaNoVentasZonaVentasxAgencia($gencia);

            $this->renderPartial('_RZonaVentasxAgencia', array(
                'reportexagenciaEfectividadClientesAgencia' => $reportexagenciaEfectividadClientesAgencia,
                'reportexagenciaNoVentasMes' => $reportexagenciaNoVentasMes
            ));
        }
    }

    public function actionAjaxCargarGraficaZonaVentaXCanal() {

        if ($_POST) {


            $canal = $_POST['canal'];
            $agencia = $_POST['agencia'];
            $zona = $_POST['zona'];


            $cedula = Yii::app()->getUser()->getState('_cedula');
            $agencias = ReporteZonaVentas::model()->getAgencias($cedula);
            $reportexcanal = ReporteZonaVentas::model()->getGraficaxCanalZonaVentas($canal, $agencia);
            $reportexcanalNoVentasMes = ReporteZonaVentas::model()->getGraficaNoVentasZonaVentasxCanal($canal, $agencia);
            $profundidad = ReporteZonaVentas::model()->getProfundidad($zona, $agencia);

            $this->renderPartial('_RZonaVentasxCanal', array(
                'reportexcanal' => $reportexcanal,
                'agencias' => $agencias,
                'reportexcanalNoVentasMes' => $reportexcanalNoVentasMes,
                'profundidad' => $profundidad
            ));
        }
    }

    public function actionAjaxCargarGraficaZonaVentasXZonasVentas() {


        if ($_POST) {

            $zona = $_POST['zona'];
            $agencia = $_POST['agencia'];

            $cedula = Yii::app()->getUser()->getState('_cedula');
            $agencias = ReporteZonaVentas::model()->getAgencias($cedula);
            $reportexzona = ReporteZonaVentas::model()->getGraficaxZonaVentas($zona, $agencia);
            $reportexzonaNoVentasMes = ReporteZonaVentas::model()->getGraficaNoVentasZonaVentasxZona($zona, $agencia);
            $ObjetivoVisita = ReporteZonaVentas::model()->getObjetivo($zona, $agencia);
            $profundidad = ReporteZonaVentas::model()->getProfundidad($zona, $agencia);

            $this->renderPartial('_RZonaVentasxZona', array(
                'reportexzona' => $reportexzona,
                'agencias' => $agencias,
                'reportexzonaNoVentasMes' => $reportexzonaNoVentasMes,
                'ObjetivoVisita' => $ObjetivoVisita,
                'profundidad' => $profundidad
            ));
        }
        return;
    }

    public function actionAjaxCargarGraficaProfundidadTipo() {

        if ($_POST) {

            $zona = $_POST['zona'];
            $agencia = $_POST['agencia'];
            $tipo = $_POST['tipo'];

            $profundidadGrupo = ReporteZonaVentas::model()->getProfundidadGM($zona, $agencia, $tipo);

            $this->renderPartial('_grafProfundidad', array(
                'profundidad' => $profundidadGrupo,
                'tipo' => $tipo
            ));
        }
    }

    public function actionAjaxCargarGraficaZonaVentasXFecha() {

        if ($_POST) {

            $fecha = $_POST['fecha'];
            $agencia = $_POST['agencia'];

            $reportexfecha = ReporteZonaVentas::model()->getGraficaEfecxFecha($fecha, $agencia);
            $reportexzonaNoVentasFecha = ReporteZonaVentas::model()->getGraficaNoVentasZonaVentasxFecha($fecha, $agencia);

            //$reportexfechaQuincenal = ReporteZonaVentas::model()-> getGraficaQuincenalxFecha($fecha);   

            $this->renderPartial('_RZonaVentasxFecha', array(
                'reportexfecha' => $reportexfecha,
                'reportexzonaNoVentasFecha' => $reportexzonaNoVentasFecha
            ));
        }
    }

    public function actionCargaSelectAgencia() {
        
    }

    public function actionCargaFecha() {
        
    }

    public function actionCargarGrupoVentas() {
        
    }

    public function actionCargarZonaVentas() {
        
    }

    public function actionCargarCanal() {
        
    }

    /*
     * se carga el reporte de mapas
     */

    public function actionMaps() {


        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/scripts/reportes/Reportes/Mapas.js', CClientScript::POS_END
        );

        $cedula = Yii::app()->getUser()->getState('_cedula');

        $Agencias = ReporteZonaVentas::model()->getAgencias($cedula);

        $this->render('Maps', array('Agencias' => $Agencias));
    }

    /*
     * cargar la informacion de mapas por agencia
     * @parameters
     * @_POST agencia
     * @_POST fecha inicio
     * @_POST fecha fin
     * @_POST gurpo ventas
     * @_POST zona ventas
     */

    public function actionAjaxCargarMapa() {

        if ($_POST) {

            $fechaini = $_POST['fechaini'];
            $fechafin = $_POST['fechafin'];
            $agencia = $_POST['agencia'];
            $grupoventas = $_POST['grupo'];
            $zonaventas = $_POST['zonaVentas'];

            $coordenadas = "";


            if ($agencia != "" && $fechaini != "" && $fechafin != "" && $grupoventas != "" && $zonaventas != "") {

                $coordenadas = ReporteMapas::model()->getCoordenadasZonaVentas($agencia, $fechaini, $fechafin, $zonaventas);
            } elseif ($agencia != "" && $fechaini != "" && $fechafin != "" && $grupoventas != "") {

                $coordenadas = ReporteMapas::model()->getCoordenadasGrupoVentas($agencia, $fechaini, $fechafin, $grupoventas);
            } elseif ($agencia != "" && $fechaini != "" && $fechafin != "") {

                $coordenadas = ReporteMapas::model()->getCoordenadas($agencia, $fechaini, $fechafin);
            }

            /* foreach ($coordenadas as $coord) { 
              echo $coord['direccion'];

              } */


            echo $this->renderPartial('mapa', array('coordenadas' => $coordenadas));
        }
    }

    public function actionVistalink() {

        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/scripts/reportes/reportesFzVentas/ReporteVistaLink.js', CClientScript::POS_END
        );

        $cedula = Yii::app()->getUser()->getState('_cedula');

        $Agencias = ReporteClientes::model()->getAgencias($cedula);
        $ventasproveedor = ReporteVistaLink::model()->getVentasProveedor();
        $Cajas = ReporteVistaLink::model()->getUnidadMedidaArticulos();
        $Categoria = ReporteVistaLink::model()->getCategoria();
        $proveedores = ReporteVistaLink::model()->getProveedores();
        $cargarcategoria = ReporteVistaLink::model()->getCargarCategorias();


        $this->render('ventaslink', array(
            'Agencias' => $Agencias,
            'ventasproveedor' => $ventasproveedor,
            'cajas' => $Cajas,
            'categoria' => $Categoria,
            'proveedores' => $proveedores,
            'cargarcategoria' => $cargarcategoria
        ));
    }

    public function actionFzVentas() {

        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/scripts/reportes/reportesFzVentas/ReporteFuerzaVentas.js', CClientScript::POS_END
        );

        $cedula = Yii::app()->getUser()->getState('_cedula');

        $Agencias = ReporteClientes::model()->getAgencias($cedula);

        $this->render('ReporteFzVentas', array(
            'Agencias' => $Agencias
        ));
    }

    /////////////////AQUI EMPIESAN LAS ACCIONES DE LOS REPOTES FUERZA VENTAS ///////////
//       


    public function actionAjaxFzVentasTerminarRuta() {

        if ($_POST) {


            $fechaini = $_POST['ini'];
            $fechafin = $_POST['fin'];
            $agencia = $_POST['agencia'];

            $FvzonaRuta = ReporteFzNoVentas::model()->getZonaVentasTerminarRuta($fechaini, $fechafin, $agencia);



            $this->renderPartial('_Fzterminarruta', array(
                'FvzonaRuta' => $FvzonaRuta
            ));
        }
    }

    public function actionAjaxFzVentasPedidos() {


        if ($_POST) {


            $fechaini = $_POST['ini'];
            $fechafin = $_POST['fin'];
            $agencia = $_POST['agencia'];

            $FvzonaPedidos = ReporteFzNoVentas::model()->getZonaVentasPedidos($fechaini, $fechafin, $agencia);



            $this->renderPartial('_Fzpedidos', array(
                'FvzonaPedidos' => $FvzonaPedidos
            ));
        }
    }

    public function actionAjaxFzVentasFacturas() {

        if ($_POST) {


            $fechaini = $_POST['ini'];
            $fechafin = $_POST['fin'];
            $agencia = $_POST['agencia'];

            $FvzonaFacturas = ReporteFzNoVentas::model()->getZonaVentasFacturas($fechaini, $fechafin, $agencia);



            $this->renderPartial('_Fzfacturas', array(
                'FvzonaFacturas' => $FvzonaFacturas
            ));
        }
    }

    public function actionAjaxFzVentasDevoluciones() {

        if ($_POST) {


            $fechaini = $_POST['ini'];
            $fechafin = $_POST['fin'];
            $agencia = $_POST['agencia'];

            $FvzonaDevoluciones = ReporteFzNoVentas::model()->getZonaVentasDevoluciones($fechaini, $fechafin, $agencia);



            $this->renderPartial('_Fzdevoluciones', array(
                'FvzonaDevoluciones' => $FvzonaDevoluciones
            ));
        }
    }

    public function actionAjaxFzVentasRecibos() {

        if ($_POST) {


            $fechaini = $_POST['ini'];
            $fechafin = $_POST['fin'];
            $agencia = $_POST['agencia'];

            $FvzonaRecibos = ReporteFzNoVentas::model()->getZonaVentasRecibos($fechaini, $fechafin, $agencia);



            $this->renderPartial('_Fzrecibos', array(
                'FvzonaRecibos' => $FvzonaRecibos
            ));
        }
    }

    public function actionAjaxFzVentasClientesNuevos() {

        if ($_POST) {


            $fechaini = $_POST['ini'];
            $fechafin = $_POST['fin'];
            $agencia = $_POST['agencia'];

            $FvzonaClientesNuevos = ReporteFzNoVentas::model()->getZonaVentasClientesNuevos($fechaini, $fechafin, $agencia);



            $this->renderPartial('_Fzclientesnuevos', array(
                'FvzonaClientesNuevos' => $FvzonaClientesNuevos
            ));
        }
    }

    public function actionAjaxFzVentasNoVentas() {


        if ($_POST) {


            $fechaini = $_POST['ini'];
            $fechafin = $_POST['fin'];
            $agencia = $_POST['agencia'];

            $Fvzona = ReporteFzNoVentas::model()->getZonaVentas($fechaini, $fechafin, $agencia);


            $this->renderPartial('_Fznoventas', array(
                'Fvzona' => $Fvzona
            ));
        }
    }

    public function actionAjaxFzVentasNotasCredito() {

        if ($_POST) {


            $fechaini = $_POST['ini'];
            $fechafin = $_POST['fin'];
            $agencia = $_POST['agencia'];

            $FvzonaNotas = ReporteFzNoVentas::model()->getZonaVentasNotasCredito($fechaini, $fechafin, $agencia);



            $this->renderPartial('_Fznotascredito', array(
                'FvzonaNotas' => $FvzonaNotas
            ));
        }
    }

    public function actionAjaxFzVentastransferenciaConsignacion() {


        if ($_POST) {


            $fechaini = $_POST['ini'];
            $fechafin = $_POST['fin'];
            $agencia = $_POST['agencia'];

            $FvzonaTransConsi = ReporteFzNoVentas::model()->getZonaVentasTransCoinsignacion($fechaini, $fechafin, $agencia);



            $this->renderPartial('_Fvtransferenciaconsignacion', array(
                'FvzonaTransConsi' => $FvzonaTransConsi
            ));
        }
    }

    public function actionAjaxFzVentasConsignacionVeendedor() {



        if ($_POST) {


            $fechaini = $_POST['ini'];
            $fechafin = $_POST['fin'];
            $agencia = $_POST['agencia'];

            $FvzonaConsig = ReporteFzNoVentas::model()->getZonaVentasConsignacionVeendedor($fechaini, $fechafin, $agencia);



            $this->renderPartial('_Fvconsignacionveendedor', array(
                'FvzonaConsig' => $FvzonaConsig
            ));
        }
    }

    public function actionAjaxFzVentasTransferenciaAutoventa() {



        if ($_POST) {


            $fechaini = $_POST['ini'];
            $fechafin = $_POST['fin'];
            $agencia = $_POST['agencia'];

            $FvTransAuto = ReporteFzNoVentas::model()->getZonaVentasTransAutoventa($fechaini, $fechafin, $agencia);



            $this->renderPartial('_Fvtransferenciaautoventa', array(
                'FvTransAuto' => $FvTransAuto
            ));
        }
    }

    public function actionAjaxGenerarDetalleNoVentas() {


        if ($_POST) {
            $arrayzona = $_POST['zona'];
            $fechaini = $_POST['fechaini'];
            $fechafin = $_POST['fechafin'];
            $agencia = $_POST['agencia'];

            $cont = 1;
            $sql = "SELECT motinov.Nombre as motivonoventa,nov.CodZonaVentas,nov.CuentaCliente,zv.NombreZonadeVentas,cli.NombreCliente,nov.Responsable,nov.FechaNoVenta,nov.HoraNoVenta FROM `noventas` as nov 
                  join motivosnoventa as motinov on nov.CodMotivoNoVenta=motinov.CodMotivoNoVenta 
                  join zonaventas as zv on nov.CodZonaVentas=zv.CodZonaVentas
                  join gruposventas gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas
                  join agencia ag on gr.CodAgencia=ag.CodAgencia
                  join cliente as cli on nov.CuentaCliente=cli.CuentaCliente 
                  WHERE nov.CodZonaVentas in(";
            foreach ($arrayzona as $itemzona) {
                if ($cont == count($arrayzona)) {

                    $sql.=" '" . $itemzona . "') ";
                } else {
                    $sql.=" '" . $itemzona . "', ";
                }
                $cont++;
            }
            $sql.="AND ag.CodAgencia='$agencia' AND nov.FechaNoVenta BETWEEN  '" . $fechaini . "' AND '" . $fechafin . "' ORDER BY nov.CodZonaVentas ASC,nov.FechaNoVenta ASC,nov.HoraNoVenta ASC ";


            $datalle = ReporteFzNoVentas::model()->getGenrarDetalleNoVenta($sql, $agencia);

            $this->renderPartial('_FvDetalleNoVenta', array(
                'arraypuhs' => $datalle,
                'fechaini' => $fechaini,
                'fechafin' => $fechafin,
                'sql' => $sql,
                'agencia' => $agencia
            ));
        }
    }

    public function actionExportarExcelNoventas() {

        if ($_POST) {

            $sql = $_POST['sql'];
            $fechaini = $_POST['fechaini'];
            $fechafin = $_POST['fechafin'];
            $agencia = $_POST['agencia'];

            $datalle = ReporteFzNoVentas::model()->getGenrarDetalleNoVenta($sql, $agencia);


            $this->renderPartial('_noVentasExcel', array(
                'arraypuhs' => $datalle
            ));
        }
    }

    public function actionAjaxGenerarDetalleNotasCredito() {


        if ($_POST) {


            $arrayzona = $_POST['zona'];
            $fechaini = $_POST['fechaini'];
            $fechafin = $_POST['fechafin'];
            $agencia = $_POST['agencia'];
            //$arraypuhs= array();


            $cont = 1;
            $sql = "SELECT nota.IdNotaCredito,nota.CodAsesor,nota.CodZonaVentas,nota.CuentaCliente,concep.NombreConceptoNotaCredito,res.Descripcion,zv.NombreZonadeVentas,asesor.Nombre,nota.Responsable,nota.Fecha,nota.Hora,nota.Valor,cli.NombreCliente,nota.Factura,nota.ResponsableNota,nota.Fabricante,nota.Observacion,nota.ArchivoXml,ag.CodAgencia FROM `notascredito` as nota 
                  join responsablenota as res on nota.ResponsableNota=res.Interfaz
                  join conceptosnotacredito concep on nota.Concepto=concep.CodigoConceptoNotaCredito 
                  join zonaventas as zv on nota.CodZonaVentas=zv.CodZonaVentas
                  join gruposventas gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas
                  join agencia ag on gr.CodAgencia=ag.CodAgencia
                  join asesorescomerciales as asesor on nota.CodAsesor=asesor.CodAsesor 
                  join cliente as cli on nota.CuentaCliente=cli.CuentaCliente 
                  WHERE nota.CodZonaVentas in(";
            foreach ($arrayzona as $itemzona) {
                if ($cont == count($arrayzona)) {

                    $sql.=" '" . $itemzona . "') ";
                } else {
                    $sql.=" '" . $itemzona . "', ";
                }
                $cont++;
            }
            $sql.="AND ag.CodAgencia='$agencia' AND nota.Fecha BETWEEN  '" . $fechaini . "' AND '" . $fechafin . "' GROUP BY nota.IdNotaCredito ORDER BY nota.CodZonaVentas";


            $datalleNotasCredito = ReporteFzNoVentas::model()->getGenrarDetalleNotasCredito($sql, $agencia);

            $this->renderPartial('_FvDetalleNotasCredito', array(
                'arraypuhs' => $datalleNotasCredito,
                'fechaini' => $fechaini,
                'fechafin' => $fechafin,
                'sql' => $sql,
                'agencia' => $agencia
            ));
        }
    }

    public function actionExportarExcelNotasCredito() {

        if ($_POST) {

            $sql = $_POST['sql'];
            $fechaini = $_POST['fechaini'];
            $fechafin = $_POST['fechafin'];
            $agencia = $_POST['agencia'];

            $datalleNotasCredito = ReporteFzNoVentas::model()->getGenrarDetalleNotasCredito($sql, $agencia);


            $this->renderPartial('_notasCreditoExcel', array(
                'arraypuhs' => $datalleNotasCredito
            ));
        }
    }

    public function actionAjaxDetalleFotos() {

        $cont = 0;
        if ($_POST) {

            $id = $_POST['id'];
            $agencia = $_POST['agencia'];


            $fotos = ReporteFzNoVentas::model()->getDetalleFotosNotasCredito($id, $agencia);

            $detallefoto = "";

            $detallefoto.='
                 <div class="row">
                      <div class="col-sm-12">
                          <div class="row filemanager">
                      

               ';
            foreach ($fotos as $itemFoto) {
                $cont++;

                $detallefoto.='
                   
          <div class="col-xs-6 col-sm-4 col-md-3 image">
              <div class="thmb">
                  <div class="thmb-prev">
                  <a href="imagenes/' . $itemFoto['Nombre'] . '" data-rel="prettyPhoto">
                    <img src="imagenes/' . $itemFoto['Nombre'] . '" class="img-responsive" alt="" />
                  </a>
                </div>
                <h5 class="fm-title"><a href="#">' . $itemFoto['Nombre'] . '</a></h5>
                <small class="text-muted">Foto</small>
              </div><!-- thmb -->
            </div><!-- col-xs-6 -->
                     
                    ';
            }
            $detallefoto.='
               
                     </div><!-- row -->
                 </div><!-- col-sm-9 -->
             </div>
              ';

            if ($cont == 0) {
                $detallefoto = "";
            }

            echo $detallefoto;
        }
    }

    public function actionAjaxGenerarDetalleConsigVeendedor() {


        if ($_POST) {

            $arrayzona = $_POST['zona'];
            $fechaini = $_POST['fechaini'];
            $fechafin = $_POST['fechafin'];
            $agencia = $_POST['agencia'];

            $cont = 1;
            $sql = "SELECT convendedor.CodZonaVentas,zv.NombreZonadeVentas,convendedor.CodAsesor,convendedor.FechaConsignacion,convendedor.NroConsignacion,convendedor.Banco,convendedor.CuentaConsignacion,convendedor.ValorConsignadoEfectivo,convendedor.ValorConsignadoCheque,convendedor.Oficina,convendedor.Ciudad,asesor.Nombre as NombreAsesor,convendedor.Responsable,convendedor.IdentificadorBanco,convendedor.HoraConsignacion,convendedor.FechaConsignacionVendedor,convendedor.ArchivoXml FROM `consignacionesvendedor` as convendedor 
                  join asesorescomerciales as asesor on convendedor.CodAsesor=asesor.CodAsesor 
                  join zonaventas as zv on convendedor.CodZonaVentas=zv.CodZonaVentas 
                  join gruposventas gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas
                  join agencia ag on gr.CodAgencia=ag.CodAgencia
                  WHERE convendedor.CodZonaVentas in(";
            foreach ($arrayzona as $itemzona) {
                if ($cont == count($arrayzona)) {

                    $sql.=" '" . $itemzona . "') ";
                } else {
                    $sql.=" '" . $itemzona . "', ";
                }
                $cont++;
            }
            $sql.="AND ag.CodAgencia='$agencia' AND convendedor.FechaConsignacion BETWEEN  '" . $fechaini . "' AND '" . $fechafin . "' GROUP BY  convendedor.IdConsignacion ORDER BY convendedor.CodZonaVentas";


            $datalleConsigVendedor = ReporteFzNoVentas::model()->getGenrarDetalleConsignacionVeendedor($sql, $agencia);

            $this->renderPartial('_FvDetalleconsignVeendedor', array(
                'arraypuhs' => $datalleConsigVendedor,
                'fechaini' => $fechaini,
                'fechafin' => $fechafin,
                'sql' => $sql
            ));
        }
    }

    public function actionExportarExcelConsignacionVeendedor() {

        if ($_POST) {

            $sql = $_POST['sql'];
            $fechaini = $_POST['fechaini'];
            $fechafin = $_POST['fechafin'];

            $datalleConsigVendedor = ReporteFzNoVentas::model()->getGenrarDetalleConsignacionVeendedor($sql, $agencia);


            $this->renderPartial('_ConsigVeendedorExcel', array(
                'arraypuhs' => $datalleConsigVendedor
            ));
        }
    }

    public function actionAjaxGenerarDetalleTransConsignacion() {


        if ($_POST) {

            $arrayzona = $_POST['zona'];
            $fechaini = $_POST['fechaini'];
            $fechafin = $_POST['fechafin'];
            $agencia = $_POST['agencia'];

            $cont = 1;
            $sql = "SELECT transfe.IdTransferencia,transfe.CodZonaVentas,transfe.CuentaCliente,transfe.FechaTransferencia,sit.Nombre as Nombresitio,alam.Nombre as NombreAlma,cli.NombreCliente,zv.NombreZonadeVentas,transfe.Responsable,transfe.HoraEnviado,transfe.ArchivoXml,ag.CodAgencia,transfe.Estado FROM `transferenciaconsignacion` as transfe 
                  join descripciontransferenciaconsignacion as descri on transfe.IdTransferencia=descri.IdTransferencia
                  join sitios as sit on transfe.CodigoSitio=sit.CodSitio join almacenes as alam on transfe.CodigoAlmacen=alam.CodigoAlmacen 
                  join cliente as cli on transfe.CuentaCliente=cli.CuentaCliente 
                  join zonaventas as zv on transfe.CodZonaVentas=zv.CodZonaVentas
                  join gruposventas gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas
                  join agencia ag on gr.CodAgencia=ag.CodAgencia
                  WHERE transfe.CodZonaVentas in(";
            foreach ($arrayzona as $itemzona) {
                if ($cont == count($arrayzona)) {

                    $sql.=" '" . $itemzona . "') ";
                } else {
                    $sql.=" '" . $itemzona . "', ";
                }
                $cont++;
            }
            $sql.="AND ag.CodAgencia='$agencia' AND transfe.FechaTransferencia BETWEEN  '" . $fechaini . "' AND '" . $fechafin . "' GROUP BY transfe.IdTransferencia ORDER BY transfe.CodZonaVentas";


            $datalleTransConsignacion = ReporteFzNoVentas::model()->getGenrarDetalleTrnasferenciaConsig($sql, $agencia);

            $this->renderPartial('_FvDetalleTransConsignacion', array(
                'arraypuhs' => $datalleTransConsignacion
            ));
        }
    }

    public function actionAjaxGenerarDetalleTransAutoventa() {


        if ($_POST) {

            $arrayzona = $_POST['zona'];
            $fechaini = $_POST['fechaini'];
            $fechafin = $_POST['fechafin'];
            $agencia = $_POST['agencia'];

            $cont = 1;
            $sql = "SELECT transAuto.`IdTransferenciaAutoventa`,transAuto.`CodZonaVentas`,zv.NombreZonadeVentas,transAuto.`CodZonaVentasTransferencia`,transAuto.`Responsable`,transAuto.`CodigoUbicacionOrigen`,transAuto.`CodigoUbicacionDestino`,transAuto.`FechaTransferenciaAutoventa`,transAuto.`HoraEnviado`,transAuto.ArchivoXml,ag.CodAgencia  FROM `transferenciaautoventa` as transAuto
                  join zonaventas as zv on transAuto.CodZonaVentas=zv.CodZonaVentas
                  join gruposventas gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas
                  join agencia ag on gr.CodAgencia=ag.CodAgencia
                  WHERE transAuto.CodZonaVentas in(";
            foreach ($arrayzona as $itemzona) {
                if ($cont == count($arrayzona)) {

                    $sql.=" '" . $itemzona . "') ";
                } else {
                    $sql.=" '" . $itemzona . "', ";
                }
                $cont++;
            }
            $sql.="AND ag.CodAgencia='$agencia' AND transAuto.FechaTransferenciaAutoventa BETWEEN  '" . $fechaini . "' AND '" . $fechafin . "' ORDER BY transAuto.CodZonaVentas";


            $datalleTransAutoventa = ReporteFzNoVentas::model()->getGenrarDetalleTrnasferenciaAutoventa($sql, $agencia);

            $this->renderPartial('_FvDetalleTransAutoventa', array(
                'arraypuhs' => $datalleTransAutoventa
            ));
        }
    }

    public function actionAjaxGenerarDetalleTerminarRuta() {


        if ($_POST) {

            $arrayzona = $_POST['zona'];
            $fechaini = $_POST['fechaini'];
            $fechafin = $_POST['fechafin'];
            $agencia = $_POST['agencia'];

            $cont = 1;
            $sql = "SELECT zv.CodZonaVentas,zv.NombreZonadeVentas,msg.IdDestinatario,msg.IdRemitente,msg.FechaMensaje,msg.HoraMensaje,msg.Mensaje,msg.`Estado`,msg.`CodAsesor`,asesor.Nombre FROM `mensajes` as msg
            join asesorescomerciales as asesor on msg.`CodAsesor`=asesor.CodAsesor
            join zonaventas as  zv on msg.`CodAsesor`=zv.CodAsesor 
            join gruposventas gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas
            join agencia ag on gr.CodAgencia=ag.CodAgencia
            WHERE zv.CodZonaVentas in(";
            foreach ($arrayzona as $itemzona) {
                if ($cont == count($arrayzona)) {

                    $sql.=" '" . $itemzona . "') ";
                } else {
                    $sql.=" '" . $itemzona . "', ";
                }
                $cont++;
            }
            $sql.="AND ag.CodAgencia='$agencia' AND msg.FechaMensaje BETWEEN  '" . $fechaini . "' AND '" . $fechafin . "' AND msg.Mensaje = 'Termino Ruta' ORDER BY  msg.HoraMensaje ASC";


            $datalleTerminarRuta = ReporteFzNoVentas::model()->getGenrarDetalleTerminarRuta($sql);

            $this->renderPartial('_FvDetalleTerminarRuta', array(
                'arraypuhs' => $datalleTerminarRuta
            ));
        }
    }

    public function actionAjaxGenerarDetallePedido() {

        if ($_POST) {

            $arrayzona = $_POST['zona'];
            $fechaini = $_POST['fechaini'];
            $fechafin = $_POST['fechafin'];
            $agencia = $_POST['agencia'];

            $cont = 1;
            $sql = "SELECT pe.IdPedido,pe.CodZonaVentas,pe.CuentaCliente,pe.FechaPedido,pe.FormaPago,pe.TotalValorImpoconsumo,pe.ValorPedido,pe.TotalPedido,pe.TotalValorIva,pe.TotalSubtotalBaseIva,grupre.NombreGrupodePrecio,grupventas.NombreGrupoVentas,zv.NombreZonadeVentas,cli.NombreCliente,pe.Responsable,pe.HoraEnviado,alma.Nombre as NombreAlmacen,sit.Nombre as NombreSitio,pe.Plazo,pe.TipoVenta,pe.ActividadEspecial,pe.FechaEntrega,pe.Observacion,pe.ArchivoXml,ag.CodAgencia,pe.CodigoSitio,pe.CodigoAlmacen FROM `pedidos` as pe 
                  join grupodeprecios as grupre on pe.CodGrupoPrecios=grupre.CodigoGrupoPrecio
                  join zonaventas as zv on pe.CodZonaVentas=zv.CodZonaVentas
                  join gruposventas as grupventas on zv.CodigoGrupoVentas=grupventas.CodigoGrupoVentas
                  join agencia ag on grupventas.CodAgencia=ag.CodAgencia
                  left join cliente as cli on pe.CuentaCliente=cli.CuentaCliente 
                  join almacenes as alma on pe.CodigoAlmacen=alma.CodigoAlmacen 
                  join sitios as sit on pe.CodigoSitio=sit.CodSitio
                  WHERE pe.CodZonaVentas in(";
            foreach ($arrayzona as $itemzona) {
                if ($cont == count($arrayzona)) {

                    $sql.=" '" . $itemzona . "') ";
                } else {
                    $sql.=" '" . $itemzona . "', ";
                }
                $cont++;
            }
            $sql.="AND pe.FechaPedido BETWEEN  '" . $fechaini . "' AND '" . $fechafin . "' GROUP BY pe.IdPedido ORDER BY pe.CodZonaVentas";


            $datallePedido = ReporteFzNoVentas::model()->getGenrarDetallePedido($agencia, $sql);

            $this->renderPartial('_FvDetallePedido', array(
                'arraypuhs' => $datallePedido,
                'sqlPedido' => $sql,
                'fechaini' => $fechaini,
                'fechafin' => $fechafin,
                'agencia' => $agencia
            ));
        }
    }

    // Este metodo exporta el reporte de pedidos a en excel, recive por post la fecha inicial, la fecha final la agencia y el sql de la consulta
    public function actionAjaxExportarExcelPedidos() {

        if ($_POST) {

            $sql = $_POST['sqlPedido'];
            $fechaini = $_POST['fechaini'];
            $fechafin = $_POST['fechafin'];
            $agencia = $_POST['agencia'];

            $datallePedido = ReporteFzNoVentas::model()->getGenrarDetallePedido($agencia, $sql);

            $this->renderPartial('_PedidoExcel', array(
                'arraypuhs' => $datallePedido,
            ));
        }
    }

    public function actionAjaxGenerarDetalleFacturas() {

        if ($_POST) {

            $arrayzona = $_POST['zona'];
            $fechaini = $_POST['fechaini'];
            $fechafin = $_POST['fechafin'];
            $agencia = $_POST['agencia'];

            $cont = 1;
            $sql = "SELECT fac.IdPedido,fac.CodZonaVentas,fac.CuentaCliente,fac.FechaPedido,fac.FormaPago,fac.TotalValorImpoconsumo,fac.ValorPedido,fac.TotalPedido,fac.TotalValorIva,fac.TotalSubtotalBaseIva,grupre.NombreGrupodePrecio,grupventas.NombreGrupoVentas,zv.NombreZonadeVentas,cli.NombreCliente,fac.Responsable,fac.HoraEnviado,alma.Nombre as NombreAlmacen,sit.Nombre as NombreSitio,fac.Plazo,fac.TipoVenta,fac.ActividadEspecial,fac.FechaEntrega,fac.Observacion,fac.NroFactura,fac.ArchivoXml,ag.CodAgencia FROM `pedidos` as fac 
                  join grupodeprecios as grupre on fac.CodGrupoPrecios=grupre.CodigoGrupoPrecio
                  join zonaventas as zv on fac.CodZonaVentas=zv.CodZonaVentas
                  join gruposventas as grupventas on zv.CodigoGrupoVentas=grupventas.CodigoGrupoVentas
                  join agencia ag on grupventas.CodAgencia=ag.CodAgencia
                  join cliente as cli on fac.CuentaCliente=cli.CuentaCliente 
                  join almacenes as alma on fac.CodigoAlmacen=alma.CodigoAlmacen 
                  join sitios as sit on fac.CodigoSitio=sit.CodSitio WHERE fac.CodZonaVentas in(";
            foreach ($arrayzona as $itemzona) {
                if ($cont == count($arrayzona)) {

                    $sql.=" '" . $itemzona . "') ";
                } else {
                    $sql.=" '" . $itemzona . "', ";
                }
                $cont++;
            }
            $sql.="AND ag.CodAgencia='$agencia' AND fac.Fechapedido  BETWEEN  '" . $fechaini . "' AND '" . $fechafin . "' AND fac.TipoVenta='Autoventa' GROUP BY fac.Idpedido";


            $datalleFactura = ReporteFzNoVentas::model()->getGenrarDetalleFactura($sql, $agencia);

            $this->renderPartial('_FvDetalleFacturas', array(
                'arraypuhs' => $datalleFactura,
                'sqlFactura' => $sql,
                'fechaini' => $fechaini,
                'fechafin' => $fechafin,
                'agencia' => $agencia
            ));
        }
    }

    // Metodo para cargar el excel de facturas
    public function actionAjaxExportarExcelfactura() {

        if ($_POST) {

            $sql = $_POST['sqlFactura'];
            $fechaini = $_POST['fechaini'];
            $fechafin = $_POST['fechafin'];
            $agencia = $_POST['agencia'];

            $datalleFactura = ReporteFzNoVentas::model()->getGenrarDetalleFactura($sql, $agencia);

            $this->renderPartial('_facturaExcel', array(
                'arraypuhs' => $datalleFactura
            ));
        }
    }

    public function actionAjaxGenerarDetalleDevoluciones() {

        if ($_POST) {

            $arrayzona = $_POST['zona'];
            $fechaini = $_POST['fechaini'];
            $fechafin = $_POST['fechafin'];
            $agencia = $_POST['agencia'];

            $cont = 1;
            $sql = "SELECT devo.IdDevolucion,devo.CuentaCliente,motivodevo.NombreMotivoDevolucion,devo.TotalDevolucion,devo.ValorDevolucion,devo.Observacion,prove.NombreCuentaProveedor,devo.FechaDevolucion,zv.NombreZonadeVentas,cli.NombreCliente,devo.Horafinal,sit.Nombre,devo.CodZonaVentas,devo.Responsable,devo.ArchivoXml,ag.CodAgencia FROM `devoluciones` as devo
                  join motivosdevolucionproveedor as motivodevo on devo.CodigoMotivoDevolucion=motivodevo.CodigoMotivoDevolucion
                  join proveedores prove on devo.CuentaProveedor=prove.CodigoCuentaProveedor
                  join zonaventas as zv on devo.CodZonaVentas=zv.CodZonaVentas 
                  join gruposventas gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas
                  join agencia ag on gr.CodAgencia=ag.CodAgencia
                  join cliente as cli on devo.CuentaCliente=cli.CuentaCliente
                  join sitios as sit on devo.CodigoSitio=sit.CodSitio
                  WHERE devo.CodZonaVentas  in(";
            foreach ($arrayzona as $itemzona) {
                if ($cont == count($arrayzona)) {

                    $sql.=" '" . $itemzona . "') ";
                } else {
                    $sql.=" '" . $itemzona . "', ";
                }
                $cont++;
            }
            $sql.="AND ag.CodAgencia='$agencia' AND devo.FechaDevolucion  BETWEEN  '" . $fechaini . "' AND '" . $fechafin . "' GROUP BY devo.IdDevolucion  ORDER BY devo.IdDevolucion";


            $datalleDevoluciones = ReporteFzNoVentas::model()->getGenrarDetalleDevoluciones($sql, $agencia);

            $this->renderPartial('_FvDetalleDevoluciones', array(
                'arraypuhs' => $datalleDevoluciones,
                'sqlDevoluciones' => $sql,
                'fechaini' => $fechafin,
                'fechafin' => $fechafin,
                'agencia' => $agencia
            ));
        }
    }

    public function actionAjaxExportarExcelDevolucion() {

        if ($_POST) {

            $sql = $_POST['sqlDevoluciones'];
            $fechaini = $_POST['fechaini'];
            $fechafin = $_POST['fechafin'];
            $agencia = $_POST['agencia'];

            $datalleDevoluciones = ReporteFzNoVentas::model()->getGenrarDetalleDevoluciones($sql, $agencia);

            $this->renderPartial('_devolucionesExcel', array(
                'arraypuhs' => $datalleDevoluciones
            ));
        }
    }

    public function actionAjaxGenerarDetalleRecibos() {

        if ($_POST) {

            $arrayzona = $_POST['zona'];
            $fechaini = $_POST['fechaini'];
            $fechafin = $_POST['fechafin'];
            $agencia = $_POST['agencia'];

            $cont = 1;
            $sql = "SELECT caja.Id,caja.CodAsesor,caja.CuentaCliente,caja.Responsable,caja.ZonaVenta,cli.NombreCliente,zv.NombreZonadeVentas,asesor.Nombre as Asesor,reci.NumeroFactura,reci.ValorAbono,reci.DtoProntoPago,caja.Fecha,caja.Hora,caja.Provisional,ag.CodAgencia,caja.ArchivoXml FROM `reciboscaja` as caja
                  join zonaventas as zv on caja.ZonaVenta=zv.CodZonaVentas
                  join gruposventas gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas
                  join agencia ag on gr.CodAgencia=ag.CodAgencia
                  join cliente as cli on caja.CuentaCliente=cli.CuentaCliente 
                  join asesorescomerciales as asesor on caja.CodAsesor=asesor.CodAsesor 
                  join reciboscajafacturas as reci on caja.Id=reci.IdReciboCaja
                  WHERE caja.ZonaVenta  in(";
            foreach ($arrayzona as $itemzona) {
                if ($cont == count($arrayzona)) {

                    $sql.=" '" . $itemzona . "') ";
                } else {
                    $sql.=" '" . $itemzona . "', ";
                }
                $cont++;
            }
            $sql.="AND caja.Fecha  BETWEEN  '" . $fechaini . "' AND '" . $fechafin . "' GROUP BY caja.`Id` ORDER BY caja.ZonaVenta";


            $datalleRecibos = ReporteFzNoVentas::model()->getGenrarDetalleRecibos($sql, $agencia);

            $this->renderPartial('_FvDetalleRecibos', array(
                'arraypuhs' => $datalleRecibos,
                'sqlRecibos' => $sql,
                'fechaini' => $fechafin,
                'fechafin' => $fechafin,
                'agencia' => $agencia
            ));
        }
    }

    public function actionAjaxExportarExcelRecibos() {
        if ($_POST) {

            $sql = $_POST['sqlRecibos'];
            $fechaini = $_POST['fechaini'];
            $fechafin = $_POST['fechafin'];
            $agencia = $_POST['agencia'];

            $datalleRecibos = ReporteFzNoVentas::model()->getGenrarDetalleRecibos($sql, $agencia);

            $this->renderPartial('_recibosCajaExcel', array(
                'arraypuhs' => $datalleRecibos
            ));
        }
    }

    public function actionAjaxGenerarDetalleClientesNuevos() {

        if ($_POST) {

            $arrayzona = $_POST['zona'];
            $fechaini = $_POST['fechaini'];
            $fechafin = $_POST['fechafin'];
            $agencia = $_POST['agencia'];

            $cont = 1;
            $sql = "SELECT clinuevo.Posicion,clinuevo.Id,clinuevo.CuentaCliente,clinuevo.CodZonaVentas,clinuevo.Identificacion,clinuevo.Nombre,clinuevo.PrimerNombre,clinuevo.SegundoNombre,clinuevo.PrimerApellido,clinuevo.SegundoApellido,clinuevo.CodigoCiuu,clinuevo.Direccion,clinuevo.Telefono,clinuevo.TelefonoMovil,clinuevo.Email,tipodoc.Nombre as Documento,clinuevo.CodigoPostal,clinuevo.Latitud,clinuevo.Longitud,frevisita.CodFrecuencia as frecuencia,zv.NombreZonadeVentas,clinuevo.RazonSocial,clinuevo.CodTipoDocumento,clinuevo.OtroBarrio,clinuevo.Establecimiento,clinuevo.ArchivoXml,loca.NombreBarrio,loca.NombreLocalidad,loca.NombreCiudad FROM `clientenuevo` as clinuevo 
               join tipodocumento as tipodoc on clinuevo.CodTipoDocumento=tipodoc.Codigo
	       left  join Localizacion as loca on clinuevo.CodBarrio=loca.CodigoBarrio		
               join frecuenciavisita as frevisita on clinuevo.NumeroVisita=frevisita.NumeroVisita
               join zonaventas as zv on  clinuevo.CodZonaVentas=zv.CodZonaVentas 
               join gruposventas gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas
               join agencia ag on gr.CodAgencia=ag.CodAgencia
                WHERE clinuevo.CodZonaVentas in(";
            foreach ($arrayzona as $itemzona) {
                if ($cont == count($arrayzona)) {

                    $sql.=" '" . $itemzona . "') ";
                } else {
                    $sql.=" '" . $itemzona . "', ";
                }
                $cont++;
            }
            $sql.="AND clinuevo.FechaRegistro   BETWEEN  '" . $fechaini . "' AND '" . $fechafin . "' GROUP BY clinuevo.Id ORDER BY clinuevo.Id";


            $datalleClientesNuevos = ReporteFzNoVentas::model()->getGenrarDetalleClientesNuevos($sql, $agencia);

            $this->renderPartial('_FvDetalleClientesNuevos', array(
                'arraypuhs' => $datalleClientesNuevos,
                'fechaini' => $fechaini,
                'fechafin' => $fechafin,
                'sql' => $sql,
                'agencia' => $agencia
            ));
        }
    }

    public function actionExportarExcelClientesNuevos() {

        if ($_POST) {

            $sql = $_POST['sql'];
            $fechaini = $_POST['fechaini'];
            $fechafin = $_POST['fechafin'];
            $agencia = $_POST['agencia'];

            $datalleClientesNuevos = ReporteFzNoVentas::model()->getGenrarDetalleClientesNuevos($sql, $agencia);


            $this->renderPartial('_clientesNuevosExcel', array(
                'arraypuhs' => $datalleClientesNuevos
            ));
        }
    }

    public function actionAjaxDetalleKits() {

        if ($_POST) {

            $id = $_POST['id'];
            $agencia = $_POST['agencia'];

            $tabladetalle = "";

            $detalle = ReporteFzNoVentas::model()->getGenerarDetalleKits($id, $agencia);
            $information = ReporteFzNoVentas::model()->getInformacionDetalleKit($id, $agencia);

            $tabladetalle.='<table border="1" style="background-color: #C5D9F1; font-size: 12px; width: 100%">
                      
                      <tr>
                          <td  align="center"><b>Cod Variante</b></td>
                          <td  align="center"><b>Descripción del kit</b></td>
                      </tr>    
                   ';

            foreach ($information as $itemkistInformation) {

                $tabladetalle.='
                          <tr>
                          <td align="center">' . $itemkistInformation['CodVariante'] . '</td>
                          <td align="center">' . $itemkistInformation['NombreArticulo'] . '</td>
                          
                          </tr>
                      ';
            }
            $tabladetalle.='<table><br>';

            $tabladetalle.='<table border="1">
                       
                        <tr style="background-color: #C5D9F1; font-size: 12px;">
                          <td align="center"><b>Cod Lista Material</b></td>
                          <td align="center"><b>Cod Artículo Componente</b></td>
                          <td align="center"><b>Nombre Artículo Componente</b></td>
                          <td align="center"><b>Unidad Medida</b></td>
                          <td align="center"><b>Tipo</b></td>
                          <td align="center"><b>Catidad</b></td>
                            
                        </tr> ';




            foreach ($detalle as $itemkist) {

                $tabladetalle.='
                         <tr>
                            <td align="center">' . $itemkist['CodigoListaMateriales'] . '</td>
                            <td align="center">' . $itemkist['CodigoArticuloComponente'] . '</td>
                            <td align="center">' . $itemkist['Nombre'] . '</td>
                            <td align="center">' . $itemkist['CodigoUnidadMedida'] . '</td>
                            <td align="center">' . $itemkist['CodigoTipo'] . '</td>
                            <td align="center">' . $itemkist['Cantidad'] . '</td>
                                
                         </tr>    ';
            }
            $tabladetalle.='</table>';

            echo $tabladetalle;
        }
    }

    public function actionAjaxDetalleKitsFacturas() {

        if ($_POST) {

            $id = $_POST['id'];
            $agencia = $_POST['agencia'];

            $tabladetalle = "";

            $detalle = ReporteFzNoVentas::model()->getGenerarDetalleKitsFactura($id, $agencia);
            $information = ReporteFzNoVentas::model()->getInformacionDetalleKitFactura($id, $agencia);

            $tabladetalle.='<table border="1" style="width: 100%">
                      
                      <tr style="background-color: #C5D9F1; font-size: 12px;">
                          <td  align="center"><b>Cod Variante</b></td>
                          <td  align="center"><b>Descripción del kit</b></td>
                      </tr>    
                   ';

            foreach ($information as $itemkistInformation) {

                $tabladetalle.='
                          <tr>
                          <td align="center">' . $itemkistInformation['CodVariante'] . '</td>
                          <td align="center">' . $itemkistInformation['NombreArticulo'] . '</td>
                          
                          </tr>
                      ';
            }
            $tabladetalle.='<table><br>';

            $tabladetalle.='<table border="1">
                       
                        <tr style="background-color: #C5D9F1; font-size: 12px;">
                          <td align="center"><b>Cod Lista Material</b></td>
                          <td align="center"><b>Cod Artículo Componente</b></td>
                          <td align="center"><b>Nombre Artículo Componente</b></td>
                          <td align="center"><b>Unidad Medida</b></td>
                          <td align="center"><b>Tipo</b></td>
                          <td align="center"><b>Catidad</b></td>
                           
                           
                        </tr> ';




            foreach ($detalle as $itemkist) {

                $tabladetalle.='
                         <tr>
                            <td align="center">' . $itemkist['CodigoListaMateriales'] . '</td>
                            <td align="center">' . $itemkist['CodigoArticuloComponente'] . '</td>
                            <td align="center">' . $itemkist['Nombre'] . '</td>
                            <td align="center">' . $itemkist['CodigoUnidadMedida'] . '</td>
                            <td align="center">' . $itemkist['CodigoTipo'] . '</td>
                            <td align="center">' . $itemkist['Cantidad'] . '</td>
                                 
                         </tr>    ';
            }
            $tabladetalle.='</table>';

            echo $tabladetalle;
        }
    }

    public function actionAjaxDetalleEfectivo() {

        if ($_POST) {

            $id = $_POST['id'];
            $agencia = $_POST['agencia'];

            $tabladetalle = "";

            $detalle = ReporteFzNoVentas::model()->getGenerarDetalleEfectivo($id, $agencia);


            $tabladetalle.='<table border="1" style="width: 100%">
                       
                        <tr style="background-color: #C5D9F1; font-size: 12px;">
                          <td align="center"><b>Nro Factura</b></td>
                          <td align="center"><b>Efectivo</b></td>
                           
                        </tr> ';


            foreach ($detalle as $itemefectivo) {

                $tabladetalle.='
                         <tr>
                            <td align="center">' . $itemefectivo['NumeroFactura'] . '</td>
                            <td align="center">' . number_format($itemefectivo['Valor'], '2', ',', '.') . '</td>
                        </tr>    ';
            }
            $tabladetalle.='</table>';

            echo $tabladetalle;
        }
    }

    public function actionAjaxDetalleEfectivoConsignacion() {

        if ($_POST) {

            $id = $_POST['id'];
            $agencia = $_POST['agencia'];
            $tipoConsignacion = $_POST['tipoConsignacion'];

            $tabladetalle = "";

            $detalle = ReporteFzNoVentas::model()->getGenerarDetalleEfectivoConsignacion($id, $agencia, $tipoConsignacion);


            $tabladetalle.='<table border="1" style="width: 100%">
                       
                        <tr style="background-color: #C5D9F1; font-size: 12px;">
                          <td align="center"><b>Nro Factura</b></td>
                          <td align="center"><b>Nro/Voucher</b></td>
                           
                          <td align="center"><b>Cod Banco</b></td>
                          <td align="center"><b>Nombre Banco</b></td>
                           
                           <td align="center"><b>Cuenta</b></td>
                          <td align="center"><b>Fecha</b></td>
                           
                           <td align="center"><b>Valor</b></td>  
                        </tr> ';


            foreach ($detalle as $itemefectivoconsig) {

                $tabladetalle.='
                         <tr>
                            <td align="center">' . $itemefectivoconsig['NumeroFactura'] . '</td>
                            <td align="center">' . $itemefectivoconsig['NroConsignacionEfectivo'] . '</td>
                                
                            <td align="center">' . $itemefectivoconsig['CodBanco'] . '</td>
                            <td align="center">' . $itemefectivoconsig['Nombre'] . '</td>
                                
                            <td align="center">' . $itemefectivoconsig['CodCuentaBancaria'] . '</td>
                            <td align="center">' . $itemefectivoconsig['Fecha'] . '</td>
                                
                           <td align="center">' . number_format($itemefectivoconsig['Valor'], '2', ',', '.') . '</td>
                             
                            
                        </tr>    ';
            }
            $tabladetalle.='</table>';

            echo $tabladetalle;
        }
    }

    public function actionAjaxDetalleCheque() {

        if ($_POST) {

            $id = $_POST['id'];
            $agencia = $_POST['agencia'];

            $tabladetalle = "";

            $detalle = ReporteFzNoVentas::model()->getGenerarDetalleCheque($id, $agencia);


            $tabladetalle.='<table border="1" style="width: 100%">
                       
                        <tr style="background-color: #C5D9F1; font-size: 12px;">
                          <td align="center"><b>Nro Factura</b></td>
                          <td align="center"><b>Nro Cheque</b></td>
                           
                          <td align="center"><b>Cod Banco</b></td>
                          <td align="center"><b>Nombre Banco</b></td>
                            
                           <td align="center"><b>Cuenta</b></td>
                          <td align="center"><b>Fecha Cheque</b></td>
                           
                           <td align="center"><b>Girado a</b></td>
                           <td align="center"><b>Otro</b></td>
                           
                           <td align="center"><b>Valor</b></td>
                          
                           
                        </tr> ';


            foreach ($detalle as $itemecheque) {

                if ($itemecheque['IdentificadorBanco'] == "") {

                    $codigo = $itemecheque['CodBanco'];
                } else {

                    $codigo = $itemecheque['IdentificadorBanco'];
                }

                if ($itemecheque['Girado'] == 1) {

                    $NombreGirado = 'Altipal';
                } else {

                    $NombreGirado = '';
                }

                $tabladetalle.='
                         <tr>
                            <td align="center">' . $itemecheque['NumeroFactura'] . '</td>
                            <td align="center">' . $itemecheque['NroCheque'] . '</td>
                                
                            
                            <td align="center">' . $codigo . '</td>
                            <td align="center">' . $itemecheque['Nombre'] . '</td>
                                
                            <td align="center">' . $itemecheque['CuentaCheque'] . '</td>
                            <td align="center">' . $itemecheque['Fecha'] . '</td>
                                
                           <td align="center">' . $NombreGirado . '</td>
                           <td align="center">' . $itemecheque['Otro'] . '</td>
                           <td align="center">' . number_format($itemecheque['Valor'], '2', ',', '.') . '</td>
                           
                            
                        </tr>    ';
            }
            $tabladetalle.='</table>';

            echo $tabladetalle;
        }
    }

    public function actionAjaxDetalleChequeConsignacion() {

        if ($_POST) {

            $id = $_POST['id'];
            $agencia = $_POST['agencia'];

            $tabladetalle = "";

            $detalle = ReporteFzNoVentas::model()->getGenerarDetalleChequeConsignacion($id, $agencia);



            $tabladetalle.='<table border="1" style="width: 100%">
                       
                        <tr style="background-color: #8DB4E2; font-size: 12px;">
                          <td align="center"><b>Nro Factura</b></td>
                          <td align="center"><b>Nro Consignación</b></td>
                           
                          <td align="center"><b>Cod Banco</b></td>
                          <td align="center"><b>Nombre Banco</b></td>
                           
                          <td align="center"><b>Cuenta</b></td>
                          <td align="center"><b>Fecha Cheque</b></td>
                                 
                        </tr> ';


            foreach ($detalle as $itemechequeconsignacion) {


                $tabladetalle.='
                         <tr>
                            <td align="center">' . $itemechequeconsignacion['NumeroFactura'] . '</td>
                            <td align="center">' . $itemechequeconsignacion['NroConsignacionCheque'] . '</td>
                                
                            <td align="center">' . $itemechequeconsignacion['CodBanco'] . '</td>
                            <td align="center">' . $itemechequeconsignacion['Nombre'] . '</td>
                                
                            <td align="center">' . $itemechequeconsignacion['CodCuentaBancaria'] . '</td>
                            <td align="center">' . $itemechequeconsignacion['Fecha'] . '</td>
                           
                           
                            
                        </tr>    ';
            }
            $tabladetalle.='</table>';

            $tabladetalle.='<table border="1" style="width: 100%">
                       
                        <tr style="background-color: #C5D9F1; font-size: 12px;">
                          <td align="center"><b>Nro Cheque</b></td>
                          <td align="center"><b>Cod Banco</b></td>
                           
                          <td align="center"><b>Nombre Banco</b></td>
                          <td align="center"><b>Cuenta</b></td>
                           
                          <td align="center"><b>Fecha Cheque</b></td>
                          <td align="center"><b>Valor</b></td>
                                 
                        </tr> ';

            $detalleConsignacion = ReporteFzNoVentas::model()->getGenerarDetalleChequeConsignacionDetalle($id, $agencia);

            foreach ($detalleConsignacion as $itemechequeconsignaciondetalle) {

                $coadBanco = $itemechequeconsignaciondetalle['CodBanco'];

                $bancoGlobal = ReporteFzNoVentas::model()->getBancosGlobales($coadBanco);


                $Nombre = $bancoGlobal['Descripcion'];


                $tabladetalle.='
                         <tr>
                            <td align="center">' . $itemechequeconsignaciondetalle['NroChequeConsignacion'] . '</td>
                            <td align="center">' . $itemechequeconsignaciondetalle['CodBanco'] . '</td>
                                
                            <td align="center">' . $Nombre . '</td>
                            <td align="center">' . $itemechequeconsignaciondetalle['CuentaBancaria'] . '</td>
                                
                            <td align="center">' . $itemechequeconsignaciondetalle['Fecha'] . '</td>
                            <td align="center">' . number_format($itemechequeconsignaciondetalle['Valor'], '2', ',', '.') . '</td>
                           
                           
                            
                        </tr>    ';
            }
            $tabladetalle.='</table>';



            echo $tabladetalle;
        }
    }

    public function actionAjaxCargarGraficaVentasXProveedorAgencia() {

        if ($_POST) {

            $fecha = $_POST['fecha'];
            $gencia = $_POST['agencia'];

            $cedula = Yii::app()->getUser()->getState('_cedula');

            $Agencias = ReporteClientes::model()->getAgencias($cedula);
            $ventasproveedor = ReporteVistaLink::model()->getVentasProveedor();
            $Cajas = ReporteVistaLink::model()->getUnidadMedidaArticulos();
            $Categoria = ReporteVistaLink::model()->getCategoria();
            $proveedores = ReporteVistaLink::model()->getProveedores();
            $cargarcategoria = ReporteVistaLink::model()->getCargarCategorias();

            $reportecajaxAgencia = ReporteVistaLink::model()->getCargarGraficaAgenciaCaja($gencia, $fecha);
            $reporteventasprovedorxAgencia = ReporteVistaLink::model()->getCargarGraficaAgenciaVentasXProveedor($gencia, $fecha);
            $this->renderPartial('_RVistaLinkxAgencia', array(
                'reportecajaxAgencia' => $reportecajaxAgencia,
                'reporteventasprovedorxAgencia' => $reporteventasprovedorxAgencia,
                'Agencias' => $Agencias,
                'ventasproveedor' => $ventasproveedor,
                'cajas' => $Cajas,
                'categoria' => $Categoria,
                'proveedores' => $proveedores,
                'cargarcategoria' => $cargarcategoria
            ));
        }
    }

    public function actionAjaxCargarGraficaVentasXProveedorCanal() {

        if ($_POST) {

            $fecha = $_POST['fecha'];
            $agencia = $_POST['agencia'];
            $canal = $_POST['canal'];

            $cedula = Yii::app()->getUser()->getState('_cedula');

            $Agencias = ReporteClientes::model()->getAgencias($cedula);
            $ventasproveedor = ReporteVistaLink::model()->getVentasProveedor();
            $Cajas = ReporteVistaLink::model()->getUnidadMedidaArticulos();
            $Categoria = ReporteVistaLink::model()->getCategoria();
            $proveedores = ReporteVistaLink::model()->getProveedores();
            $cargarcategoria = ReporteVistaLink::model()->getCargarCategorias();


            $reportecajaxCanal = ReporteVistaLink::model()->getCargarGraficaCanalCaja($agencia, $fecha, $canal);
            $reporteventasprovedorxCanal = ReporteVistaLink::model()->getCargarGraficaCanalVentasxPorveedor($agencia, $fecha, $canal);
            $this->renderPartial('_RVistaLinkxCanal', array(
                'reportecajaxCanal' => $reportecajaxCanal,
                'reporteventasprovedorxCanal' => $reporteventasprovedorxCanal,
                'Agencias' => $Agencias,
                'ventasproveedor' => $ventasproveedor,
                'cajas' => $Cajas,
                'categoria' => $Categoria,
                'proveedores' => $proveedores,
                'cargarcategoria' => $cargarcategoria
            ));
        }
    }

    public function actionAjaxCargarGraficaVentasXProveedorGrupoVentas() {

        if ($_POST) {

            $fecha = $_POST['fecha'];
            $agencia = $_POST['agencia'];
            $grupo = $_POST['grupo'];

            $cedula = Yii::app()->getUser()->getState('_cedula');

            $Agencias = ReporteClientes::model()->getAgencias($cedula);
            $ventasproveedor = ReporteVistaLink::model()->getVentasProveedor();
            $Cajas = ReporteVistaLink::model()->getUnidadMedidaArticulos();
            $Categoria = ReporteVistaLink::model()->getCategoria();
            $proveedores = ReporteVistaLink::model()->getProveedores();
            $cargarcategoria = ReporteVistaLink::model()->getCargarCategorias();

            $reportecajaxGrupoVentas = ReporteVistaLink::model()->getCargarGraficaGrupoVentasCaja($agencia, $fecha, $grupo);
            $reporteventasprovedorxGrupoVentas = ReporteVistaLink::model()->getCargarGraficaPorGrupoVentasXProveedor($agencia, $fecha, $grupo);
            $this->renderPartial('_RVistaLinkxGrupoVentas', array(
                'reportecajaxGrupoVentas' => $reportecajaxGrupoVentas,
                'reporteventasprovedorxGrupoVentas' => $reporteventasprovedorxGrupoVentas,
                'Agencias' => $Agencias,
                'ventasproveedor' => $ventasproveedor,
                'cajas' => $Cajas,
                'categoria' => $Categoria,
                'proveedores' => $proveedores,
                'cargarcategoria' => $cargarcategoria
            ));
        }
    }

    public function actionAjaxCargarGraficaVentasXProveedorZonaVentas() {

        if ($_POST) {

            $fecha = $_POST['fecha'];
            $agencia = $_POST['agencia'];
            $zona = $_POST['zona'];

            $cedula = Yii::app()->getUser()->getState('_cedula');

            $Agencias = ReporteClientes::model()->getAgencias($cedula);
            $ventasproveedor = ReporteVistaLink::model()->getVentasProveedor();
            $Cajas = ReporteVistaLink::model()->getUnidadMedidaArticulos();
            $Categoria = ReporteVistaLink::model()->getCategoria();
            $proveedores = ReporteVistaLink::model()->getProveedores();
            $cargarcategoria = ReporteVistaLink::model()->getCargarCategorias();

            $reportecajaxZonaVentas = ReporteVistaLink::model()->getCargarGraficaZonaVentasCaja($agencia, $fecha, $zona);
            $reporteventasprovedorxZonaVentas = ReporteVistaLink::model()->getCargaGraficaZonaVentasProveedorxVentas($agencia, $fecha, $zona);
            $this->renderPartial('_RVistaLinkxZonaVentas', array(
                'reportecajaxZonaVentas' => $reportecajaxZonaVentas,
                'reporteventasprovedorxZonaVentas' => $reporteventasprovedorxZonaVentas,
                'Agencias' => $Agencias,
                'ventasproveedor' => $ventasproveedor,
                'cajas' => $Cajas,
                'categoria' => $Categoria,
                'proveedores' => $proveedores,
                'cargarcategoria' => $cargarcategoria
            ));
        }
    }

    public function actionAjaxCargarGraficaVentasXProveedorFecha() {

        if ($_POST) {

            $fecha = $_POST['fecha'];
            $agencia = $_POST['agencia'];

            $cedula = Yii::app()->getUser()->getState('_cedula');

            $Agencias = ReporteClientes::model()->getAgencias($cedula);
            $ventasproveedor = ReporteVistaLink::model()->getVentasProveedor();
            $Cajas = ReporteVistaLink::model()->getUnidadMedidaArticulos();
            $Categoria = ReporteVistaLink::model()->getCategoria();
            $proveedores = ReporteVistaLink::model()->getProveedores();
            $cargarcategoria = ReporteVistaLink::model()->getCargarCategorias();

            $reportecajaxFecha = ReporteVistaLink::model()->getCargarGraficaFechaCaja($agencia, $fecha);
            $reporteventasprovedorxFecha = ReporteVistaLink::model()->getCargaGraficaFechaVentasProveedorxVentas($agencia, $fecha);
            $this->renderPartial('_RVistaLinkxFecha', array(
                'reportecajaxFecha' => $reportecajaxFecha,
                'reporteventasprovedorxFecha' => $reporteventasprovedorxFecha,
                'Agencias' => $Agencias,
                'ventasproveedor' => $ventasproveedor,
                'cajas' => $Cajas,
                'categoria' => $Categoria,
                'proveedores' => $proveedores,
                'cargarcategoria' => $cargarcategoria
            ));
        }
    }

    /*
     * se crea la funcion para cargar la graficas Categoria,Grupo,Marcas por agencia y fecha
     * @_POST fecha
     * @_POST agencia
     */

    public function actionAjaxCargarCGMAgencia() {

        if ($_POST) {

            $agencia = $_POST['agencia'];
            $fecha = $_POST['fecha'];

            $CategoriaxAgencia = ReporteVistaLink::model()->getCategoriaxAgencia($agencia, $fecha);

            $this->renderPartial('_RVistaLinkCGMxAgencia', array(
                'CategoriaxAgencia' => $CategoriaxAgencia
            ));
        }
    }

    /*
     * se crea la funcion para cargar la graficas Categoria,Grupo,Marcas por Proveedor
     * @_POST agencia
     * @_POST fecha
     * @_POST proveedor
     */

    public function actionAjaxCargarCGMProveedor() {

        if ($_POST) {

            $agencia = $_POST['agencia'];
            $fecha = $_POST['fecha'];
            $proveedor = $_POST['proveedor'];

            $CategoriaxProveedor = ReporteVistaLink::model()->getCategoriaxProveedor($agencia, $fecha, $proveedor);

            $this->renderPartial('_RVistaLinkCGMxProveedor', array(
                'CategoriaxProveedor' => $CategoriaxProveedor
            ));
        }
    }

    /*
     * se crea la funcion donde se carga los grupos por categoria
     * @_POST categoria
     */

    public function actionAjaxCargarGrupos() {

        if ($_POST) {

            $categoria = $_POST['Categoria'];

            $Grupo = ReporteVistaLink::model()->getGrupos($categoria);

            $Grhtml.=' <select id="selectchosegrupos" name="Grupos" class="form-control chosen-select">';
            foreach ($Grupo as $itemGrupo) {

                $Grhtml.='
                     
                     <option  value="' . $itemGrupo['IdPrincipal'] . '">' . $itemGrupo['IdPrincipal'] . '</option>
                      ';
            }

            $Grhtml.='</select>';

            echo $Grhtml;
        }
    }

    /*
     * se crea la funcion para cargar las marcas
     * @_POST categoria
     * @_POST agencia
     */

    public function actionAjaxCargararcas() {

        if ($_POST) {

            $categoria = $_POST['Categoria'];
            $agencia = $_POST['agencia'];

            $Marca = ReporteVistaLink::model()->getMarcasCategoria($categoria, $agencia);

            $Marhtml.='<select id="selectchosemarcas" name="Marcas" class="form-control chosen-select" data-placeholder="Seleccione una marca"> <option value=""></option>';
            foreach ($Marca as $itemMarca) {

                $Marhtml.='
                     
                     <option  value="' . $itemMarca['CodigoMarca'] . '">' . $itemMarca['CodigoMarca'] . '</option>
                      ';
            }

            $Marhtml.='</select>';

            echo $Marhtml;
        }
    }

    /*
     * se crea la funcion para cargar las graficas categoria,grupos y marcas 
     * @_POST agencia
     * @_POST fecha
     * @_POST proveedor     
     */

    public function actionAjaxCargarCGMCategoria() {

        if ($_POST) {

            $agencia = $_POST['agencia'];
            $fecha = $_POST['fecha'];
            $categoria = $_POST['categoria'];

            $CategoriaxCategoria = ReporteVistaLink::model()->getCategoriaxCategoria($agencia, $fecha, $categoria);

            $this->renderPartial('_RVistaLinkCGMxCategoria', array(
                'CategoriaxCategoria' => $CategoriaxCategoria
            ));
        }
    }

    /*
     * se crea la funcion para cargar las categorias segun el proveedor
     * @_POST agencia
     * @_POST proveedor
     * 
     */

    public function actionAjaxCargarCategorias() {

        if ($_POST) {

            $proveedor = $_POST['proveedor'];
            $agencia = $_POST['agencia'];

            $categotia = ReporteVistaLink::model()->getCategoriaProveedor($agencia, $proveedor);

            $Cathtml.='<select id="selectchosecategoria" name="Categoria" class="form-control chosen-select" data-placeholder="Seleccione una categoria"> <option value=""></option>';
            foreach ($categotia as $itemCategoria) {

                $Cathtml.='
                     
                     <option  value="' . $itemCategoria['CodigoGrupoCategoria'] . '">' . $itemCategoria['CodigoGrupoCategoria'] . '</option>
                      ';
            }

            $Cathtml.='</select>';

            echo $Cathtml;
        }
    }

    /*
     * se crea la funcion para cargar la grafica de marcas
     * @_POST agencia
     * @_POST fecha
     * @_POST marca
     */

    public function actionAjaxCargarCGMMarcas() {

        if ($_POST) {

            $agencia = $_POST['agencia'];
            $fecha = $_POST['fecha'];
            $marca = $_POST['marca'];

            $CategoriaxMarca = ReporteVistaLink::model()->getCategoriaxMarca($agencia, $fecha, $marca);

            $this->renderPartial('_RVistaLinkCGMxMarca', array(
                'CategoriaxMarca' => $CategoriaxMarca
            ));
        }
    }

}
