<?php

class ResumenDiaController extends Controller {

    public function actionMenu() {
        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/scripts/reportes/ReporteResumenDia/ResumenDia.js', CClientScript::POS_END
        );
        $zonaVentas = Yii::app()->user->getState('_zonaVentas');
        $this->render('menu', array(
            'zonaVentas' => $zonaVentas
        ));
    }

    public function actionAjaxGenerarConsigVeendedorZona() {
        if ($_POST) {
            $zona = $_POST['zona'];
            $fechaini = $_POST['fechaini'];
            $fechafin = $_POST['fechafin'];
            $cont = 1;
            $sql = "SELECT convendedor.CodZonaVentas,zv.NombreZonadeVentas,convendedor.CodAsesor,convendedor.FechaConsignacion,convendedor.NroConsignacion,convendedor.Banco,convendedor.CuentaConsignacion,convendedor.ValorConsignadoEfectivo,convendedor.ValorConsignadoCheque,convendedor.Oficina,convendedor.Ciudad,asesor.Nombre as NombreAsesor,convendedor.Responsable,jerar.NombreEmpleado as NombreResponsable,convendedor.IdentificadorBanco,convendedor.HoraConsignacion,convendedor.FechaConsignacionVendedor FROM `consignacionesvendedor` as convendedor 
                  join asesorescomerciales as asesor on convendedor.CodAsesor=asesor.CodAsesor 
                  left join jerarquiacomercial jerar on convendedor.Responsable=jerar.NumeroIdentidad AND jerar.NumeroIdentidad <>'' 
                  join zonaventas as zv on convendedor.CodZonaVentas=zv.CodZonaVentas 
                  WHERE convendedor.CodZonaVentas in(";
            if ($cont == count($zona)) {
                $sql.=" '$zona') ";
            } else {
                $sql.=" '$zona', ";
            }
            $cont++;
            $sql.=" AND convendedor.FechaConsignacion BETWEEN  '$fechaini' AND '$fechafin' GROUP BY  convendedor.IdConsignacion ORDER BY convendedor.CodZonaVentas";
            $datalleConsigVendedor = ReporteFzNoVentas::model()->getGenrarDetalleConsignacionVeendedor($sql);
            $this->renderPartial('_ResumenDiaConsignacionVendedor', array(
                'arraypuhs' => $datalleConsigVendedor,
                'fechaini' => $fechaini,
                'fechafin' => $fechafin,
                'sql' => $sql
            ));
        }
    }

}
