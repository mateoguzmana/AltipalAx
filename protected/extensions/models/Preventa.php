<?php

class Preventa extends AgenciaActiveRecord {

    private $txtError;
    private $dataReader;
    private $txtZonaVentas;
    private $cuentaCliente;
    private $codigoSitio;
    private $codigoAlmacen;
    private $ubicacion;

    public function getDbConnection() {
        return self::setConexion();
    }

    public static function model($className = __CLASS__) {
        Yii::import('application.extensions.multiple.Multiple');
        return parent::model($className);
    }

    /*
     * Propiedades
     */

    public function getTxtError() {
        return $this->txtError;
    }

    public function getDataReader() {
        return $this->dataReader;
    }

    public function setZonaVentas($zonaVentas) {
        $this->txtZonaVentas = $zonaVentas;
    }

    public function setCuentaCliente($cuentaCliente) {
        $this->cuentaCliente = $cuentaCliente;
    }

    public function setCodigoSitio($codigoSitio) {
        $this->codigoSitio = $codigoSitio;
    }

    public function setCodigoAlmacen($codigoAlmacen) {
        $this->codigoAlmacen = $codigoAlmacen;
    }

    public function setUbicacion($ubicacion) {
        $this->ubicacion = $ubicacion;
    }

    public function cargarPortafolio() {

        try {

            Yii::import('application.extensions.multiple.Multiple');
            $connection = Multiple::getConexionZonaVentas();

            $sql = "SELECT p.Id,p.CodigoGrupoVentas,p.CodigoVariante,p.CodigoArticulo,p.NombreArticulo,p.CodigoCaracteristica1,p.CodigoCaracteristica2,p.CodigoTipo,tp.Nombre AS NombreTipo,p.CodigoMarca,p.CodigoGrupoCategoria,p.CodigoGrupoDescuentoLinea,p.CodigoGrupoDescuentoMultiLinea,p.CodigoGrupodeImpuestos,p.PorcentajedeIVA,p.ValorIMPOCONSUMO,p.CuentaProveedor,p.DctoPPNivel1,p.DctoPPNivel2,p.IdentificadorProductoNuevo,(SELECT COUNT(1) FROM variantesinactivas AS ina WHERE ina.CodigoVariante=p.CodigoVariante AND ina.CodigoSitio =  'EMPTY' AND ina.CodigoAlmacen =  'EMPTY' ) AS existe,(SELECT NombreCuentaProveedor FROM `proveedores` WHERE CodigoCuentaProveedor = CuentaProveedor) as fabricante,(SELECT IdPrincipal FROM `jerarquiaarticulos` WHERE Nombre = CodigoGrupoCategoria) as grupo,(SELECT MAX(PrecioVenta) FROM `acuerdoscomercialesprecioventa` WHERE CodigoVariante = p.CodigoVariante) as max_val
                FROM `portafolio` AS p 
                INNER JOIN zonaventas AS z ON p.CodigoGrupoVentas=z.CodigoGrupoVentas 
                LEFT JOIN tipoproducto AS tp ON tp.CodigoTipoProducto = p.CodigoTipo
                WHERE z.CodZonaVentas='$this->txtZonaVentas' 
                GROUP BY p.CodigoVariante,p.CodigoArticulo HAVING existe=0; ORDER BY p.CodigoVariante ASC";
           
            $command = $connection->createCommand($sql);
            $this->dataReader = $command->queryAll();
            
              /*echo '<pre>';
              print_r($this->dataReader); 
              die();*/

            return true;
        } catch (Exception $exc) {
            $this->txtError = $exc->getTraceAsString();
            return false;
        }
    }

    
    
     public function cargarPortafolioAutoventa($ubicacion) {

        try {

            Yii::import('application.extensions.multiple.Multiple');
            $connection = Multiple::getConexionZonaVentas();

            $sql = "SELECT p.Id,p.CodigoGrupoVentas,p.CodigoVariante,p.CodigoArticulo,p.NombreArticulo,p.CodigoCaracteristica1,p.CodigoCaracteristica2,p.CodigoTipo,tp.Nombre AS NombreTipo,p.CodigoMarca,p.CodigoGrupoCategoria,p.CodigoGrupoDescuentoLinea,p.CodigoGrupoDescuentoMultiLinea,p.CodigoGrupodeImpuestos,p.PorcentajedeIVA,p.ValorIMPOCONSUMO,p.CuentaProveedor,p.DctoPPNivel1,p.DctoPPNivel2,p.IdentificadorProductoNuevo,(SELECT COUNT(1) FROM variantesinactivas AS ina WHERE ina.CodigoVariante=p.CodigoVariante AND ina.CodigoSitio =  'EMPTY' AND ina.CodigoAlmacen =  'EMPTY' ) AS existe,(SELECT NombreCuentaProveedor FROM `proveedores` WHERE CodigoCuentaProveedor = CuentaProveedor) as fabricante,(SELECT IdPrincipal FROM `jerarquiaarticulos` WHERE Nombre = CodigoGrupoCategoria) as grupo,(SELECT MAX(PrecioVenta) FROM `acuerdoscomercialesprecioventa` WHERE CodigoVariante = p.CodigoVariante) as max_val
                FROM `portafolio` AS p 
                INNER JOIN zonaventas AS z ON p.CodigoGrupoVentas=z.CodigoGrupoVentas
                INNER JOIN saldosinventarioautoventayconsignacion AS sia ON p.CodigoVariante = sia.CodigoVariante
                LEFT JOIN tipoproducto AS tp ON tp.CodigoTipoProducto = p.CodigoTipo
                WHERE z.CodZonaVentas='$this->txtZonaVentas' AND sia.Disponible > 0 AND CodigoUbicacion = '$ubicacion'
                GROUP BY p.CodigoVariante,p.CodigoArticulo HAVING existe=0;";
           
            $command = $connection->createCommand($sql);
            $this->dataReader = $command->queryAll();
            
              /*echo $sql;
              echo '<pre>';
              print_r($this->dataReader); 
              die();*/


            return true;
        } catch (Exception $exc) {
            $this->txtError = $exc->getTraceAsString();
            return false;
        }
    }
    public function cargarAcuerdosComerciales($CodVariante) {

        try {

            Yii::import('application.extensions.multiple.Multiple');
            $connection = Multiple::getConexionZonaVentas();

            $sql = "SELECT * FROM `acuerdoscomercialesprecioventa`  WHERE 1 AND FechaInicio<>'0000-00-00' AND CodigoVariante = '$CodVariante' ORDER BY FechaInicio DESC,PrecioVenta DESC";

            $command = $connection->createCommand($sql);
            $this->dataReader = $command->queryAll();

            return true;
        } catch (Exception $exc) {
            $this->txtError = $exc->getTraceAsString();
            return false;
        }
    }

    public function cargarCargarCodigoGrupoPrecio() {

        try {

            Yii::import('application.extensions.multiple.Multiple');
            $connection = Multiple::getConexionZonaVentas();

            $sql = "SELECT `CodigoGrupoPrecio` FROM `clienteruta` WHERE  `CodZonaVentas`='$this->txtZonaVentas' AND `CuentaCliente`='$this->cuentaCliente';";

            $command = $connection->createCommand($sql);
            $this->dataReader = $command->queryRow();

            return true;
        } catch (Exception $exc) {
            $this->txtError = $exc->getTraceAsString();
            return false;
        }
    }

    public function cargarSaldoInventarioPreventa() {

        try {

            Yii::import('application.extensions.multiple.Multiple');
            $connection = Multiple::getConexionZonaVentas();
            
            $sql = "SELECT * FROM `saldosinventariopreventa` WHERE `CodigoSitio`='$this->codigoSitio' AND `CodigoAlmacen`='$this->codigoAlmacen';";
            $command = $connection->createCommand($sql);
            $this->dataReader = $command->queryAll();

            return true;
        } catch (Exception $exc) {
            $this->txtError = $exc->getTraceAsString();
            return false;
        }
    }

    public function cargarSaldoInventarioAutoventa() {

        try {

            Yii::import('application.extensions.multiple.Multiple');
            $connection = Multiple::getConexionZonaVentas();

            $sql = "SELECT * FROM `saldosinventarioautoventayconsignacion` WHERE `CodigoSitio`='$this->codigoSitio' AND `CodigoAlmacen`='$this->codigoAlmacen' AND  `CodigoUbicacion` =  '$this->ubicacion';";
            $command = $connection->createCommand($sql);
            $this->dataReader = $command->queryAll();
            
            /*  echo $sql;
              echo '<pre>';
              print_r($this->dataReader); 
              die();*/

            return true;
        } catch (Exception $exc) {
            $this->txtError = $exc->getTraceAsString();
            return false;
        }
    }

    public function cargarUnidadesConversion() {

        try {

            Yii::import('application.extensions.multiple.Multiple');
            $connection = Multiple::getConexionZonaVentas();

            $sql = "SELECT * FROM `unidadesdeconversion`";

            $command = $connection->createCommand($sql);
            $this->dataReader = $command->queryAll();

            return true;
        } catch (Exception $exc) {
            $this->txtError = $exc->getTraceAsString();
            return false;
        }
    }

    public function cargarOperacionesUniadades() {

        try {

            Yii::import('application.extensions.multiple.Multiple');
            $connection = Multiple::getConexionZonaVentas();

            $sql = "SELECT * FROM `operacionesunidades`";

            $command = $connection->createCommand($sql);
            $this->dataReader = $command->queryAll();

            return true;
        } catch (Exception $exc) {
            $this->txtError = $exc->getTraceAsString();
            return false;
        }
    }

    public function cargarListaMateriales($CodVariante) {

        try {

            Yii::import('application.extensions.multiple.Multiple');
            $connection = Multiple::getConexionZonaVentas();

            $sql = "SELECT 
                        lm.CodigoListaMateriales as LMCodigoListaMateriales,
                        lm.CodigoArticuloKit as LMCodigoArticuloKit,
                        lm.CodigoCaracteristica1Kit as LMCodigoCaracteristica1Kit,
                        lm.CodigoCaracteristica2Kit as LMCodigoCaracteristica2Kit,
                        lm.CodigoTipoKit as LMCodigoTipoKit,
                        lm.Cantidad as LMCantidad,
                        lm.Sitio as LMSitio,
                        lm.Almacen as LMAlmacen,
                        lm.CantidadFijos as LMCantidadFijos,
                        lm.CantidadOpcionales as LMCantidadOpcionales,
                        lm.TotalPrecioVentaListaMateriales as LMTotalPrecioVentaListaMateriales,
                        lm.CodigoVarianteKit as LMCodigoVarianteKit,
                        
                        lmd.CodigoListaMateriales as LMDCodigoListaMateriales,
                        lmd.CodigoArticuloComponente as LMDCodigoArticuloComponente,
                        lmd.CodigoCaracteristica1 as LMDCodigoCaracteristica1,
                        lmd.CodigoCaracteristica2 as LMDCodigoCaracteristica2,
                        lmd.CodigoTipoActivity  as LMDCodigoTipo, 
                        lmd.CodigoVarianteComponente as LMDCodigoVarianteComponente,
                        lmd.CantidadComponente as LMDCantidadComponente,
                        lmd.CodigoUnidadMedida as LMDCodigoUnidadMedida,
                        lmd.NombreUnidadMedida as LMDNombreUnidadMedida,
                        lmd.Fijo as LMDFijo,
                        lmd.Opcional as LMDOpcional,
                        lmd.PrecioVentaBaseVariante as LMDPrecioVentaBaseVariante,
                        lmd.TotalPrecioVentaBaseVariante as LMDTotalPrecioVentaBaseVariante,
                        lmd.CodigoTipo as CA,                        

			porta.NombreArticulo AS NombreComponente,
                        porta.PorcentajedeIVA AS PorcentajedeIVAComponente,
                        porta.ValorIMPOCONSUMO AS ValorIMPOCONSUMOComponente
			
                        FROM `listademateriales` lm
                        INNER JOIN listadematerialesdetalle lmd ON lm.CodigoListaMateriales=lmd.CodigoListaMateriales 
                        INNER JOIN portafolio porta ON porta.CodigoVariante=lmd.CodigoVarianteComponente
                        WHERE lm.CodigoVarianteKit = '$CodVariante' AND lm.CodigoListaMateriales IN(SELECT CodigoListaMateriales FROM listademateriales WHERE CodigoVarianteKit = '$CodVariante' GROUP BY CodigoVarianteKit) 
                            GROUP BY lmd.CodigoVarianteComponente, lmd.CodigoTipoActivity, lmd.PrecioVentaBaseVariante
                        ORDER BY lmd.CodigoCaracteristica1 ASC";


            $command = $connection->createCommand($sql);
            $this->dataReader = $command->queryAll();

            return true;
        } catch (Exception $exc) {
            $this->txtError = $exc->getTraceAsString();
            return false;
        }
    }
    
    
        public function cargarListaMaterialesGuardar($CodVariante) {

        try {

            Yii::import('application.extensions.multiple.Multiple');
            $connection = Multiple::getConexionZonaVentas();

            $sql = "SELECT 
                        lm.CodigoListaMateriales as LMCodigoListaMateriales,
                        lm.CodigoArticuloKit as LMCodigoArticuloKit,
                        lm.CodigoTipoKit as LMCodigoTipoKit,
                        lm.Cantidad as LMCantidad,
                        lm.CodigoVarianteKit as LMCodigoVarianteKit,
                        
                        lmd.CodigoListaMateriales as LMDCodigoListaMateriales,
                        lmd.CodigoArticuloComponente as LMDCodigoArticuloComponente,
                        lmd.CodigoTipoActivity  as LMDCodigoTipo, 
                        lmd.CodigoVarianteComponente as LMDCodigoVarianteComponente,
                        lmd.CantidadComponente as LMDCantidadComponente,
                        lmd.CodigoUnidadMedida as LMDCodigoUnidadMedida,
                        lmd.NombreUnidadMedida as LMDNombreUnidadMedida,
                        lmd.Fijo as LMDFijo,
                        lmd.Opcional as LMDOpcional,
                        lmd.PrecioVentaBaseVariante as LMDPrecioVentaBaseVariante,
                        lmd.CodigoTipo as CA,                        
			porta.NombreArticulo AS NombreComponente
			
                        FROM `listademateriales` lm
                        INNER JOIN listadematerialesdetalle lmd ON lm.CodigoListaMateriales=lmd.CodigoListaMateriales 
                        INNER JOIN portafolio porta ON porta.CodigoVariante=lmd.CodigoVarianteComponente
                        WHERE lm.CodigoVarianteKit = '$CodVariante' AND lm.CodigoListaMateriales IN(SELECT CodigoListaMateriales FROM listademateriales WHERE CodigoVarianteKit = '$CodVariante' GROUP BY CodigoVarianteKit) GROUP BY lmd.CodigoVarianteComponente
                        ORDER BY lmd.CodigoCaracteristica1 ASC";


            $command = $connection->createCommand($sql);
            $respuesta = $command->queryAll();

            return $respuesta;
        } catch (Exception $exc) {
            $this->txtError = $exc->getTraceAsString();
            return false;
        }
    }

    public function cargarAcuerdoLinea() {

        try {

            Yii::import('application.extensions.multiple.Multiple');
            $connection = Multiple::getConexionZonaVentas();

            $sql = "SELECT a . * FROM `acuerdoscomercialesdescuentolinea` AS a 
                LEFT JOIN portafolio AS porta ON (porta.CodigoVariante=a.CodigoVariante)  
                WHERE 
                ((CodigoClienteGrupoDescuentoLinea IN(SELECT CodigoGrupoDescuentoLinea FROM `clienteruta` WHERE CuentaCliente = '$this->cuentaCliente' AND CodZonaVentas = '$this->txtZonaVentas') 
                OR CuentaCliente IN(SELECT CuentaCliente FROM `clienteruta` WHERE CuentaCliente = '$this->cuentaCliente' AND CodZonaVentas = '$this->txtZonaVentas'))
                OR(CuentaCliente = 'Sin Cuenta  Cliente' AND CodigoClienteGrupoDescuentoLinea = 'EMPTY' AND (porta.CodigoVariante = a.CodigoVariante OR a.CodigoVariante = 'Sin codigo Variante'))) 
                AND FechaInicio <> '0000-00-00' AND FechaInicio <= CURDATE() AND ( FechaFinal >= CURDATE() OR FechaFinal = '0000-00-00' ) 
                GROUP BY a.Id ORDER BY a.CantidadHasta DESC,`a`.`TipoCuentaCliente` ASC,a.TipoCuentaArticulos ASC,`a`.`Sitio` ASC,a.Saldo DESC,SUM(a.PorcentajeDescuentoLinea1+a.PorcentajeDescuentoLinea2) ASC
";


            $command = $connection->createCommand($sql);
            $this->dataReader = $command->queryAll();

            return true;
        } catch (Exception $exc) {
            $this->txtError = $exc->getTraceAsString();
            return false;
        }
    }

    public function cargarAcuerdoMultiLinea() {

        try {

            Yii::import('application.extensions.multiple.Multiple');
            $connection = Multiple::getConexionZonaVentas();

            $sql = "SELECT a . * 
                        FROM  `acuerdoscomercialesdescuentomultilinea` AS a
                        INNER JOIN clienteruta AS cr ON ( cr.CuentaCliente = a.CuentaCliente
                        OR cr.CodigoGrupoDescuentoMultiLinea = a.CodigoGrupoClienteDescuentoMultilinea OR a.CodigoGrupoClienteDescuentoMultilinea = 'EMPTY') 
                        INNER JOIN frecuenciavisita AS fre ON fre.NumeroVisita = cr.NumeroVisita
                        WHERE cr.CodZonaVentas =  '$this->txtZonaVentas'
                        AND cr.CuentaCliente =  '$this->cuentaCliente'
                        AND FechaInicio <>  '0000-00-00'
                        AND FechaInicio <=  CURDATE()
                        AND (
                        FechaFinal >=  CURDATE()
                        OR FechaFinal =  '0000-00-00'
                        )
                        GROUP BY a.Id
                        HAVING SUM(a.PorcentajeDescuentoMultilinea1+a.PorcentajeDescuentoMultilinea2) > 0  ORDER BY  `a`.`FechaInicio` DESC, SUM(a.PorcentajeDescuentoMultilinea1+a.PorcentajeDescuentoMultilinea2) ASC ";

            $command = $connection->createCommand($sql);
            $this->dataReader = $command->queryAll();

            return true;
        } catch (Exception $exc) {
            $this->txtError = $exc->getTraceAsString();
            return false;
        }
    }

    public function cargarGrupoVentas($zonaVentas) {

        try {

            Yii::import('application.extensions.multiple.Multiple');
            $connection = Multiple::getConexionZonaVentas();

            $sql = "SELECT  `CodigoGrupoVentas` FROM  `zonaventas` WHERE  `CodZonaVentas` =  '$zonaVentas'";

            $command = $connection->createCommand($sql);
            $this->dataReader = $command->queryRow();

            return $this->dataReader;
        } catch (Exception $exc) {
            $this->txtError = $exc->getTraceAsString();
            return false;
        }
    }

    public function cargarUbicacionZona($zonaVentas) {

        try {

            Yii::import('application.extensions.multiple.Multiple');
            $connection = Multiple::getConexionZonaVentas();

            $sql = "SELECT `CodigoUbicacion` FROM `zonaventaalmacen` WHERE `CodZonaVentas`='$zonaVentas'";

            $command = $connection->createCommand($sql);
            $this->dataReader = $command->queryRow();

            return $this->dataReader;
        } catch (Exception $exc) {
            $this->txtError = $exc->getTraceAsString();
            return false;
        }
    }

        public function cargarUbicacionZonaAlmacen($zonaVentas, $codigoAlmacen, $codigoSitio) {

        try {

            Yii::import('application.extensions.multiple.Multiple');
            $connection = Multiple::getConexionZonaVentas();

            $sql = "SELECT `CodigoUbicacion` FROM `zonaventaalmacen` WHERE `CodZonaVentas`='$zonaVentas' AND CodigoSitio = '$codigoSitio' AND CodigoAlmacen = '$codigoAlmacen'";

            $command = $connection->createCommand($sql);
            $this->dataReader = $command->queryRow();
            
            /*  echo '<pre> Consulta: '.$sql;
              echo '<br /> Resultado: '.$this->dataReader['CodigoUbicacion'];
              die();*/

            return $this->dataReader;
        } catch (Exception $exc) {
            $this->txtError = $exc->getTraceAsString();
            return false;
        }
    }
    
    public function cargarFormasPago($dias) {

        try {

            Yii::import('application.extensions.multiple.Multiple');
            $connection = Multiple::getConexionZonaVentas();

            $sql = "SELECT * FROM `condicionespago` WHERE `Dias`<>'0'  AND `Dias`<='$dias' ORDER BY `Dias` DESC  ";

            $command = $connection->createCommand($sql);
            $this->dataReader = $command->queryAll();

            return $this->dataReader;
        } catch (Exception $exc) {
            $this->txtError = $exc->getTraceAsString();
            return false;
        }
    }

    public function cargarVariantesInactivas($CodVariante) {

        try {

            Yii::import('application.extensions.multiple.Multiple');
            $connection = Multiple::getConexionZonaVentas();
            $sql = "SELECT * FROM `variantesinactivas` WHERE CodigoVariante = '$CodVariante'";

            $command = $connection->createCommand($sql);
            $this->dataReader = $command->queryAll();

            return true;
        } catch (Exception $exc) {

            $this->txtError = $exc->getTraceAsString();
            return false;
        }
    }

    public function cargarRestriccionesProveedores() {

        try {

            Yii::import('application.extensions.multiple.Multiple');
            $connection = Multiple::getConexionZonaVentas();
            $sql = "SELECT * FROM `restriccioncuentaproveedor`";

            $command = $connection->createCommand($sql);
            $this->dataReader = $command->queryAll();

            return true;
        } catch (Exception $exc) {

            $this->txtError = $exc->getTraceAsString();
            return false;
        }
    }

}
