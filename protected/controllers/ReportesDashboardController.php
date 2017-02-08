<?php

class ReportesDashboardController extends Controller {

    //public $modulo="";

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

    /*
     * se cargar el menu de reportes del dashboard
     */

    public function actionMenuDashboard() {


        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/reportedashboard/reporteDashboard.js', CClientScript::POS_END
        );


        $this->render('menuDashboard');
    }

    /*
     * se carga la tabla del reporte de notas tramitadas
     */

    public function actionAjaxTablaNotasTramitadas() {

        $this->renderPartial('_TablaReporteNotasTramitadas');
    }

    /*
     * se carga el reporte de notas tramitadas
     * @parameters @_GET
     * @_GET fechaini
     * @_GET fechafin
     * @return JSON
     */

    public function actionAjaxCargarReporteNotasTramitadas($fechaini = '', $fechafin = '', $Exportar = '') {


        if ($_GET['fechaini']) {

            $fechaini = $_GET['fechaini'];
            $fechafin = $_GET['fechafin'];
        }
        $notasTramitadas = ReporteDashboard::model()->getNotasTramitadas($fechaini, $fechafin);
        $indice = count($notasTramitadas);
        if ($indice > 0) {
            $ReporteNotasTramitadas = array();
            foreach ($notasTramitadas as $itemNotas) {

                $nombre = ReporteDashboard::model()->getNombreUsuario($itemNotas['QuienAutoriza']);
                if ($Exportar != "") {

                    if ($itemNotas['Autoriza'] == '1') {

                        $estado = "APROBADA";
                    } else {

                        $estado = "RECHAZADA";
                    }
                } else {

                    if ($itemNotas['Autoriza'] == '1') {

                        $estado = "<input type='button' class='btn btn-success' value='APROBADA'/>";
                    } else {

                        $estado = "<input type='button' class='btn btn-primary' value='RECHAZADA'/>";
                    }
                }

                $json = array(
                    'ZonaVentas' => $itemNotas['CodZonaVentas'],
                    'Asesor' => $itemNotas['NombreAsesor'],
                    'NombreGrupoVentas' => $itemNotas['NombreGrupoVentas'],
                    'NombreCanal' => $itemNotas['NombreCanal'],
                    'Fecha' => $itemNotas['Fecha'],
                    'Hora' => $itemNotas['Hora'],
                    'FechaAutorizacion' => $itemNotas['FechaAutorizacion'],
                    'HoraAutorizacion' => $itemNotas['HoraAutorizacion'],
                    'Valor' => $itemNotas['Valor'],
                    'Factura' => $itemNotas['Factura'],
                    'NombreConceptoNotaCredito' => $itemNotas['NombreConceptoNotaCredito'],
                    'NombreCliente' => $itemNotas['NombreCliente'],
                    'Comentario' => $itemNotas['Comentario'],
                    'ObservacionCartera' => $itemNotas['ObservacionCartera'],
                    'Estado' => $estado,
                    'ResponsableNota' => $itemNotas['responsableDocumento'],
                    'DsctoEspecialProveedor' => $itemNotas['DsctoEspecialProveedor'],
                    'NombreArticulo' => $itemNotas['NombreArticulo'],
                    'DsctoEspecialAltipal' => $itemNotas['DsctoEspecialAltipal'],
                    'DsctoEspecial' => $itemNotas['DsctoEspecial'],
                    'TipoConsulta' => $itemNotas['TipoConsulta'],
                    'IdDocumento' => $itemNotas['IdDocumento'],
                    'Cantidad' => $itemNotas['Cantidad']
                );

                array_push($ReporteNotasTramitadas, $json);
            }
            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($ReporteNotasTramitadas),
                "iTotalDisplayRecords" => count($ReporteNotasTramitadas),
                "aaData" => $ReporteNotasTramitadas);
            if ($Exportar != "") {
                return $ReporteNotasTramitadas;
            } else {
                echo json_encode($results);
            }
        } else {
            echo '0';
        }
    }

    /*
     * se cargar la tabla para notas pendientes
     */

    public function actionAjaxTablaNotasPendientes() {

        $this->renderPartial('_TablaReporteNotasPendientes');
    }

    /*
     * se carga el reporte de notas pendientes
     * @parameters @_GET
     * @_GET fechaini
     * @_GET fechafin
     * @return JSON
     */

    public function actionAjaxCargarReporteNotasPendientes($fechaini = '', $fechafin = '', $Exportar = '') {


        if ($_GET['fechaini']) {

            $fechaini = $_GET['fechaini'];
            $fechafin = $_GET['fechafin'];
        }

        $notasPendientes = ReporteDashboard::model()->getNotasPendientes($fechaini, $fechafin);


        $indice = count($notasPendientes);
        if ($indice > 0) {
            $ReporteNotasPendientes = array();
            foreach ($notasPendientes as $itemNotas) {

                if ($itemNotas['ResponsableNota'] == '1') {

                    $ReposableNota = 'Altipal';
                } else {

                    $ReposableNota = 'Proveedor';
                }

                if ($Exportar != "") {


                    if ($itemNotas['Autoriza'] == '0') {

                        $estado = "PENDIENTE";
                    }
                } else {

                    if ($itemNotas['Autoriza'] == '0') {

                        $estado = "<input type='button' class='btn btn-success' value='PENDIENTE'>";
                    }
                }


                if ($itemNotas['NombreCuentaProveedor'] == null || $itemNotas['NombreCuentaProveedor'] == "") {

                    $proveedor = "Sin Proveedor";
                } else {

                    $proveedor = $itemNotas['NombreCuentaProveedor'];
                }

                $json = array(
                    'ZonaVentas' => $itemNotas['CodZonaVentas'],
                    'Asesor' => $itemNotas['NombreAsesor'],
                    'NombreGrupoVentas' => $itemNotas['NombreGrupoVentas'],
                    'NombreCanal' => $itemNotas['NombreCanal'],
                    'NombreCliente' => $itemNotas['NombreCliente'],
                    'NombreBusqueda' => $itemNotas['NombreBusqueda'],
                    'NombreCiudad' => $itemNotas['NombreCiudad'],
                    'NombreCuentaProveedor' => $proveedor,
                    'Fecha' => $itemNotas['Fecha'],
                    'Hora' => $itemNotas['Hora'],
                    'Valor' => $itemNotas['Valor'],
                    'Factura' => $itemNotas['Factura'],
                    'NombreConceptoNotaCredito' => $itemNotas['NombreConceptoNotaCredito'],
                    'Comentario' => $itemNotas['Comentario'],
                    'ObservacionCartera' => $itemNotas['ObservacionCartera'],
                    'Estado' => $estado,
                    'ResponsableNota' => $ReposableNota,
                );

                array_push($ReporteNotasPendientes, $json);
            }

            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($ReporteNotasPendientes),
                "iTotalDisplayRecords" => count($ReporteNotasPendientes),
                "aaData" => $ReporteNotasPendientes);
            if ($Exportar != "") {

                return $ReporteNotasPendientes;
            } else {

                echo json_encode($results);
            }
        } else {
            echo '0';
        }
    }

    /*
     * se cargar la tabla para reporte de devolcuiones
     */

    public function actionAjaxTablaDevoluciones() {

        $this->renderPartial('_TablaReporteDevoluciones');
    }

    /*
     * se carga el reporte de devolcuiones
     * @parameters @_GET
     * @_GET fechaini
     * @_GET fechafin
     * @return JSON
     */

    public function actionAjaxCargarReporteDevoluciones($fechaini = '', $fechafin = '', $Exportar = '') {


        if ($_GET['fechaini']) {

            $fechaini = $_GET['fechaini'];
            $fechafin = $_GET['fechafin'];
        }

        $Devolciones = ReporteDashboard::model()->getDevoluciones($fechaini, $fechafin);


        $ReporteDevoluciones = array();
        foreach ($Devolciones as $itemDevoluciones) {

            if ($Exportar != "") {

                if ($itemDevoluciones['Autoriza'] == '1') {

                    $Autoriza = 'Autorizada';
                } elseif ($itemDevoluciones['Autoriza'] == '2') {

                    $Autoriza = 'Rechzada';
                }
            } else {


                if ($itemDevoluciones['Autoriza'] == '1') {

                    $Autoriza = '<input value="Autorizada" class="btn btn-success" disabled>';
                } elseif ($itemDevoluciones['Autoriza'] == '2') {

                    $Autoriza = '<input value="Rechazada" class="btn btn-danger" disabled>';
                }
            }
            $nombreAutoriza = ReporteDashboard::model()->getNombreUsuario($itemDevoluciones['QuienAutoriza']);
            $json = array(
                'Responsable' => $nombreAutoriza[0]['Nombre'],
                'Asesor' => $itemDevoluciones['NombreAsesor'],
                'NombreGrupoVentas' => $itemDevoluciones['NombreGrupoVentas'],
                'NombreCliente' => $itemDevoluciones['NombreCliente'],
                'ValorDevolucion' => number_format($itemDevoluciones['ValorDevolucion'], '2', ',', '.'),
                'TotalDevolucion' => $itemDevoluciones['TotalDevolucion'],
                'Comentario' => $itemDevoluciones['Comentario'],
                'FechaAutorizacion' => $itemDevoluciones['FechaAutorizacion'],
                'Autoriza' => $Autoriza,
                'Detalle' => '<input type="button" class="btn btn-primary" value="Detalle" onclick="verdetalle(' . $itemDevoluciones['IdDevolucion'] . ',  ' . "'" . $itemDevoluciones['CodAgencia'] . "'" . ')">'
            );

            array_push($ReporteDevoluciones, $json);
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($ReporteDevoluciones),
            "iTotalDisplayRecords" => count($ReporteDevoluciones),
            "aaData" => $ReporteDevoluciones);


        if ($Exportar != "") {

            return $ReporteDevoluciones;
        } else {

            echo json_encode($results);
        }
    }

    /*
     * se carga la tabla dettale devolciones
     */

    public function actionAjaxDetalleTablaDevoluciones() {

        $this->renderPartial('_TablaDetalleDevoluciones');
    }

    /*
     * se carga el detalle de devolcuiones
     * @parameters @_GET
     * @_GET fechaini
     * @_GET fechafin
     * @return JSON
     */

    public function actionAjaxCargarDetalleDevoluciones() {


        if ($_GET) {

            $id = $_GET['id'];
            $agencia = $_GET['agencia'];

            /* echo $agencia;
              exit(); */

            $DevolcionesDetalle = ReporteDashboard::model()->getDevolucionesDetalle($id, $agencia);

            /* echo '<pre>';
              print_r($DevolcionesDetalle); */

            $DetalleDevoluciones = array();
            foreach ($DevolcionesDetalle as $itemDevoluciones) {

                $json = array(
                    'NombreArticulo' => $itemDevoluciones['NombreArticulo'],
                    'Cantidad' => $itemDevoluciones['Cantidad'],
                    'ValorUnitario' => number_format($itemDevoluciones['ValorUnitario'], '2', ',', '.'),
                    'NombreUnidadMedida' => $itemDevoluciones['NombreUnidadMedida'],
                    'ValorTotalProducto' => number_format($itemDevoluciones['ValorTotalProducto'], '2', ',', '.'),
                    'NombreMotivoDevolucion' => $itemDevoluciones['NombreMotivoDevolucion']
                );

                array_push($DetalleDevoluciones, $json);
            }

            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($DetalleDevoluciones),
                "iTotalDisplayRecords" => count($DetalleDevoluciones),
                "aaData" => $DetalleDevoluciones);


            echo json_encode($results);
        }
    }

    public function actionAjaxGraficosNotas() {


        if ($_POST) {


            $fechaIni = $_POST['fechaIni'];
            $fechaFin = $_POST['fechaFin'];

            $DirectorComercial = ReporteDashboard::model()->getAdministradoresDirectorComercial();
            $ArrayDirectorComercial = array();
            foreach ($DirectorComercial as $itemComercial) {
                $NotasCreditoGrupoVentas = ReporteDashboard::model()->getNotasCreditoDirectorComercialTransmitidas($itemComercial['Cedula'], $itemComercial['Usuario'], $fechaIni, $fechaFin);
                array_push($ArrayDirectorComercial, $NotasCreditoGrupoVentas);
            }

            ///ADMINISTRADOR ALTIAL (GERENTE)

            $Gerentes = ReporteDashboard::model()->AdministradoresGerente();
            $arrayGerente = array();
            foreach ($Gerentes as $itemGerente) {
                $NotasCreditoGrupoVentasGerente = ReporteDashboard::model()->getValorNotasCreditoDirectorComercialGestionadas($itemGerente['Cedula'], $itemGerente['Usuario'], $fechaIni, $fechaFin);
                array_push($arrayGerente, $NotasCreditoGrupoVentasGerente);
            }

            ///ADMIN CARTERA (CARTERA)

            $Cartera = ReporteDashboard::model()->AdministradoresCartera();

            $arrayCartera = array();
            foreach ($Cartera as $itemCartera) {
                $NotasCreditoGrupoVentasCartera = ReporteDashboard::model()->getNotasCreditoDirectorComercialTransmitidasTimeOut($itemCartera['Cedula'], $itemCartera['Usuario'], $fechaIni, $fechaFin);
                array_push($arrayCartera, $NotasCreditoGrupoVentasCartera);
            }


            $this->renderPartial('_NotasGraficas', array('NotasDirectorComercial' => $ArrayDirectorComercial,
                'NotasGerentes' => $arrayGerente, 'NotasCartera' => $arrayCartera));
        }
    }

    public function actionAjaxValoresNotasAprobadas() {


        if ($_POST) {

            $feini = $_POST['fechaIni'];
            $fefin = $_POST['fechaFin'];

            $Grupos = ReporteDashboard::model()->getGrupoVentas();

            $arrayPuhs = array();
            foreach ($Grupos as $item) {
                $Nota = ReporteDashboard::model()->getNotas($item['CodigoGrupoVentas'], $feini, $fefin);

                foreach ($Nota as $ItemN) {

                    $arrayNotas = array(
                        'GrupoVentas' => $ItemN['NombreGrupoVentas'],
                        'Valor' => $ItemN['notas'],
                        'CodGrupo' => $ItemN['CodigoGrupoVentas']
                    );

                    array_push($arrayPuhs, $arrayNotas);
                }
            }

            $arrayGrupo = array();
            foreach ($arrayPuhs as $item) {
                array_push($arrayGrupo, $item['GrupoVentas']);
            }
            $arrayGruposUni = array_unique($arrayGrupo);



            $GruposCompletosCompletos = array();

            foreach ($arrayGruposUni as $grupos) {
                $ValorGrupos = 0;
                $NombreGrupos = "";
                foreach ($arrayPuhs as $item) {
                    if ($grupos == $item['GrupoVentas']) {
                        $ValorGrupos+=$item['Valor'];
                        $NombreGrupos = $item['GrupoVentas'];
                        $CodigoGrupos = $item['CodGrupo'];
                    }
                }
                array_push($GruposCompletosCompletos, array('ValorNotasGrupo' => $ValorGrupos, 'NombreGrupos' => $NombreGrupos, 'CodigoGrupos' => $CodigoGrupos));
            }

            $this->renderPartial('_GrupoVentasGraficas', array('NotasAprobasGrupoVentas' => $GruposCompletosCompletos));
        }
    }

    /*
     * se carga la tabla descuentos pendientes
     */

    public function actionAjaxTablaDescuentsPendientes() {

        $this->renderPartial('_TablaReporteDescuentosPendientes');
    }

    /*
     * se carga los descuentos pendientes
     * @parameters @_GET
     * @_GET fechaini
     * @_GET fechafin
     * @return JSON
     */

    public function actionAjaxCargarReporteDescuentosPendientes($fechaini = '', $fechafin = '', $Exportar = '') {

        if ($_GET['fechaini']) {

            $fechaini = $_GET['fechaini'];
            $fechafin = $_GET['fechafin'];
        }
        $quienfaltaporAutorizar = "";
        $DescuentosPendientes = ReporteDashboard::model()->getDescuentosPendientes($fechaini, $fechafin);

        $ReporteDescuentosPendientes = array();
        foreach ($DescuentosPendientes as $itemDescuentos) {

            //Se valida quien autoriza los descuentos para saber quien falta
            //$quienAutorizaDescuento = $itemDescuentos['QuienAutorizaDscto'];
            $descuentoAltipal = $itemDescuentos['DsctoEspecialAltipal'];
            $descuentoProveedor = $itemDescuentos['DsctoEspecialProveedor'];
            $idPedidoDetalle = $itemDescuentos['idDetallePedido'];
            /* echo $quienAutorizaDescuento;
              echo '<br />';
              echo $estadoAutorizadoProveedor;
              echo '<br />';
              echo $estadoAutorizadoAltipal;
              echo '<br />'; */

            if ($descuentoAltipal > 0 && $descuentoProveedor > 0) {
                $itemDisconunt = ReporteDashboard::model()->getItemDiscount($idPedidoDetalle);

                if (count($itemDisconunt) > 0) {
                    foreach ($itemDescuentos as $item) {

                        if ($item['EstadoRevisadoAltipal'] > 0) {
                            $quienfaltaporAutorizar = "Altipal";
                        } else {

                            $quienfaltaporAutorizar = $itemDescuentos['NombreCuentaProveedor'];
                        }
                    }
                } else {
                    $quienfaltaporAutorizar = "Altipal  y  " . $itemDescuentos['NombreCuentaProveedor'];
                }
            } else if ($descuentoAltipal == 0 && $descuentoProveedor > 0) {
                $quienfaltaporAutorizar = $itemDescuentos['NombreCuentaProveedor'];
            } else if ($descuentoAltipal > 0 && $descuentoProveedor == 0) {
                $quienfaltaporAutorizar = "Altipal";
            }

            /* if($quienAutorizaDescuento == 3){
              if($estadoAutorizadoProveedor == 0 && $estadoAutorizadoAltipal == 0){
              $quienfaltaporAutorizar = "Altipal y Proveedor";
              }else if($estadoAutorizadoProveedor == 0 && $estadoAutorizadoAltipal == 1){
              $quienfaltaporAutorizar = "Proveedor";
              }else if($estadoAutorizadoProveedor == 1 && $estadoAutorizadoAltipal == 1){
              $cant++;
              continue;
              }else{
              $quienfaltaporAutorizar = "Altipal";
              }
              }else if($quienAutorizaDescuento == 2) {
              $quienfaltaporAutorizar = "Proveedor";
              }else if($quienAutorizaDescuento == ''){
              if($itemDescuentos['DsctoEspecialProveedor'] > 0 && $itemDescuentos['$itemDescuentos'] > 0){
              $quienfaltaporAutorizar = "Altipal y Proveedor";
              }
              elseif ($itemDescuentos['DsctoEspecialProveedor'] > 0){
              $quienfaltaporAutorizar = "Proveedor";
              }else{
              $quienfaltaporAutorizar = "Altipal";
              }
              }else{
              if($estadoAutorizadoAltipal == 1){
              continue;
              }
              $quienfaltaporAutorizar = "Altipal";
              } */

            $json = array(
                'IdPedido' => $itemDescuentos['IdPedido'],
                'NombreCliente' => $itemDescuentos['NombreCliente'],
                'razonsoscial' => $itemDescuentos['razonsoscial'],
                'NombreCiudad' => $itemDescuentos['NombreCiudad'],
                'nombreAsesor' => $itemDescuentos['nombreAsesor'],
                'NombreGrupoVentas' => $itemDescuentos['NombreGrupoVentas'],
                'NombreCanal' => $itemDescuentos['NombreCanal'],
                'NombreArticulo' => $itemDescuentos['NombreArticulo'],
                'NombreUnidadMedida' => $itemDescuentos['NombreUnidadMedida'],
                'Cantidad' => $itemDescuentos['Cantidad'],
                'DsctoEspecialAltipal' => $itemDescuentos['DsctoEspecialAltipal'],
                'DsctoEspecialProveedor' => $itemDescuentos['DsctoEspecialProveedor'],
                'QuienfaltaporAutorizar' => $quienfaltaporAutorizar
            );

            array_push($ReporteDescuentosPendientes, $json);
        }


        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($ReporteDescuentosPendientes),
            "iTotalDisplayRecords" => count($ReporteDescuentosPendientes),
            "aaData" => $ReporteDescuentosPendientes);

        if ($Exportar != "") {

            return $ReporteDescuentosPendientes;
        } else {

            echo json_encode($results);
        }
    }

    /*
     * se carga la tabla descuentos aprovados por proveedor
     */

    public function actionAjaxTablaDescuentosAprobvadosPorProveedor() {

        $this->renderPartial('_TablaReporteDescuentosAprovadosProveedor');
    }

    /*
     * se carga los descuentos aprobados por proveedor
     * @parameters @_GET
     * @_GET fechaini
     * @_GET fechafin
     * @return JSON
     */

    public function actionAjaxCargarReporteDescuentosAprobadosProveedor($fechaini = '', $fechafin = '', $Exportar = '') {

        if ($_GET['fechaini']) {

            $fechaini = $_GET['fechaini'];
            $fechafin = $_GET['fechafin'];
        }

        $DescuentosAprobadosPro = ReporteDashboard::model()->getDescuentosAprobadosProveedor($fechaini, $fechafin);

        $ReporteDescuentosAprobados = array();
        $consulta = new Multiple();
        foreach ($DescuentosAprobadosPro as $itemDescuentosApro) {

            $proveedor = $consulta->getNombreProveedor($itemDescuentosApro['CuentaProveedor']);

            $json = array(
                'IdPedido' => $itemDescuentosApro['IdPedido'],
                'NombreCliente' => $itemDescuentosApro['NombreCliente'],
                'razonsoscial' => $itemDescuentosApro['razonsoscial'],
                'NombreCiudad' => $itemDescuentosApro['NombreCiudad'],
                'nombreAsesor' => $itemDescuentosApro['nombreAsesor'],
                'NombreGrupoVentas' => $itemDescuentosApro['NombreGrupoVentas'],
                'NombreCanal' => $itemDescuentosApro['NombreCanal'],
                'NombreArticulo' => $itemDescuentosApro['NombreArticulo'],
                'NombreUnidadMedida' => $itemDescuentosApro['NombreUnidadMedida'],
                'Cantidad' => $itemDescuentosApro['Cantidad'],
                'DsctoEspecialProveedor' => $itemDescuentosApro['DsctoEspecialProveedor'],
                'proveedor' => $proveedor[0]['NombreCuentaProveedor']
            );

            array_push($ReporteDescuentosAprobados, $json);
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($ReporteDescuentosAprobados),
            "iTotalDisplayRecords" => count($ReporteDescuentosAprobados),
            "aaData" => $ReporteDescuentosAprobados);

        if ($Exportar != "") {

            return $ReporteDescuentosAprobados;
        } else {

            echo json_encode($results);
        }
    }

    /*
     * se carga la tabla del reporte de notas aprobadas por cartera
     */

    public function actionAjaxTablaNotasCreditoAprobvadosPorCartera() {

        $this->renderPartial('_TablaReporteNotasAprovadasPorCartera');
    }

    /*
     * se carga el reporte de notas aprobadas por cartera
     * @parameters @_GET
     * @_GET fechaini
     * @_GET fechafin
     * @return JSON
     */

    public function actionAjaxCargarReporteNotasCreditoAprobvadosPorCartera($fechaini = '', $fechafin = '', $Exporta = '') {


        if ($_GET['fechaini']) {

            $fechaini = $_GET['fechaini'];
            $fechafin = $_GET['fechafin'];
        }

        $notasTramitadasCartera = ReporteDashboard::model()->getNotasTramitadasCartera($fechaini, $fechafin);

        $grabaciones = glob("{../Grabacion/*.mp3}", GLOB_BRACE);
        foreach ($grabaciones as $itemGravaciones) {

            $fechArchivoAudio = date("Y-m-d H:i:s", filemtime($itemGravaciones));

            $Audio = '<audio controls>
                 <source src="' . $itemGravaciones . '" type="audio/mp3">
                     </audio>';

            if ($coun >= 1) {
                break;
            }
            $coun = $coun + 1;
        }


        $ReporteNotasTramitadasCartera = array();
        foreach ($notasTramitadasCartera as $itemNotasCartera) {

            $responsables = ReporteDashboard::model()->getResponsables($itemNotasCartera['Concepto']);


            $NombreResponsable = "";
            foreach ($responsables as $ItemReposable) {

                if ($Exporta != "") {

                    $NombreResponsable .= $ItemReposable['Nombres'] . ',';
                } else {

                    $NombreResponsable .= $ItemReposable['Nombres'] . "<br/>";
                }
            }


            if ($Exporta != "") {

                if ($itemNotasCartera['Autoriza'] == '1') {

                    $estado = "APROBADA";
                } elseif ($itemNotasCartera['Autoriza'] == '2') {

                    $estado = "RECHAZADA";
                }
            } else {

                if ($itemNotasCartera['Autoriza'] == '1') {

                    $estado = "<label class='text-primary'>APROBADA</label>";
                } elseif ($itemNotasCartera['Autoriza'] == '2') {

                    $estado = "<label class='text-danger'>RECHAZADA</label>";
                }
            }



            $json = array(
                'ZonaVentas' => $itemNotasCartera['CodZonaVentas'],
                'Asesor' => $itemNotasCartera['NombreAsesor'],
                'NombreGrupoVentas' => $itemNotasCartera['NombreGrupoVentas'],
                'NombreCliente' => $itemNotasCartera['NombreCliente'],
                'NombreConceptoNotaCredito' => $itemNotasCartera['NombreConceptoNotaCredito'],
                'Fecha' => $itemNotasCartera['Fecha'],
                'Hora' => $itemNotasCartera['Hora'],
                'Autoriza' => $itemNotasCartera['QuienAutoriza'],
                'FechaAutorizacion' => $itemNotasCartera['FechaAutorizacion'],
                'HoraAutorizacion' => $itemNotasCartera['HoraAutorizacion'],
                'Valor' => $itemNotasCartera['Valor'],
                'Factura' => $itemNotasCartera['Factura'],
                'Comentario' => $itemNotasCartera['Comentario'],
                'ObservacionCartera' => $itemNotasCartera['ObservacionCartera'],
                'Estado' => $estado,
                'ResponsableNota' => $NombreResponsable,
                'Audio' => $Audio
            );


            array_push($ReporteNotasTramitadasCartera, $json);
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($ReporteNotasTramitadasCartera),
            "iTotalDisplayRecords" => count($ReporteNotasTramitadasCartera),
            "aaData" => $ReporteNotasTramitadasCartera);

        if ($Exporta != "") {

            return $ReporteNotasTramitadasCartera;
        } else {

            echo json_encode($results);
        }
    }

    /*
     * se carga la tabla de descuentos fuera del rango
     */

    public function actionAjaxTablaDescuentoFueradelRango() {

        $this->renderPartial('_TablaDescuentosFueraDelRango');
    }

    /*
     * se carga el reporte de descuentos por fuera del rango
     * @parameters @_GET
     * @_GET fechaini
     * @_GET fechafin
     * @return JSON
     */

    public function actionAjaxCargarReporteDescuentoFueradelRango($fechaini = '', $fechafin = '', $Exporta = '') {

        if ($_GET['fechaini']) {

            $fechaini = $_GET['fechaini'];
            $fechafin = $_GET['fechafin'];
        }

        $DescuentosFueraRango = ReporteDashboard::model()->getDescuentosFueraDelRango($fechaini, $fechafin);

        $ReporteDescuentosFueradeRango = array();
        foreach ($DescuentosFueraRango as $itemFuerarango) {

            if ($itemFuerarango['QuienAutorizaDscto'] == 4) {

                $cartera = 'Cartera';
            }

            $json = array(
                'IdPedido' => $itemFuerarango['IdPedido'],
                'NombreCliente' => $itemFuerarango['NombreCliente'],
                'razonsoscial' => $itemFuerarango['razonsoscial'],
                'NombreCiudad' => $itemFuerarango['NombreCiudad'],
                'nombreAsesor' => $itemFuerarango['nombreAsesor'],
                'NombreGrupoVentas' => $itemFuerarango['NombreGrupoVentas'],
                'ValorPedido' => number_format($itemFuerarango['ValorPedido'], '2', ',', '.'),
                'Cantidad' => $itemFuerarango['TotalPedido'],
                'FechaPedido' => $itemFuerarango['FechaPedido'],
                'FechaAutorizaAltipal' => $itemFuerarango['FechaAutorizaAltipal'],
                'NombreAutorizoDsctoAltipal' => $itemFuerarango['NombreAutorizoDsctoAltipal'],
                'Cartera' => $cartera,
            );

            array_push($ReporteDescuentosFueradeRango, $json);
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($ReporteDescuentosFueradeRango),
            "iTotalDisplayRecords" => count($ReporteDescuentosFueradeRango),
            "aaData" => $ReporteDescuentosFueradeRango);

        if ($Exporta != "") {

            return $ReporteDescuentosFueradeRango;
        } else {

            echo json_encode($results);
        }
    }

    public function actionAjaxGraficosNotasTimeOut() {

        if ($_POST) {


            $fechaIni = $_POST['fechaIni'];
            $fechaFin = $_POST['fechaFin'];

            ///DIRECTOR COMERCIAL

            $UsuariosDirectorComercial = ReporteDashboard::model()->getAdministradoresDirectorComercial();
            $array = array();
            foreach ($UsuariosDirectorComercial as $itemComercial) {
                $NotasCreditoGrupoVentasPorTimeout = ReporteDashboard::model()->getNotasCreditoDirectorComercialTransmitidasTimeOut($itemComercial['Cedula'], $fechaIni, $fechaFin);
                array_push($array, $NotasCreditoGrupoVentasPorTimeout);
            }


            ///ADMINISTRADOR ALTIAL (GERENTE)

            $UsuariosGerentes = ReporteDashboard::model()->AdministradoresGerente();

            $arrayGerente = array();
            foreach ($UsuariosGerentes as $itemUserGerente) {
                $NotasCreditoGrupoVentasPorTimeoutGerente = ReporteDashboard::model()->getNotasCreditoDirectorComercialTransmitidasTimeOut($itemUserGerente['Cedula'], $fechaIni, $fechaFin);
                array_push($arrayGerente, $NotasCreditoGrupoVentasPorTimeoutGerente);
            }


            ///ADMIN CARTERA (CARTERA)


            $UsuariosCartera = ReporteDashboard::model()->AdministradoresCartera();

            $arrayCartera = array();
            foreach ($UsuariosCartera as $itemUserCartera) {
                $NotasCreditoGrupoVentasPorTimeoutCartera = ReporteDashboard::model()->getNotasCreditoDirectorComercialTransmitidasTimeOut($itemUserCartera['Cedula'], $fechaIni, $fechaFin);
                array_push($arrayCartera, $NotasCreditoGrupoVentasPorTimeoutCartera);
            }



            $this->renderPartial('_NotasTramitadasAsignadasPorTimeOut', array('NotasDirectorComercialTimeOut' => $array, 'NotasGerentesTimeOut' => $arrayGerente, 'NotasCarteraTimeOut' => $arrayCartera));
        }
    }

    public function actionAjaxGraficosNotasGestinadasTimeOut() {

        if ($_POST) {

            $fechaIni = $_POST['fechaIni'];
            $fechFin = $_POST['fechaFin'];

            $Aprobadas = ReporteDashboard::model()->getNotasAprobadasCartera($fechaIni, $fechFin);
            $Rechazadas = ReporteDashboard::model()->getNotasRechazadasCartera($fechaIni, $fechFin);


            $NotasGestinadas = array(
                'Aprobadas' => $Aprobadas,
                'Rechazadas' => $Rechazadas
            );


            if ($Aprobadas == '0' && $Rechazadas == '0') {

                echo '1';
            } else {

                $this->renderPartial('_NotasGestionadasTimeOut', array('NotasGestinadas' => $NotasGestinadas));
            }
        }
    }

    public function actionAjaxNotasTramitadasExcel() {


        $fechaini = $_POST['fechaIni'];
        $fechafin = $_POST['fechaFin'];
        $Exportar = '1';

        $NotasTramitadasExcel = $this->actionAjaxCargarReporteNotasTramitadas($fechaini, $fechafin, $Exportar);

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        Yii::import('ext.phpexcel.XPHPExcel');
        spl_autoload_register(array('YiiBase', 'autoload'));

        /** PHPExcel_Writer_Excel2007 */
        $objPHPExcel = XPHPExcel::createPHPExcel();
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                ->setLastModifiedBy("Maarten Balliauw")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");


        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Codigo Zona Ventas')
                ->setCellValue('B1', 'Nombre Asesor')
                ->setCellValue('C1', 'Grupo Ventas')
                ->setCellValue('D1', 'Canal')
                ->setCellValue('E1', 'Fecha Nota')
                ->setCellValue('F1', 'Hora Notas')
                ->setCellValue('G1', 'Fecha Autorizacion')
                ->setCellValue('H1', 'Hora Autorizacion')
                ->setCellValue('I1', 'Valor')
                ->setCellValue('J1', 'Factura')
                ->setCellValue('K1', 'Concepto')
                ->setCellValue('L1', 'Cliente')
                ->setCellValue('M1', 'Comentario')
                ->setCellValue('N1', 'Observacion Cartera')
                ->setCellValue('O1', 'Estado')
                ->setCellValue('P1', 'Responsable');


        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('G1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('I1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('J1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('J1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('K1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('L1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('M1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('N1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('O1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('P1')->getFont()
                ->setBold(true);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);


        $cont = 1;
        foreach ($NotasTramitadasExcel as $row) {
            $cont ++;

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $cont, $row['ZonaVentas'])
                    ->setCellValue('B' . $cont, $row['Asesor'])
                    ->setCellValue('C' . $cont, $row['NombreGrupoVentas'])
                    ->setCellValue('D' . $cont, $row['NombreCanal'])
                    ->setCellValue('E' . $cont, $row['Fecha'])
                    ->setCellValue('F' . $cont, $row['Hora'])
                    ->setCellValue('G' . $cont, $row['FechaAutorizacion'])
                    ->setCellValue('H' . $cont, $row['HoraAutorizacion'])
                    ->setCellValue('I' . $cont, $row['Valor'])
                    ->setCellValue('J' . $cont, $row['Factura'])
                    ->setCellValue('K' . $cont, $row['NombreConceptoNotaCredito'])
                    ->setCellValue('L' . $cont, $row['NombreCliente'])
                    ->setCellValue('M' . $cont, $row['Comentario'])
                    ->setCellValue('N' . $cont, $row['ObservacionCartera'])
                    ->setCellValue('O' . $cont, $row['Estado'])
                    ->setCellValue('P' . $cont, $row['ResponsableNota']);
        }


        $dir = 'ReporteDashboardExcel';
        if (!is_dir($dir)) {
            mkdir($dir);
        }

        $file = (string) (date("Y-m-d") . '_' . date("H-i-s") . '_' . 'NotasTramitadas' . '.xls');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save($dir . '/' . $file);

        $link = "http://altipal.datosmovil.info/altipalAx/ReporteDashboardExcel/" . $file;
        echo $link;
    }

    public function actionAjaxNotasPendientesPorAutorizarExcel() {

        $fechaini = $_POST['fechaIni'];
        $fechafin = $_POST['fechaFin'];
        $Exportar = '1';

        $NotasPendientesPorAutorizarExcel = $this->actionAjaxCargarReporteNotasPendientes($fechaini, $fechafin, $Exportar);

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        Yii::import('ext.phpexcel.XPHPExcel');
        spl_autoload_register(array('YiiBase', 'autoload'));

        /** PHPExcel_Writer_Excel2007 */
        $objPHPExcel = XPHPExcel::createPHPExcel();
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                ->setLastModifiedBy("Maarten Balliauw")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");


        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Codigo Zona Ventas')
                ->setCellValue('B1', 'Nombre Asesor')
                ->setCellValue('C1', 'Grupo Ventas')
                ->setCellValue('D1', 'Canal')
                ->setCellValue('E1', 'Cliente')
                ->setCellValue('F1', 'Razon Social')
                ->setCellValue('G1', 'Ciudad')
                ->setCellValue('H1', 'Nombre Proveedor')
                ->setCellValue('I1', 'Fecha Nota')
                ->setCellValue('J1', 'Hora Nota')
                ->setCellValue('K1', 'Valor')
                ->setCellValue('L1', 'Factura')
                ->setCellValue('M1', 'Concepto')
                ->setCellValue('N1', 'Comentario')
                ->setCellValue('O1', 'Observacion Cartera')
                ->setCellValue('P1', 'Estado')
                ->setCellValue('Q1', 'Responsable');


        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('G1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('H1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('I1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('J1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('K1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('L1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('M1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('N1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('O1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('P1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('Q1')->getFont()
                ->setBold(true);


        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);


        $cont = 1;
        foreach ($NotasPendientesPorAutorizarExcel as $row) {
            $cont ++;

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $cont, $row['ZonaVentas'])
                    ->setCellValue('B' . $cont, $row['Asesor'])
                    ->setCellValue('C' . $cont, $row['NombreGrupoVentas'])
                    ->setCellValue('D' . $cont, $row['NombreCanal'])
                    ->setCellValue('E' . $cont, $row['NombreCliente'])
                    ->setCellValue('F' . $cont, $row['NombreBusqueda'])
                    ->setCellValue('G' . $cont, $row['NombreCiudad'])
                    ->setCellValue('H' . $cont, $row['NombreCuentaProveedor'])
                    ->setCellValue('I' . $cont, $row['Fecha'])
                    ->setCellValue('J' . $cont, $row['Hora'])
                    ->setCellValue('K' . $cont, $row['Valor'])
                    ->setCellValue('L' . $cont, $row['Factura'])
                    ->setCellValue('M' . $cont, $row['NombreConceptoNotaCredito'])
                    ->setCellValue('N' . $cont, $row['Comentario'])
                    ->setCellValue('O' . $cont, $row['ObservacionCartera'])
                    ->setCellValue('P' . $cont, $row['Estado'])
                    ->setCellValue('Q' . $cont, $row['ResponsableNota']);
        }



        $dir = 'ReporteDashboardExcel';
        if (!is_dir($dir)) {
            mkdir($dir);
        }

        $file = (string) (date("Y-m-d") . '_' . date("H-i-s") . '_' . 'NotasPendientesPorAutorizarExcel' . '.xls');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save($dir . '/' . $file);

        $link = "http://altipal.datosmovil.info/altipalAx/ReporteDashboardExcel/" . $file;
        echo $link;
    }

    public function actionAjaxDevolucionesExcel() {

        $fechaini = $_POST['fechaIni'];
        $fechafin = $_POST['fechaFin'];
        $Exportar = '1';

        $DevolucionesExcel = $this->actionAjaxCargarReporteDevoluciones($fechaini, $fechafin, $Exportar);

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        Yii::import('ext.phpexcel.XPHPExcel');
        spl_autoload_register(array('YiiBase', 'autoload'));

        /** PHPExcel_Writer_Excel2007 */
        $objPHPExcel = XPHPExcel::createPHPExcel();
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                ->setLastModifiedBy("Maarten Balliauw")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");


        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Responsable')
                ->setCellValue('B1', 'Nombre Asesor')
                ->setCellValue('C1', 'Grupo Ventas')
                ->setCellValue('D1', 'Cliente')
                ->setCellValue('E1', 'Valor')
                ->setCellValue('F1', 'Cantidad')
                ->setCellValue('G1', 'Comentario')
                ->setCellValue('H1', 'Fecha Autoriza')
                ->setCellValue('I1', 'Estado');



        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('G1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('H1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('I1')->getFont()
                ->setBold(true);


        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(18);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);


        $cont = 1;
        foreach ($DevolucionesExcel as $row) {
            $cont ++;

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $cont, $row['Responsable'])
                    ->setCellValue('B' . $cont, $row['Asesor'])
                    ->setCellValue('C' . $cont, $row['NombreGrupoVentas'])
                    ->setCellValue('D' . $cont, $row['NombreCliente'])
                    ->setCellValue('E' . $cont, $row['ValorDevolucion'])
                    ->setCellValue('F' . $cont, $row['TotalDevolucion'])
                    ->setCellValue('G' . $cont, $row['Comentario'])
                    ->setCellValue('H' . $cont, $row['FechaAutorizacion'])
                    ->setCellValue('I' . $cont, $row['Autoriza']);
        }



        $dir = 'ReporteDashboardExcel';
        if (!is_dir($dir)) {
            mkdir($dir);
        }

        $file = (string) (date("Y-m-d") . '_' . date("H-i-s") . '_' . 'DevolucionesExcel' . '.xls');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save($dir . '/' . $file);

        $link = "http://altipal.datosmovil.info/altipalAx/ReporteDashboardExcel/" . $file;
        echo $link;
    }

    public function actionAjaxDescuentosPendientesExcel() {


        $fechaini = $_POST['fechaIni'];
        $fechafin = $_POST['fechaFin'];
        $Exportar = '1';

        $DescuentoPendientesExcel = $this->actionAjaxCargarReporteDescuentosPendientes($fechaini, $fechafin, $Exportar);

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        Yii::import('ext.phpexcel.XPHPExcel');
        spl_autoload_register(array('YiiBase', 'autoload'));

        /** PHPExcel_Writer_Excel2007 */
        $objPHPExcel = XPHPExcel::createPHPExcel();
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                ->setLastModifiedBy("Maarten Balliauw")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");


        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Id Pedido')
                ->setCellValue('B1', 'Nombre Cliente')
                ->setCellValue('C1', 'Razon  Social')
                ->setCellValue('D1', 'Ciudad')
                ->setCellValue('E1', 'Asesor')
                ->setCellValue('F1', 'Grupo Ventas')
                ->setCellValue('G1', 'Canal')
                ->setCellValue('H1', 'Nombre Articulo')
                ->setCellValue('I1', 'Nombre Unidad Medida')
                ->setCellValue('J1', 'Cantidad')
                ->setCellValue('K1', 'Descuento Altiapal')
                ->setCellValue('L1', 'Descuento Proveedor')
                ->setCellValue('M1', 'Quien Autoriza');



        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('G1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('H1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('I1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('J1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('K1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('L1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('M1')->getFont()
                ->setBold(true);



        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(60);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(60);



        $cont = 1;
        foreach ($DescuentoPendientesExcel as $row) {
            $cont ++;

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $cont, $row['IdPedido'])
                    ->setCellValue('B' . $cont, $row['NombreCliente'])
                    ->setCellValue('C' . $cont, $row['razonsoscial'])
                    ->setCellValue('D' . $cont, $row['NombreCiudad'])
                    ->setCellValue('E' . $cont, $row['nombreAsesor'])
                    ->setCellValue('F' . $cont, $row['NombreGrupoVentas'])
                    ->setCellValue('G' . $cont, $row['NombreCanal'])
                    ->setCellValue('H' . $cont, $row['NombreArticulo'])
                    ->setCellValue('I' . $cont, $row['NombreUnidadMedida'])
                    ->setCellValue('J' . $cont, $row['Cantidad'])
                    ->setCellValue('K' . $cont, $row['DsctoEspecialAltipal'])
                    ->setCellValue('L' . $cont, $row['DsctoEspecialProveedor'])
                    ->setCellValue('M' . $cont, $row['QuienfaltaporAutorizar']);
        }

        $dir = 'ReporteDashboardExcel';
        if (!is_dir($dir)) {
            mkdir($dir);
        }

        $file = (string) (date("Y-m-d") . '_' . date("H-i-s") . '_' . 'DescuentoPendientesExcel' . '.xls');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save($dir . '/' . $file);

        $link = "http://altipal.datosmovil.info/altipalAx/ReporteDashboardExcel/" . $file;
        echo $link;
    }

    public function actionAjaxDescuentosAprobadosPorProveedorExcel() {

        $fechaini = $_POST['fechaIni'];
        $fechafin = $_POST['fechaFin'];
        $Exportar = '1';

        $DescuentoAprobadosPorProveedorExcel = $this->actionAjaxCargarReporteDescuentosAprobadosProveedor($fechaini, $fechafin, $Exportar);

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        Yii::import('ext.phpexcel.XPHPExcel');
        spl_autoload_register(array('YiiBase', 'autoload'));

        /** PHPExcel_Writer_Excel2007 */
        $objPHPExcel = XPHPExcel::createPHPExcel();
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                ->setLastModifiedBy("Maarten Balliauw")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");


        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Id Pedido')
                ->setCellValue('B1', 'Nombre Cliente')
                ->setCellValue('C1', 'Razon  Social')
                ->setCellValue('D1', 'Ciudad')
                ->setCellValue('E1', 'Asesor')
                ->setCellValue('F1', 'Grupo Ventas')
                ->setCellValue('G1', 'Canal')
                ->setCellValue('H1', 'Nombre Articulo')
                ->setCellValue('I1', 'Nombre Unidad Medida')
                ->setCellValue('J1', 'Cantidad')
                ->setCellValue('K1', 'Descuento Proveedor')
                ->setCellValue('L1', 'Proveedor');



        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('G1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('H1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('I1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('J1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('K1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('L1')->getFont()
                ->setBold(true);



        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(60);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);



        $cont = 1;
        foreach ($DescuentoAprobadosPorProveedorExcel as $row) {
            $cont ++;

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $cont, $row['IdPedido'])
                    ->setCellValue('B' . $cont, $row['NombreCliente'])
                    ->setCellValue('C' . $cont, $row['razonsoscial'])
                    ->setCellValue('D' . $cont, $row['NombreCiudad'])
                    ->setCellValue('E' . $cont, $row['nombreAsesor'])
                    ->setCellValue('F' . $cont, $row['NombreGrupoVentas'])
                    ->setCellValue('G' . $cont, $row['NombreCanal'])
                    ->setCellValue('H' . $cont, $row['NombreArticulo'])
                    ->setCellValue('I' . $cont, $row['NombreUnidadMedida'])
                    ->setCellValue('J' . $cont, $row['Cantidad'])
                    ->setCellValue('K' . $cont, $row['DsctoEspecialProveedor'])
                    ->setCellValue('L' . $cont, $row['proveedor']);
        }

        $dir = 'ReporteDashboardExcel';
        if (!is_dir($dir)) {
            mkdir($dir);
        }

        $file = (string) (date("Y-m-d") . '_' . date("H-i-s") . '_' . 'DescuentoAprobadosPorProveedorExcel' . '.xls');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save($dir . '/' . $file);

        $link = "http://altipal.datosmovil.info/altipalAx/ReporteDashboardExcel/" . $file;
        echo $link;
    }

    public function actionAjaxNotasAprobadasPorCarteraExcel() {

        $fechaini = $_POST['fechaIni'];
        $fechafin = $_POST['fechaFin'];
        $Exportar = '1';

        $DescuentoAprobadosPorProveedorExcel = $this->actionAjaxCargarReporteNotasCreditoAprobvadosPorCartera($fechaini, $fechafin, $Exportar);

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        Yii::import('ext.phpexcel.XPHPExcel');
        spl_autoload_register(array('YiiBase', 'autoload'));

        /** PHPExcel_Writer_Excel2007 */
        $objPHPExcel = XPHPExcel::createPHPExcel();
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                ->setLastModifiedBy("Maarten Balliauw")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");


        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Codigo Zona Ventas')
                ->setCellValue('B1', 'Nombre Asesor')
                ->setCellValue('C1', 'Grupo Ventas')
                ->setCellValue('D1', 'Cliente')
                ->setCellValue('E1', 'Concepto')
                ->setCellValue('F1', 'Grupo Ventas')
                ->setCellValue('G1', 'Fecha Nota')
                ->setCellValue('H1', 'Hora Nota')
                ->setCellValue('I1', 'Autorizado')
                ->setCellValue('J1', 'Fecha Autorizacion')
                ->setCellValue('K1', 'Valor')
                ->setCellValue('L1', 'Factura')
                ->setCellValue('M1', 'Comentario')
                ->setCellValue('N1', 'Observacion Cartera')
                ->setCellValue('O1', 'Estado')
                ->setCellValue('P1', 'Responsable');



        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('G1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('H1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('I1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('J1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('K1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('L1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('M1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('N1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('O1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('P1')->getFont()
                ->setBold(true);



        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(22);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);



        $cont = 1;
        foreach ($DescuentoAprobadosPorProveedorExcel as $row) {
            $cont ++;

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $cont, $row['ZonaVentas'])
                    ->setCellValue('B' . $cont, $row['Asesor'])
                    ->setCellValue('C' . $cont, $row['NombreGrupoVentas'])
                    ->setCellValue('D' . $cont, $row['NombreCliente'])
                    ->setCellValue('E' . $cont, $row['NombreConceptoNotaCredito'])
                    ->setCellValue('F' . $cont, $row['Fecha'])
                    ->setCellValue('G' . $cont, $row['Hora'])
                    ->setCellValue('H' . $cont, $row['Autoriza'])
                    ->setCellValue('I' . $cont, $row['FechaAutorizacion'])
                    ->setCellValue('J' . $cont, $row['HoraAutorizacion'])
                    ->setCellValue('K' . $cont, $row['Valor'])
                    ->setCellValue('L' . $cont, $row['Factura'])
                    ->setCellValue('M' . $cont, $row['Comentario'])
                    ->setCellValue('N' . $cont, $row['ObservacionCartera'])
                    ->setCellValue('O' . $cont, $row['Estado'])
                    ->setCellValue('P' . $cont, $row['ResponsableNota']);
        }

        $dir = 'ReporteDashboardExcel';
        if (!is_dir($dir)) {
            mkdir($dir);
        }

        $file = (string) (date("Y-m-d") . '_' . date("H-i-s") . '_' . 'NotasAprobadasPorCarteraExcel' . '.xls');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save($dir . '/' . $file);

        $link = "http://altipal.datosmovil.info/altipalAx/ReporteDashboardExcel/" . $file;
        echo $link;
    }

    public function actionAjaxDescuentosFueraDelRangoExcel() {

        $fechaini = $_POST['fechaIni'];
        $fechafin = $_POST['fechaFin'];
        $Exportar = '1';

        $DescuentosFueraDelRangoExcel = $this->actionAjaxCargarReporteDescuentoFueradelRango($fechaini, $fechafin, $Exportar);

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        Yii::import('ext.phpexcel.XPHPExcel');
        spl_autoload_register(array('YiiBase', 'autoload'));

        /** PHPExcel_Writer_Excel2007 */
        $objPHPExcel = XPHPExcel::createPHPExcel();
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                ->setLastModifiedBy("Maarten Balliauw")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");


        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Id Pedido')
                ->setCellValue('B1', 'Nombre Cliente')
                ->setCellValue('C1', 'Razon  Social')
                ->setCellValue('D1', 'Ciudad')
                ->setCellValue('E1', 'Asesor')
                ->setCellValue('F1', 'Grupo Ventas')
                ->setCellValue('G1', 'Valor Pedido')
                ->setCellValue('H1', 'Cantidad')
                ->setCellValue('I1', 'Fecha Pedido')
                ->setCellValue('J1', 'Fecha Autorizado')
                ->setCellValue('K1', 'Responsable')
                ->setCellValue('L1', 'Autorizado');



        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('G1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('H1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('I1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('J1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('K1')->getFont()
                ->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('L1')->getFont()
                ->setBold(true);



        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);



        $cont = 1;
        foreach ($DescuentosFueraDelRangoExcel as $row) {
            $cont ++;

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $cont, $row['IdPedido'])
                    ->setCellValue('B' . $cont, $row['NombreCliente'])
                    ->setCellValue('C' . $cont, $row['razonsoscial'])
                    ->setCellValue('D' . $cont, $row['NombreCiudad'])
                    ->setCellValue('E' . $cont, $row['nombreAsesor'])
                    ->setCellValue('F' . $cont, $row['NombreGrupoVentas'])
                    ->setCellValue('G' . $cont, $row['ValorPedido'])
                    ->setCellValue('H' . $cont, $row['Cantidad'])
                    ->setCellValue('I' . $cont, $row['FechaPedido'])
                    ->setCellValue('J' . $cont, $row['FechaAutorizaAltipal'])
                    ->setCellValue('K' . $cont, $row['NombreAutorizoDsctoAltipal'])
                    ->setCellValue('L' . $cont, $row['Cartera']);
        }


        $dir = 'ReporteDashboardExcel';
        if (!is_dir($dir)) {
            mkdir($dir);
        }

        $file = (string) (date("Y-m-d") . '_' . date("H-i-s") . '_' . 'DescuentosFueraDelRangoExcel' . '.xls');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save($dir . '/' . $file);

        $link = "http://altipal.datosmovil.info/altipalAx/ReporteDashboardExcel/" . $file;
        echo $link;
    }

}
