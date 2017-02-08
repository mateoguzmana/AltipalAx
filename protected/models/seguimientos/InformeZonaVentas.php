<?php

class InformeZonaVentas extends CActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getsitiosAlmacen($zona) {        
        $sql = "SELECT alma.Nombre as NombreAlmacen,siti.Nombre as NombreSitio,zonalma.CodZonaVentas,zonalma.Preventa,zonalma.Autoventa,zonalma.Consignacion,zonalma.VentaDirecta,zonalma.Focalizado,zonalma.CodigoSitio,zonalma.CodigoAlmacen,cia.Nombre as NombreAgencia FROM zonaventaalmacen zonalma join almacenes alma on zonalma.CodigoAlmacen=alma.CodigoAlmacen join sitios siti on zonalma.CodigoSitio=siti.CodSitio join agencia cia on zonalma.Agencia=cia.CodAgencia WHERE CodZonaVentas='$zona'";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function getPortafolio($zona) {
        $sql = "SELECT porta.CodigoGrupoVentas,porta.CodigoVariante,porta.CodigoArticulo,porta.NombreArticulo,porta.CodigoCaracteristica1,porta.CodigoCaracteristica2,porta.CodigoMarca,porta.CodigoTipo,porta.CodigoGrupoCategoria,porta.CuentaProveedor,porta.PorcentajedeIVA,porta.ValorIMPOCONSUMO FROM zonaventas zona join gruposventas grup on zona.CodigoGrupoVentas=grup.CodigoGrupoVentas join portafolio porta on grup.CodigoGrupoVentas=porta.CodigoGrupoVentas WHERE zona.CodZonaVentas='$zona'";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function getsitiosalmacenbyzona($zona) {
        $sql = "SELECT zonaalma.CodigoSitio,zonaalma.CodigoAlmacen,sit.Nombre as NombreSitio ,alma.Nombre as NombreAlmacen FROM zonaventaalmacen zonaalma join sitios sit on zonaalma.CodigoSitio=sit.CodSitio join almacenes alma on zonaalma.CodigoAlmacen=alma.CodigoAlmacen WHERE zonaalma.CodZonaVentas='$zona'";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function getsaldoinvitariopreventa($sitio, $almacen) {
        $sql = "SELECT * FROM `saldosinventariopreventa` WHERE CodigoSitio='$sitio' AND CodigoAlmacen='$almacen'";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function getsaldoinvitarioautoventa($sitio, $almacen) {
        $sql = "SELECT * FROM `saldosinventarioautoventayconsignacion` WHERE CodigoSitio='$sitio' AND CodigoAlmacen='$almacen'";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function getinformationasesor($zona) {
        $sql = "SELECT zona.CodZonaVentas,zona.NombreZonadeVentas,asesor.CodAsesor,asesor.Nombre FROM zonaventas zona join asesorescomerciales asesor on zona.CodAsesor=asesor.CodAsesor where zona.CodZonaVentas='$zona'";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

}
