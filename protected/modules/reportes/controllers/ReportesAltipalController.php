<?php

class ReportesAltipalController extends Controller {

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

    /*
     * vista de reportes información registrada en ALTIPAL vs la enviada por ACTIVITY
     * @paramters
     * @uses Session cedula
     */

    public function actionReportesAltipal() {

        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/scripts/reportes/ReportesAltipal/ReportesAltipal.js', CClientScript::POS_END
        );

        $cedula = Yii::app()->getUser()->getState('_cedula');
        $Agencias = ReporteAcumuladoDia::model()->getAgencias($cedula);

        $this->render('ReportesAltipal', array('Agencias' => $Agencias));
    }

    /*
     * funcion carga los grupos de ventas por agencia
     * @parameters
     * @ _POST agencia
     */

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

    /*
     * armo la tabla del reporte hora visita
     */

    public function actionAjaxTablaReporteHoraVisita() {

        $this->renderPartial('_TablaReporteHoraVisita');
    }

    /*
     * se carga el reporte de horas visita
     * @parameters @_GET
     * @_GET agencia
     * @_GET fechaini
     * @_GET fechafin
     * @_GET grupoventas
     * @return JSON
     */

    public function actionAjaxCargarReporteHoraVisita($agencia = '', $fechaini = '', $fechafin = '', $grupoventas = '', $parametro = '') {

        if (isset($_GET['agencia'])) {

            $agencia = $_GET['agencia'];
            $fechaini = $_GET['fechaini'];
            $fechafin = $_GET['fechafin'];
            $grupoventas = $_GET['grupoventas'];
        }


        $RepoteHoraVisita = Consultas::model()->getReporteHoraVisita($agencia, $fechaini, $fechafin, $grupoventas);

        /* echo '<pre>';
          print_r($RepoteHoraVisita); */


        $ArrayReporteHoraVisita = array();
        $ClientesVisitados = 0;
        foreach ($RepoteHoraVisita as $itemReporteHoraVista) {

            $HoraIgresoSistema = Consultas::model()->getIngresoSistema($itemReporteHoraVista['CodZonaVentas']);
            $Hora1Pedido = Consultas::model()->getPrimerPedido($agencia, $fechaini, $itemReporteHoraVista['CodZonaVentas']);
            $HoraUltiPedido = Consultas::model()->getUltimoPedido($agencia, $fechaini, $itemReporteHoraVista['CodZonaVentas']);
            $HoraCierre = Consultas::model()->getHoraCierre($agencia, $fechaini, $itemReporteHoraVista['CodZonaVentas']);
            $ClientesConCompras = Consultas::model()->getClientesConCompras($agencia, $fechaini, $fechafin, $itemReporteHoraVista['CodZonaVentas']);
            $ClientesSinCompras = Consultas::model()->getClientesSinCompras($agencia, $fechaini, $fechafin, $itemReporteHoraVista['CodZonaVentas']);
            $ClientesNuevos = Consultas::model()->getClientesNuevosHoraVisita($agencia, $fechaini, $fechafin, $itemReporteHoraVista['CodZonaVentas']);
            $ValorPedidos = Consultas::model()->getValorTotalPedidos($agencia, $fechaini, $fechafin, $itemReporteHoraVista['CodZonaVentas']);
            $TotalPedido = Consultas::model()->getTotalPedidos($agencia, $fechaini, $fechafin, $itemReporteHoraVista['CodZonaVentas']);


            if ($HoraCierre['HoraCierre'] == "") {

                $Horacierre = '0';
            } else {

                $Horacierre = $HoraCierre['HoraCierre'];
            }

            $ClientesVisitados = $ClientesConCompras['ClientesConCompras'] + $ClientesSinCompras['ClientesSinCompras'];


            $FechaActual = date('Y-m-d');

            if ($FechaActual == $fechaini) {

                $Hora1erPedido = $Hora1Pedido['Hora1erPedido'];
                $HoraUltimoPedido = $HoraUltiPedido['HoraUltimoPedido'];
                $Horaingreso = $HoraIgresoSistema['horaIngreso'];
            } else {

                $Hora1erPedido = '0';
                $HoraUltimoPedido = '0';
                $Horaingreso = '0';
            }


            if ($ClientesSinCompras['ClientesSinCompras'] != '0') {
                $CliSinCompra = $ClientesSinCompras['ClientesSinCompras'];
            } else {
                $CliSinCompra = '0';
            }

            if ($itemReporteHoraVista['CelularCorporativoJefe'] == "" || $itemReporteHoraVista['CelularCorporativoJefe'] == '0') {

                $CelularCorporativo = '0';
            } else {

                $CelularCorporativo = explode('-', $itemReporteHoraVista['CelularCorporativoJefe']);
            }



            $json = array(
                'ZonaVentas' => $itemReporteHoraVista['CodZonaVentas'],
                'Asesor' => $itemReporteHoraVista['Nombre'],
                'Supervisor' => $itemReporteHoraVista['NombreJefe'],
                'NoPedido' => $TotalPedido['TotalPedidos'],
                'ValPedidos' => number_format($ValorPedidos['TotalValorPedido'], '2', '.', ','),
                'ClientesNuevos' => $ClientesNuevos['TotalClientesNuevos'],
                'HoraIngreso' => $Horaingreso,
                'Hora1Pedido' => $Hora1erPedido,
                'HoraUltPedido' => $HoraUltimoPedido,
                'HoraRutCierre' => $Horacierre,
                'ClientesVisitados' => $ClientesVisitados,
                'ClientesConCompra' => $ClientesConCompras['ClientesConCompras'],
                'ClientesSinCompras' => $CliSinCompra,
                'CelAsesorEmpresarial' => $itemReporteHoraVista['TelefonoMovilEmpresarial'],
                'CelAsesorPersonal' => $itemReporteHoraVista['TelefonoMovilPersonal'],
                'CelSupervisor' => $CelularCorporativo[0]
            );

            array_push($ArrayReporteHoraVisita, $json);
        }


        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($ArrayReporteHoraVisita),
            "iTotalDisplayRecords" => count($ArrayReporteHoraVisita),
            "aaData" => $ArrayReporteHoraVisita);


        if ($parametro != "") {

            return $ArrayReporteHoraVisita;
        } else {

            echo json_encode($results);
        }
    }

    /*
     * se cargar la tabla de reporte pedidos ax
     */

    public function actionAjaxTablaPedidosActivityAX() {

        $this->renderPartial('_TablaReportePedidosAx');
    }

    /*
     * se crea la accion del reporte de pedidos activity ax
     * @parameters @_GET
     * @_GET agencia
     * @_GET fechaini
     * @_GET fechafin
     * @_GET grupoventas
     * @return JSON
     */

    public function actionAjaxCargarReportePedidosActivityAx($agencia = '', $fechaini = '', $fechafin = '', $grupoventa = '', $parametro = '') {



        if (isset($_GET['agencia'])) {

            $agencia = $_GET['agencia'];
            $fechaini = $_GET['fechaini'];
            $fechafin = $_GET['fechafin'];
            $grupoventa = $_GET['grupoventas'];
        }



        $ReportePedidosActivity = Consultas::model()->getReportePedidosActivityAx($agencia, $fechaini, $fechafin, $grupoventa);

        ;
        $ArrayPedidosActivity = array();
        foreach ($ReportePedidosActivity as $itemRPeActivity) {


            $PedidosActivity = Consultas::model()->getPedidosActivity($agencia, $fechaini, $fechafin, $itemRPeActivity['CodZonaVentas']);
            $PedidosAx = Consultas::model()->getPedidoAx($agencia, $fechaini, $fechafin, $itemRPeActivity['CodZonaVentas']);
            $ClientesRutas = Consultas::model()->getClienteRutas($agencia, $fechaini, $fechafin, $itemRPeActivity['CodZonaVentas']);
            $PedidosExtraRuta = Consultas::model()->getPedidosExtraRuta($agencia, $fechaini, $fechafin, $itemRPeActivity['CodZonaVentas']);
            $ClientesNuevos = Consultas::model()->getClientesNuevos($agencia, $fechaini, $fechafin, $itemRPeActivity['CodZonaVentas']);

            $btnverDetalleZona = "<a href='javascript:DetalleZona(" . '"' . $agencia . '"' . "," . $itemRPeActivity['CodZonaVentas'] . ", " . ' "' . $fechaini . '" ' . "," . ' "' . $fechafin . '" ' . ")'><center><img src='images/detalle.png'></center></a>";

            $json = array(
                'Agencia' => $itemRPeActivity['agencia'],
                'GrupoVentas' => $itemRPeActivity['NombreGrupoVentas'],
                'ZonaVentas' => $itemRPeActivity['CodZonaVentas'],
                'NombreAsesor' => $itemRPeActivity['Nombre'],
                'PedidosActivity' => $PedidosActivity['PedidosActivity'],
                'PedidoAX' => $PedidosAx['TotalPedidosAx'],
                'CantClienteRuta' => $ClientesRutas['ClienteRuta'],
                'PedidosExtraRuta' => $PedidosExtraRuta['PedidosExtraRuta'],
                'ClientesNuevos' => $ClientesNuevos['ClienteNuevos'],
                'verDettaleZona' => $btnverDetalleZona
            );

            array_push($ArrayPedidosActivity, $json);
        }


        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($ArrayPedidosActivity),
            "iTotalDisplayRecords" => count($ArrayPedidosActivity),
            "aaData" => $ArrayPedidosActivity);

        if ($parametro != "") {


            return $ArrayPedidosActivity;
        } else {

            echo json_encode($results);
        }
    }

    /*
     * armo la tabla de de talle de los pedidos por zona venta
     */

    public function actionAjaxTablaDetallePedidoZonaActivityAx() {

        $this->renderPartial('_TablaDetallePedidoZonaActivityAX');
    }

    /*
     * se crear la funcion para cargar los detallas de los pedidos de la zona de ventas seleccionada
     * @parameters @_GET
     * @_GET zona
     * @_GET agencia
     * @return JSON
     */

    public function actionAjaxCargarDetallePedidosZonaActivityAx($agencia = '', $fechaini = '', $fechafin = '', $zonaventas = '', $parametro = '') {

        if (isset($_GET['agencia'])) {

            $zonaventas = $_GET['zona'];
            $agencia = $_GET['agencia'];
            $fechaini = $_GET['fechaini'];
            $fechafin = $_GET['fechafin'];
       
         }


            $DetallePedidos = Consultas::model()->getDetallePedidoZonas($agencia, $zonaventas, $fechaini, $fechafin);

            $ArrayDetallesPedidos = array();
            foreach ($DetallePedidos as $itemDetalle) {

                $btnverPendientesZona = "<a href='javascript:DetallePendientes(" . '"' . $agencia . '"' . "," . $itemDetalle['IdPedido'] . ")'><center><img src='images/pending.png' style='width: 50px; height: 50px;'></center></a>";

                $PedidoClienteNuvo = Consultas::model()->getClientesNuevosPedidos($itemDetalle['CuentaCliente']);


                if ($PedidoClienteNuvo['clientesnuevos'] > 0) {

                    $ClienteNuevo = 'Si';
                } else {

                    $ClienteNuevo = 'No';
                }

                if ($itemDetalle['ExtraRuta'] > 0) {

                    $extraRuta = 'Si';
                } else {

                    $extraRuta = 'No';
                }

                if ($itemDetalle['Web'] == 0 && $itemDetalle['IdentificadorEnvio'] > 0) {

                    $canlaTransmision = 'Movil';
                } else {

                    $canlaTransmision = 'Web';
                }


                $json = array(
                    'ZonaVentas' => $itemDetalle['CodZonaVentas'],
                    'NombreAsesor' => $itemDetalle['Nombre'],
                    'IdPedidosActivity' => $itemDetalle['IdPedido'],
                    'IdPedidoAX' => $itemDetalle['ArchivoXml'],
                    'PedidosExtraRuta' => $extraRuta,
                    'ClientesNuevos' => $ClienteNuevo,
                    'Hora' => $itemDetalle['HoraEnviado'],
                    'Fecha' => $itemDetalle['FechaPedido'],
                    'Canal' => $canlaTransmision,
                    'Pedientes' => $btnverPendientesZona
                );

                array_push($ArrayDetallesPedidos, $json);
            }


            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($ArrayDetallesPedidos),
                "iTotalDisplayRecords" => count($ArrayDetallesPedidos),
                "aaData" => $ArrayDetallesPedidos);

            if($parametro != ""){
                
                return $ArrayDetallesPedidos;
                
            }else{
                echo json_encode($results);      
            }        
          
        
    }

    /*
     * se crea la funcion para cargar la tabla del detalle del pedido
     */

    public function actionAjaxTablaDetallePedidoDescripcionActivityAx() {

        $this->renderPartial('_TablaDescripcionDetalleZonaActivityAX');
    }

    /*
     * se crear la funcion para cargar las descripciones de los pedidos
     * @parameters @_GET
     * @_GET zona
     * @_GET agencia
     * @return JSON
     */

    public function actionAjaxCargarDetallePedidosDescripcionActivityAx($agencia = '',$pedido = '',$parametro = '') {


        if ($_GET['pedido']) {

            $pedido = $_GET['pedido'];
            $agencia = $_GET['agencia'];
            
        }   


           $DescripcionPedidosActivity = Consultas::model()->getDescripcionesPedidos($agencia, $pedido);
 
            $ArrayDescripcionPedidosActivity = array();
            $cont = 0;
            foreach ($DescripcionPedidosActivity as $itemDetalleDescripcionActivity) {

                $cont++;

                $json = array(
                    'cont' => $cont,
                    'IdPedido' => $itemDetalleDescripcionActivity['IdPedido'],
                    'IdAx' => $itemDetalleDescripcionActivity['ArchivoXml'],
                    'CuentaCliente' => $itemDetalleDescripcionActivity['CuentaCliente'],
                    'NombreCliente' => $itemDetalleDescripcionActivity['NombreCliente'],
                    'CodArticulo' => $itemDetalleDescripcionActivity['CodigoArticulo'],
                    'CodVariante' => $itemDetalleDescripcionActivity['CodVariante'],
                    'Descripcion' => $itemDetalleDescripcionActivity['NombreArticulo'],
                    'Cantidad' => $itemDetalleDescripcionActivity['Cantidad'],
                    'CanirdadPedidente' => '0',
                );

                array_push($ArrayDescripcionPedidosActivity, $json);
            }


            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($ArrayDescripcionPedidosActivity),
                "iTotalDisplayRecords" => count($ArrayDescripcionPedidosActivity),
                "aaData" => $ArrayDescripcionPedidosActivity);

         if($parametro !=""){
             
             return $ArrayDescripcionPedidosActivity;
             
         }else{
             
               echo json_encode($results);
         }   

          
      
    }

    /*
     * se crea la funcion para exportar el reporte pedidos activity
     * @parameters @_GET
     * @_POST agencia
     * @_POST fechaini
     * @_POST fechafin
     * @_POST grupoventas
     * @return Array
     */

    public function actionAjaxExportar() {

        $agencia = $_POST['agencia'];
        $fechaini = $_POST['fechaini'];
        $fechafin = $_POST['fechafin'];
        $grupoventa = $_POST['grupoventas'];
        $parametro = '1';

        $PedidosActivity = $this->actionAjaxCargarReportePedidosActivityAx($agencia, $fechaini, $fechafin, $grupoventa, $parametro);

        /** PHPExcel */
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
                ->setCellValue('A1', 'Agencia')
                ->setCellValue('B1', 'Grupo Ventas')
                ->setCellValue('C1', 'Zona Ventas')
                ->setCellValue('D1', 'Nombre Asesor')
                ->setCellValue('E1', 'Pedidos Activity')
                ->setCellValue('F1', 'Pedido AX')
                ->setCellValue('G1', 'Cant Cliente Ruta')
                ->setCellValue('H1', 'Extra ruta')
                ->setCellValue('I1', 'Clientes nuevos');

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);


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

        $cont = 1;
        foreach ($PedidosActivity as $row) {
            $cont ++;

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $cont, $row['Agencia'])
                    ->setCellValue('B' . $cont, $row['GrupoVentas'])
                    ->setCellValue('C' . $cont, $row['ZonaVentas'])
                    ->setCellValue('D' . $cont, $row['NombreAsesor'])
                    ->setCellValue('E' . $cont, $row['PedidosActivity'])
                    ->setCellValue('F' . $cont, $row['PedidoAX'])
                    ->setCellValue('G' . $cont, $row['CantClienteRuta'])
                    ->setCellValue('H' . $cont, $row['PedidosExtraRuta'])
                    ->setCellValue('I' . $cont, $row['ClientesNuevos']);
        }


        $dir = 'PedidosActivityAX2012';
        if (!is_dir($dir)) {
            mkdir($dir);
        }

        $file = (string) (date("Y-m-d") . '_' . date("H-i-s") . '_' . 'PedidosActivity2012' . '.xls');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save($dir . '/' . $file);

        $link = "http://altipal.datosmovil.info/altipalAx/PedidosActivityAX2012/" . $file;
        echo $link;
    }

    /*
     * se crea la funcion para exportar el reporte hora  visita
     * @parameters @_GET
     * @_POST agencia
     * @_POST fechaini
     * @_POST fechafin
     * @_POST grupoventas
     * @return Array
     */

    public function actionAjaxExportarHoraVisita() {

        $agencia = $_POST['agencia'];
        $fechaini = $_POST['fechaini'];
        $fechafin = $_POST['fechafin'];
        $grupoventa = $_POST['grupoventas'];
        $parametro = '1';


        $ReporteHoraVisita = $this->actionAjaxCargarReporteHoraVisita($agencia, $fechaini, $fechafin, $grupoventa, $parametro);

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
                ->setCellValue('A1', 'Zona Ventas')
                ->setCellValue('B1', 'Asesor')
                ->setCellValue('C1', 'Supervisor')
                ->setCellValue('D1', 'No Pedido')
                ->setCellValue('E1', 'Va lPedidos')
                ->setCellValue('F1', 'Clientes Nuevos')
                ->setCellValue('G1', 'Hora Ingreso')
                ->setCellValue('H1', 'Hora 1 Pedido')
                ->setCellValue('I1', 'Hora Ultimo Pedido')
                ->setCellValue('J1', 'Hora Rut Cierre')
                ->setCellValue('K1', 'Clientes Visitados')
                ->setCellValue('L1', 'Clientes Con Compra')
                ->setCellValue('M1', 'Clientes Sin Compras')
                ->setCellValue('N1', 'Cel Asesor Empresarial')
                ->setCellValue('O1', 'Cel Asesor Personal')
                ->setCellValue('P1', 'Cel Supervisorl');
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(25);

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



        $cont = 1;
        foreach ($ReporteHoraVisita as $row) {
            $cont ++;

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' .  $cont, $row['ZonaVentas'])
                    ->setCellValue('B' .  $cont, $row['Asesor'])
                    ->setCellValue('C' .  $cont, $row['Supervisor'])
                    ->setCellValue('D' .  $cont, $row['NoPedido'])
                    ->setCellValue('E' .  $cont, $row['ValPedidos'])
                    ->setCellValue('F' .  $cont, $row['ClientesNuevos'])
                    ->setCellValue('G' .  $cont, $row['HoraIngreso'])
                    ->setCellValue('H' .  $cont, $row['Hora1Pedido'])
                    ->setCellValue('I' .    $cont,  $row['HoraUltPedido'])
                    ->setCellValue('J' .   $cont, $row['HoraRutCierre'])
                    ->setCellValue('K' .  $cont, $row['ClientesVisitados'])
                    ->setCellValue('L' .  $cont, $row['ClientesConCompra'])
                    ->setCellValue('M' . $cont, $row['ClientesSinCompras'])
                    ->setCellValue('N' .  $cont, $row['CelAsesorEmpresarial'])
                    ->setCellValue('O' . $cont, $row['CelAsesorPersonal'])
                    ->setCellValue('P' .  $cont, $row['CelSupervisor']);
        }
        
        
        $dir = 'ReporteHoraVisita';
        if (!is_dir($dir)) {
            mkdir($dir);
        }

        $file = (string) (date("Y-m-d") . '_' . date("H-i-s") . '_' . 'ReporteHoraVisita' . '.xls');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save($dir . '/' . $file);

        $link = "http://altipal.datosmovil.info/altipalAx/ReporteHoraVisita/" . $file;
        echo $link;
        
    }
    
    
    public function actionAjaxExportarDetalle(){
        
        $agencia = $_POST['agencia'];
        $fechaini = $_POST['fechaini'];
        $fechafin = $_POST['fechafin'];
        $zonaventas = $_POST['zonaventa'];
        $parametro = '1';

        $DetallePedidosActivity = $this->actionAjaxCargarDetallePedidosZonaActivityAx($agencia, $fechaini, $fechafin, $zonaventas, $parametro);

        /** PHPExcel */
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
                ->setCellValue('A1', 'Zona Ventas')
                ->setCellValue('B1', 'Nombre Asesor')
                ->setCellValue('C1', 'Id Pedido Activity')
                ->setCellValue('D1', 'Id Pedidos AX')
                ->setCellValue('E1', 'Extra Ruta')
                ->setCellValue('F1', 'Cliente Nuevo')
                ->setCellValue('G1', 'Hora')
                ->setCellValue('H1', 'Fecha')
                ->setCellValue('I1', 'Canal Transmision');
        
        
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
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        
        
        $cont = 1;
        foreach ($DetallePedidosActivity as $row) {
            $cont ++;

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' .  $cont, $row['ZonaVentas'])
                    ->setCellValue('B' .  $cont, $row['NombreAsesor'])
                    ->setCellValue('C' .  $cont, $row['IdPedidosActivity'])
                    ->setCellValue('D' .  $cont, $row['IdPedidoAX'])
                    ->setCellValue('E' .  $cont, $row['PedidosExtraRuta'])
                    ->setCellValue('F' .  $cont, $row['ClientesNuevos'])
                    ->setCellValue('G' .  $cont, $row['Hora'])
                    ->setCellValue('H' .  $cont, $row['Fecha'])
                    ->setCellValue('I' .    $cont,  $row['Canal']);
                
        }
        
        
        $dir = 'DetallesPedido';
        if (!is_dir($dir)) {
            mkdir($dir);
        }

        $file = (string) (date("Y-m-d") . '_' . date("H-i-s") . '_' . 'DetallesPedido' . '.xls');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save($dir . '/' . $file);

        $link = "http://altipal.datosmovil.info/altipalAx/DetallesPedido/" . $file;
        echo $link;
         
    }
    
    public function actionAjaxExportarDetallePedido(){
        
        $agencia = $_POST['agencia'];
        $pedido = $_POST['pedido'];
        $parametro = '1';
        
       $DescripcionPedido = $this->actionAjaxCargarDetallePedidosDescripcionActivityAx($agencia,$pedido,$parametro);
       
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
                ->setCellValue('A1', 'No')
                ->setCellValue('B1', 'Id Pedido')
                ->setCellValue('C1', 'IdAx')
                ->setCellValue('D1', 'Cuenta Cliente')
                ->setCellValue('E1', 'Nombre Cliente')
                ->setCellValue('F1', 'Codigo Articulo')
                ->setCellValue('G1', 'Codigo Variante')
                ->setCellValue('H1', 'Descripcion')
                ->setCellValue('I1', 'Cantidad')
                ->setCellValue('J1', 'Canirdad Pendiente');
        
        
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
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(70);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
         $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
        
        
        $cont = 1;
        foreach ($DescripcionPedido as $row) {
            $cont ++;

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' .  $cont, $row['cont'])
                    ->setCellValue('B' .  $cont, $row['IdPedido'])
                    ->setCellValue('C' .  $cont, $row['IdAx'])
                    ->setCellValue('D' .  $cont, $row['CuentaCliente'])
                    ->setCellValue('E' .  $cont, $row['NombreCliente'])
                    ->setCellValue('F' .  $cont, $row['CodArticulo'])
                    ->setCellValue('G' .  $cont, $row['CodVariante'])
                    ->setCellValue('H' .  $cont, $row['Descripcion'])
                    ->setCellValue('I' .    $cont,  $row['Cantidad'])
                   ->setCellValue('J' .    $cont,  $row['CanirdadPedidente']);
                
        }
        
         
        $dir = 'DetallesDescripcionPedido';
        if (!is_dir($dir)) {
            mkdir($dir);
        }

        $file = (string) (date("Y-m-d") . '_' . date("H-i-s") . '_' . 'DetallesDescripcionPedido' . '.xls');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save($dir . '/' . $file);

        $link = "http://altipal.datosmovil.info/altipalAx/DetallesDescripcionPedido/" . $file;
        echo $link;
        
    }
    

}
