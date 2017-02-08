<?php

class ReporteZonaVentasController extends Controller {

    public function actionZonas() {
        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/reportezonasventas/reportezonasventas.js', CClientScript::POS_END
        );
        //echo '<pre>';
        $CodAgencia = '002';
        $ZonaVentas = ZonasVentasGlobales::model()->getZonaVentasGlobales();
        $CodAsesor = ZonasVentasGlobales::model()->getCodeAsesor($ZonaVentas[0]['CodZonaVentas']);
        $CountZonas = count($ZonaVentas);
        $linea = ZonasVentasGlobales::model()->getLinea($CodAgencia);
        $multiliena = ZonasVentasGlobales::model()->getMultilinea($CodAgencia);
        $zonasInactivas = ZonasVentasGlobales::model()->getZonasInactivas();
        $barrios = ZonasVentasGlobales::model()->getLocalizacion();
        $precioventa = ZonasVentasGlobales::model()->getPrecioVenta($CodAgencia);
        $bancos = ZonasVentasGlobales::model()->getBancos($CodAgencia);
        $cuentasbancarias = ZonasVentasGlobales::model()->getCuentaBancarias($CodAgencia);
        $codigociiu = ZonasVentasGlobales::model()->getCiiu($CodAgencia);
        $this->render('index', array(
            'CountZonas' => $CountZonas,
            'CodAsesor' => $CodAsesor,
            'linea' => $linea,
            'multiliena' => $multiliena,
            'zonasInactivas' => $zonasInactivas,
            'barrios' => $barrios,
            'precioventa' => $precioventa,
            'bancos' => $bancos,
            'cuentasbancarias' => $cuentasbancarias,
            'codigociiu' => $codigociiu,
        ));
    }

    public function actionAjaxDatosZonasVentas() {
        $report = array();
        $ZonaVentas = ZonasVentasGlobales::model()->getZonaVentasGlobales();
        foreach ($ZonaVentas as $imtemZonas) {
            $Clientes = ZonasVentasGlobales::model()->getClientes($imtemZonas['CodZonaVentas'], $imtemZonas['CodAgencia']);
            $GrupoVentas = ZonasVentasGlobales::model()->getGrupoVentas($imtemZonas['CodZonaVentas'], $imtemZonas['CodAgencia']);
            $CodAsesor = ZonasVentasGlobales::model()->getCodeAsesor($imtemZonas['CodZonaVentas']);
            $jerarquiacomercial = ZonasVentasGlobales::model()->getJerarquiacomercial($imtemZonas['CodZonaVentas']);
            $Cartera = ZonasVentasGlobales::model()->getCartera($imtemZonas['CodZonaVentas'], $imtemZonas['CodAgencia']);
            $Agencia = ZonasVentasGlobales::model()->getAgencia($imtemZonas['CodAgencia']);
            $zonaAlmacen = ZonasVentasGlobales::model()->getZonaAlmacen($imtemZonas['CodZonaVentas'], $imtemZonas['CodAgencia']);
            $GrupoVentasZona = ZonasVentasGlobales::model()->getGrupoVentasZona($imtemZonas['CodZonaVentas'], $imtemZonas['CodAgencia']);
            foreach ($GrupoVentasZona as $imtemGrupos) {
                $Portafolio = ZonasVentasGlobales::model()->getPortafolio($imtemGrupos['CodigoGrupoVentas'], $imtemZonas['CodAgencia']);
                $json = array(
                    'ZonaVentas' => $imtemZonas['CodZonaVentas'],
                    'CodAsesor' => $CodAsesor[0]['CodAsesor'],
                    'jerarquiacomercial' => $jerarquiacomercial['NombreEmpleado'],
                    'Agencia' => $Agencia['Nombre'],
                    'GrupoVentas' => $GrupoVentas['grupos'],
                    'GrupoVentasZona' => $imtemGrupos['NombreGrupoVentas'],
                    'Clientes' => $Clientes['clientes'],
                    'Cartera' => $Cartera['cartera'],
                    'Portafolio' => $Portafolio['portafolio'],
                    'Preventa' => $zonaAlmacen['Preventa'],
                    'Autoventa' => $zonaAlmacen['Autoventa'],
                    'Consignacion' => $zonaAlmacen['Consignacion'],
                    'Ventadirecta' => $zonaAlmacen['VentaDirecta'],
                    'Focalizado' => $zonaAlmacen['Focalizado'],
                );
                array_push($report, $json);
            }
        }
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($report),
            "iTotalDisplayRecords" => count($report),
            "aaData" => $report);
        echo json_encode($results);
    }

}
