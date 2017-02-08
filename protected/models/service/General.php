<?php

/**
 * This is the model class for table "semanas".
 *
 * @property integer $idUsuario
 */
class General extends DatabaseUtilities {

    public static function model($className = __CLASS__) {
        Yii::import('application.extensions.multiple.Multiple');
        return parent::model($className);
    }

//USUARIO
    public function getDatosUser($db, $usuario) {
        $multiple = new Multiple();
        $datosUsuario = array();
        $sql = "SELECT a.CodAsesor,a.Cedula,a.Clave,a.Nombre,a.Telefono,a.TelefonoMovilPersonal,a.TelefonoMovilEmpresarial,a.CorreoElectronico,a.Direccion,a.Imagen,a.InfoActivity,z.CodZonaVentas,z.NombreZonadeVentas,z.CodigoGrupoVentas, z.Transferencia, agrup.Estado as permisosQr 
                    FROM `asesorescomerciales` AS a 
                    INNER JOIN zonaventas AS z ON a.CodAsesor=z.CodAsesor
                    LEFT JOIN asignargruposdeventaqr AS agrup ON z.CodigoGrupoVentas = agrup.CodGruposVentas
                    WHERE z.CodZonaVentas='" . $usuario . "'; ";
        $rs_cltes = $multiple->ExcecuteQueryAllInAgency($sql, $db);
        foreach ($rs_cltes as $col_cltes) {
            $json = array(
                'cod_asesor' => $col_cltes['CodAsesor'],
                'cedula' => $col_cltes['Cedula'],
                'clave' => $col_cltes['Clave'],
                'nombre' => $col_cltes['Nombre'],
                'telefono' => $col_cltes['Telefono'],
                'telefono_movil_personal' => $col_cltes['TelefonoMovilPersonal'],
                'telefono_movil_empresarial' => $col_cltes['TelefonoMovilEmpresarial'],
                'email' => $col_cltes['CorreoElectronico'],
                'direccion' => $col_cltes['Direccion'],
                'imagen' => $col_cltes['Imagen'],
                'transferencia' => trim(strtoupper($col_cltes['Transferencia'])),
                'info_activity' => $col_cltes['InfoActivity'],
                'cod_zona_ventas' => $col_cltes['CodZonaVentas'],
                'nombre_zona_ventas' => $col_cltes['NombreZonadeVentas'],
                'codigo_grupo_ventas' => $col_cltes['CodigoGrupoVentas'],
                'permisosQr' => $col_cltes['permisosQr']
            );
            array_push($datosUsuario, $json);
        }
        return $datosUsuario;
    }

    public function getGruposVentas($db, $usuario) {
        $multiple = new Multiple();
        $datosGrupoV = array();
        $sqlGv = "SELECT g.codigoGrupoVentas,g.NombreGrupoVentas,g.DiasPPNivel1,g.DiasPPNivel2,g.PermitirModificarPrecio,g.PermitirModificarDescuentoLinea,g.PermitirModifiarDescuentoMultiLinea,g.PermitirModificarDescuentoEspecialAltipal,g.PermitirModificarDescuentoEspecialProveedor,g.AplicaDescuentoPP,g.AplicaContado 
                        FROM `gruposventas` AS g 
                        INNER JOIN zonaventas AS z ON g.CodigoGrupoVentas=z.CodigoGrupoVentas 
                        WHERE z.CodZonaVentas='" . $usuario . "'; ";
        $rs_cltesGv = $multiple->ExcecuteQueryAllInAgency($sqlGv, $db);
        foreach ($rs_cltesGv as $col_cltesGv) {
            $json = array(
                'codigo_grupo_ventas' => $col_cltesGv['codigoGrupoVentas'],
                'nombre_grupo_ventas' => $col_cltesGv['NombreGrupoVentas'],
                'dias_pp1' => $col_cltesGv['DiasPPNivel1'],
                'dias_pp2' => $col_cltesGv['DiasPPNivel2'],
                'permite_modificar_precio' => strtoupper($col_cltesGv['PermitirModificarPrecio']),
                'permite_modificar_descuento_linea' => strtoupper($col_cltesGv['PermitirModificarDescuentoLinea']),
                'permite_modificar_descuento_multilinea' => strtoupper($col_cltesGv['PermitirModifiarDescuentoMultiLinea']),
                'permite_modificar_descuento_especial_altipal' => strtoupper($col_cltesGv['PermitirModificarDescuentoEspecialAltipal']),
                'permite_modificar_descuento_especial_proveedor' => strtoupper($col_cltesGv['PermitirModificarDescuentoEspecialProveedor']),
                'aplica_descuento_pp' => strtoupper($col_cltesGv['AplicaDescuentoPP']),
                'aplica_contado' => strtoupper($col_cltesGv['AplicaContado'])
            );
            array_push($datosGrupoV, $json);
        }
        return $datosGrupoV;
    }

    public function getZonaAlma($db, $usuario) {
        $multiple = new Multiple();
        //ZonaAlmacen
        $datosZonaAlma = array();
        $sqlZonaAlma = "SELECT z.Id,z.CodZonaVentas,z.CodigoUbicacion,z.Preventa,z.Autoventa,z.Consignacion,z.VentaDirecta,z.Focalizado,z.CodigoSitio,s.Nombre AS NombreSitio,z.CodigoAlmacen,a.Nombre AS NombreAlmacen,z.Agencia 
                                    FROM `zonaventaalmacen` AS z 
                                    INNER JOIN sitios AS s ON z.CodigoSitio=s.CodSitio 
                                    INNER JOIN almacenes AS a ON z.CodigoAlmacen=a.CodigoAlmacen 
                                    WHERE z.CodZonaVentas='" . $usuario . "' GROUP BY z.Id; ";
        $rs_cltesZonaAlma = $multiple->ExcecuteQueryAllInAgency($sqlZonaAlma, $db);
        foreach ($rs_cltesZonaAlma as $colAlma) {
            $json = array(
                'Id' => $colAlma['Id'],
                'CodZonaVentas' => $colAlma['CodZonaVentas'],
                'CodigoUbicacion' => $colAlma['CodigoUbicacion'],
                'Preventa' => strtoupper($colAlma['Preventa']),
                'Autoventa' => strtoupper($colAlma['Autoventa']),
                'Consignacion' => strtoupper($colAlma['Consignacion']),
                'VentaDirecta' => strtoupper($colAlma['VentaDirecta']),
                'Focalizado' => strtoupper($colAlma['Focalizado']),
                'CodigoSitio' => $colAlma['CodigoSitio'],
                'NombreSitio' => $colAlma['NombreSitio'],
                'CodigoAlmacen' => $colAlma['CodigoAlmacen'],
                'NombreAlmacen' => $colAlma['NombreAlmacen'],
                'Agencia' => $colAlma['Agencia']
            );
            array_push($datosZonaAlma, $json);
        }
        return $datosZonaAlma;
    }

    public function getOperacionesConversion($db) {
        //Operaciones de conversion
        $multiple = new Multiple();
        $datosOperacion = array();
        $sqlOperacion = "SELECT * FROM `operacionesunidades` ORDER BY Id; ";
        $rs_cltesOperacion = $multiple->ExcecuteQueryAllInAgency($sqlOperacion, $db);
        foreach ($rs_cltesOperacion as $colOperacion) {
            $json = array(
                'Id' => $colOperacion['Id'],
                'CodigoDesde' => $colOperacion['CodigoDesde'],
                'CodigoHasta' => $colOperacion['CodigoHasta'],
                'Operacion' => $colOperacion['Operacion']
            );
            array_push($datosOperacion, $json);
        }
        return $datosOperacion;
    }

    public function getFrecuencia($db) {
//Frecuencia
        $multiple = new Multiple();
        $datosFrecuencia = array();
        $sqlFr = "SELECT * FROM `frecuenciavisita` ORDER BY NumeroVisita; ";
        $rs_cltesFr = $multiple->ExcecuteQueryAllInAgency($sqlFr, $db);
        foreach ($rs_cltesFr as $col_cltesFr) {
            $json = array(
                'numero_visita' => $col_cltesFr['NumeroVisita'],
                'cod_frecuencia' => $col_cltesFr['CodFrecuencia'],
                'r1' => $col_cltesFr['R1'],
                'r2' => $col_cltesFr['R2'],
                'r3' => $col_cltesFr['R3'],
                'r4' => $col_cltesFr['R4']
            );
            array_push($datosFrecuencia, $json);
        }
        return $datosFrecuencia;
    }

    public function getCodigoCIIU($db) {
//Codigo CIIU
        $multiple = new Multiple();
        $datosCiiu = array();
        $sqlciiu = "SELECT * FROM `ciiu`; ";
        $rs_cltesciiu = $multiple->ExcecuteQueryAllInAgency($sqlciiu, $db);
        foreach ($rs_cltesciiu as $col_cltesGv) {
            $json = array(
                'CodigoCIIU' => $col_cltesGv['CodigoCIIU'],
                'NombreCIIU' => $col_cltesGv['NombreCIIU']
            );
            array_push($datosCiiu, $json);
        }
        return $datosCiiu;
    }

    public function getBancos($db) {
//Bancos
        $multiple = new Multiple();
        $datosBancos = array();
        $sqlBancos = "SELECT * FROM `bancos` WHERE `IdentificadorBanco` <> '' ; ";
        $rs_Bancos = $multiple->ExcecuteQueryAllInAgency($sqlBancos, $db);
        foreach ($rs_Bancos as $colBancos) {
            $json = array(
                'Codigo' => $colBancos['CodBanco'],
                'Nombre' => $colBancos['Nombre'],
                'Identificador' => $colBancos['IdentificadorBanco']
            );
            array_push($datosBancos, $json);
        }
        return $rs_Bancos;
    }

    public function getCuentas($db) {
//Cuentas
        $multiple = new Multiple();
        $datosCuentas = array();
        $sqlCuentas = "SELECT * FROM `cuentasbancarias`; ";
        $rs_Cuentas = $multiple->ExcecuteQueryAllInAgency($sqlCuentas, $db);
        foreach ($rs_Cuentas as $colCuentass) {

            $json = array(
                'CodigoBanco' => $colCuentass['CodBanco'],
                'CodCuentaBancaria' => $colCuentass['CodCuentaBancaria'],
                'Nombre' => $colCuentass['NombreCuentaBancaria']
            );
            array_push($datosCuentas, $json);
        }
        return $datosCuentas;
    }

    public function getFormasPago($db) {
//FormasPago
        $multiple = new Multiple();
        $datosFormasPago = array();
        $sqlFormasPago = "SELECT * FROM `formaspago`; ";
        $rs_FormasPago = $multiple->ExcecuteQueryAllInAgency($sqlFormasPago, $db);
        foreach ($rs_FormasPago as $colFormasPago) {

            if ($colFormasPago['CodigoFormadePago'] == '004' || $colFormasPago['CodigoFormadePago'] == '006' || $colFormasPago['CodigoFormadePago'] == '007' || $colFormasPago['CodigoFormadePago'] == '008') {

                $json = array(
                    'CodigoFormadePago' => $colFormasPago['CodigoFormadePago'],
                    'Descripcion' => $colFormasPago['Descripcion'],
                    'CuentaPuente' => $colFormasPago['CuentaPuente']
                );
                array_push($datosFormasPago, $json);
            }
        }
        return $datosFormasPago;
    }

    public function getMotivosSaldo($db) {
//motivossaldo
        $multiple = new Multiple();
        $datosMotivos = array();
        $sqlMotivos = "SELECT * FROM `motivossaldo`; ";
        $rs_Motivos = $multiple->ExcecuteQueryAllInAgency($sqlMotivos, $db);
        foreach ($rs_Motivos as $colMotivos) {
            $json = array(
                'CodMotivoSaldo' => $colMotivos['CodMotivoSaldo'],
                'Nombre' => $colMotivos['Nombre']
            );
            array_push($datosMotivos, $json);
        }
        return $datosMotivos;
    }

    public function getMotivosGestiondeCobros($db) {
//motivosgestiondecobros
        $multiple = new Multiple();
        $datosMotivosGestion = array();
        $sqlMotivos = "SELECT * FROM `motivosgestiondecobros`; ";
        $rs_Motivos = $multiple->ExcecuteQueryAllInAgency($sqlMotivos, $db);
        foreach ($rs_Motivos as $colMotivos) {
            $json = array(
                'CodMotivoSaldo' => $colMotivos['CodMotivoGestion'],
                'Nombre' => $colMotivos['Nombre']
            );
            array_push($datosMotivosGestion, $json);
        }
        return $datosMotivosGestion;
    }

    public function getMotivosDevolucionProveedor($db) {
//motivosDevoluciones
        $multiple = new Multiple();
        $datosMotivosDevolucion = array();
        $datosMotivosDevolucionArticulo = array();
        $sqlMotivos = "SELECT * FROM `motivosdevolucionproveedor`; ";
        $rs_Motivos = $multiple->ExcecuteQueryAllInAgency($sqlMotivos, $db);
        foreach ($rs_Motivos as $colMotivos) {
            $json = array(
                'CodigoMotivoDevolucion' => $colMotivos['CodigoMotivoDevolucion'],
                'CodigoGrupoMotivoDevolucion' => $colMotivos['CodigoGrupoMotivoDevolucion'],
                'NombreMotivoDevolucion' => $colMotivos['NombreMotivoDevolucion'],
                'CuentaProveedor' => $colMotivos['CuentaProveedor']
            );
            array_push($datosMotivosDevolucion, $json);

            $sqlMotivosArticulo = "SELECT * FROM motivosdevolucionproveedorarticulo WHERE CodigoMotivoDevolucion='" . $colMotivos['CodigoMotivoDevolucion'] . "' AND CuentaProveedor='" . $colMotivos['CuentaProveedor'] . "';";
            $rs_motivosArticulo = $multiple->ExcecuteQueryAllInAgency($sqlMotivosArticulo, $db);
            foreach ($rs_motivosArticulo as $colMotivosArticulo) {
                $jsonArticulo = array(
                    'CodigoMotivoDevolucion' => $colMotivosArticulo['CodigoMotivoDevolucion'],
                    'CodigoArticulo' => $colMotivosArticulo['CodigoArticulo'],
                    'CuentaProveedor' => $colMotivosArticulo['CuentaProveedor']
                );
                array_push($datosMotivosDevolucionArticulo, $jsonArticulo);
            }
        }
        return array('datosMotivosDevolucion' => $datosMotivosDevolucion, 'datosMotivosDevolucionArticulo' => $datosMotivosDevolucionArticulo);
    }

    public function getProveedores($db) {
//Proveedores
        $multiple = new Multiple();
        $datosProveedores = array();
        $sqlProveedores = "SELECT * FROM proveedores;";
        $rs_proveedores = $multiple->ExcecuteQueryAllInAgency($sqlProveedores, $db);
        foreach ($rs_proveedores as $colProveedores) {
            $json = array(
                'CodigoCuentaProveedor' => $colProveedores['CodigoCuentaProveedor'],
                'NombreCuentaProveedor' => $colProveedores['NombreCuentaProveedor']
            );
            array_push($datosProveedores, $json);
        }
        return $datosProveedores;
    }

    public function getResponsableNota($db) {
//responsablenota
        $multiple = new Multiple();
        $datosresponsablenota = array();
        $sqlresponsablenota = "SELECT * FROM `responsablenota` WHERE Interfaz <>0; ";
        $rs_responsablenota = $multiple->ExcecuteQueryAllInAgency($sqlresponsablenota, $db);
        foreach ($rs_responsablenota as $colresponsablenota) {
            $json = array(
                'Interfaz' => $colresponsablenota['Interfaz'],
                'Descripcion' => $colresponsablenota['Descripcion']
            );
            array_push($datosresponsablenota, $json);
        }
        return $datosresponsablenota;
    }

    public function getConceptosNotaCredito($db) {
//Concepto Nota Credito
        $multiple = new Multiple();
        $datosconceptosnotacredito = array();
        $sqlconceptosnotacredito = "SELECT * FROM `conceptosnotacredito`";
        $rs_conceptosnotacredito = $multiple->ExcecuteQueryAllInAgency($sqlconceptosnotacredito, $db);
        foreach ($rs_conceptosnotacredito as $colconceptosnotacredito) {
            $json = array(
                'Id' => $colconceptosnotacredito['Id'],
                'CodigoConceptoNotaCredito' => $colconceptosnotacredito['CodigoConceptoNotaCredito'],
                'NombreConceptoNotaCredito' => $colconceptosnotacredito['NombreConceptoNotaCredito'],
                'Interfaz' => $colconceptosnotacredito['Interfaz']
            );
            array_push($datosconceptosnotacredito, $json);
        }
        return $datosconceptosnotacredito;
    }

    public function getRelacioMmotivosNotasRecibos($db) {
//Relacion Consepto notas credito motivos saldo
        $multiple = new Multiple();
        $datosrelacionmotivosnotasrecibos = array();
        $sqlrelacionmotivosnotasrecibos = "SELECT * FROM `relacionmotivosnotasrecibos` ORDER BY `id`";
        $rs_relacionmotivosnotasrecibos = $multiple->ExcecuteQueryAllInAgency($sqlrelacionmotivosnotasrecibos, $db);
        foreach ($rs_relacionmotivosnotasrecibos as $itemrelacionmotivosnotasrecibos) {
            $json = array(
                'Id' => $itemrelacionmotivosnotasrecibos['Id'],
                'IdConceptoNotaCredito' => $itemrelacionmotivosnotasrecibos['IdConceptoNotaCredito'],
                'IdMotivoSaldo' => $itemrelacionmotivosnotasrecibos['IdMotivoSaldo'],
                'Estado' => $itemrelacionmotivosnotasrecibos['Estado']
            );
            array_push($datosrelacionmotivosnotasrecibos, $json);
        }
        return $datosrelacionmotivosnotasrecibos;
    }

    public function getMotivosNoventa($db) {
//MotivoNoVenta
        $multiple = new Multiple();
        $datosMotivosNoVenta = array();
        $sqlMotivoNoVentas = "SELECT CodMotivoNoVenta, Nombre FROM motivosnoventa";
        $rsMotivosNoVenta = $multiple->ExcecuteQueryAllInAgency($sqlMotivoNoVentas, $db);
        foreach ($rsMotivosNoVenta as $colMotivoNoVenta) {
            $json = array(
                'CodMotivoNoVenta' => $colMotivoNoVenta['CodMotivoNoVenta'],
                'Nombre' => $colMotivoNoVenta['Nombre']
            );
            array_push($datosMotivosNoVenta, $json);
        }
        return $datosMotivosNoVenta;
    }

    public function getTipoDocumento($db) {
//TipoDocumento
        $multiple = new Multiple();
        $datosTipoDocumento = array();
        $sqlTipoDocumento = "SELECT * FROM tipodocumento";
        $rsTipoDocumento = $multiple->ExcecuteQueryAllInAgency($sqlTipoDocumento, $db);
        foreach ($rsTipoDocumento as $colTipoDocumento) {
            $json = array(
                'Codigo' => $colTipoDocumento['Codigo'],
                'Nombre' => $colTipoDocumento['Nombre']
            );
            array_push($datosTipoDocumento, $json);
        }
        return $datosTipoDocumento;
    }

    public function getDatosImpresion($db) {
//Datos Impresion
        $multiple = new Multiple();
        $datosImpresion = array();
        $sqlImpre = "SELECT * FROM datosimpresion";
        $rsImpre = $multiple->ExcecuteQueryAllInAgency($sqlImpre, $db);
        foreach ($rsImpre as $colTImpre) {
            $json = array(
                'Id' => $colTImpre['Id'],
                'Nit' => $colTImpre['Nit'],
                'Sucursal' => $colTImpre['Sucursal'],
                'Telefono' => $colTImpre['Telefono'],
                'Fax' => $colTImpre['Fax'],
                'NombreEmpresa' => $colTImpre['NombreEmpresa']
            );
            array_push($datosImpresion, $json);
        }
        return $datosImpresion;
    }

    public function getBancosCheques() {
        $datosBancos = array();
        $sqlBancos = "SELECT * FROM `bancocheque`; ";
        $rs_Bancos = Yii::app()->db->createCommand($sqlBancos)->queryAll();
        foreach ($rs_Bancos as $colBancos) {
            $json = array(
                'Codigo' => $colBancos['Id'],
                'Nombre' => $colBancos['Descripcion'],
                'Identificador' => $colBancos['CodigoBanco']
            );
            array_push($datosBancos, $json);
        }
        return json_encode($datosBancos);
    }

    public function getCondicionesPago($db) {
//condicionespago
        $multiple = new Multiple();
        $datosCondiciones = array();
        $sqlCondiciones = "SELECT * FROM `condicionespago` WHERE (Dias>0 OR Descripcion='Contado') ORDER BY `condicionespago`.`Dias` ASC; ";
        $rs_cltesCondiciones = $multiple->ExcecuteQueryAllInAgency($sqlCondiciones, $db);
        foreach ($rs_cltesCondiciones as $colCondiciones) {
            $json = array(
                'CodigoCondicionPago' => $colCondiciones['CodigoCondicionPago'],
                'Descripcion' => $colCondiciones['Descripcion'],
                'Dias' => $colCondiciones['Dias']
            );
            array_push($datosCondiciones, $json);
        }
        return $datosCondiciones;
    }

    public function getConfiguracion($db, $usuario) {
// configuracion
        $multiple = new Multiple();
        $configuracionImpresion = array();
        $cuantos = $this->countZonaVentasAlmacen($usuario, $db);
        if ($cuantos > 0) {
            $sqlIMpr = "SELECT * FROM `configuracion` WHERE Id='1'; ";
            $rs_clteIMpres = $multiple->ExcecuteQueryAllInAgency($sqlIMpr, $db);
            foreach ($rs_clteIMpres as $rs_cltesIm) {
                $json = array(
                    'Id' => $rs_cltesIm['Id'],
                    'NombreCiudad' => $rs_cltesIm['NombreCiudad'],
                    'NombreEmpresa' => $rs_cltesIm['NombreEmpresa'],
                    'NombreSucursal' => $rs_cltesIm['NombreSucursal'],
                    'NitSucursal' => $rs_cltesIm['NitSucursal'],
                    'Direccion1Sucursal' => $rs_cltesIm['Direccion1Sucursal'],
                    'Direccion2Sucursal' => $rs_cltesIm['Direccion2Sucursal'],
                    'Direccion3Sucursal' => $rs_cltesIm['Direccion3Sucursal'],
                    'TelefonoSucursal' => $rs_cltesIm['TelefonoSucursal'],
                    'FaxSucursal' => $rs_cltesIm['FaxSucursal'],
                    'TelefonoServicioCliente' => $rs_cltesIm['TelefonoServicioCliente'],
                    'Resolucion1Contribuyentes' => $rs_cltesIm['Resolucion1Contribuyentes'],
                    'Resolucion2Contribuyentes' => $rs_cltesIm['Resolucion2Contribuyentes'],
                    'Resolucion1Retenedores' => $rs_cltesIm['Resolucion1Retenedores'],
                    'Resolucion2Retenedores' => $rs_cltesIm['Resolucion2Retenedores'],
                    'Resolucion1Dian' => $rs_cltesIm['Resolucion1Dian'],
                    'Resolucion2Dian' => $rs_cltesIm['Resolucion2Dian'],
                    'Resolucion3Dian' => $rs_cltesIm['Resolucion3Dian'],
                    'Resolucion4Dian' => $rs_cltesIm['Resolucion4Dian'],
                    'TextoPieFactura1' => $rs_cltesIm['TextoPieFactura1'],
                    'TextoPieFactura2' => $rs_cltesIm['TextoPieFactura2'],
                    'TextoPieFactura3' => $rs_cltesIm['TextoPieFactura3'],
                    'TextoPieFactura4' => $rs_cltesIm['TextoPieFactura4'],
                    'TextoPieFactura5' => $rs_cltesIm['TextoPieFactura5'],
                    'TextoPieFactura6' => $rs_cltesIm['TextoPieFactura6'],
                    'TextoPieFactura7' => $rs_cltesIm['TextoPieFactura7'],
                    'TextoPieFactura8' => $rs_cltesIm['TextoPieFactura8'],
                    'TextoPieFactura9' => $rs_cltesIm['TextoPieFactura9'],
                    'TextoPieFactura10' => $rs_cltesIm['TextoPieFactura10']
                );
                array_push($configuracionImpresion, $json);
            }
        }
        return $configuracionImpresion;
    }

    public function getTipovia($db) {
//Tipovias
        $multiple = new Multiple();
        $datosTipoVia = array();
        $sqlTipoVia = "SELECT * FROM `tipovia` ORDER BY `Tipo`;";
        $rsTipoV = $multiple->ExcecuteQueryAllInAgency($sqlTipoVia, $db);
        foreach ($rsTipoV as $colTipoV) {
            $json = array(
                'Tipo' => $colTipoV['Tipo'],
                'Descripcion' => $colTipoV['Descripcion']
            );
            array_push($datosTipoVia, $json);
        }
        return $datosTipoVia;
    }

    public function getTipoviaComplemento($db) {
//Complementos
        $multiple = new Multiple();
        $datosTipoComplemento = array();
        $sqlTipoComple = "SELECT * FROM `tipoviacomplemento` ORDER BY Tipo;";
        $rsTComple = $multiple->ExcecuteQueryAllInAgency($sqlTipoComple, $db);
        foreach ($rsTComple as $colComple) {
            $json = array(
                'Tipo' => $colComple['Tipo'],
                'Descripcion' => $colComple['Descripcion']
            );
            array_push($datosTipoComplemento, $json);
        }
        return $datosTipoComplemento;
    }

    public function getFechaActualizaciones($db, $usuario) {
//Fecha Actualizacion
        $multiple = new Multiple();
        $fechaActualizacionInfo = array();
        $sqlTipoComple = "SELECT * FROM `fechaactualizaciones` WHERE CodZonaVentas = '" . $usuario . "'";
        $rsTComple = $multiple->ExcecuteQueryAllInAgency($sqlTipoComple, $db);
        foreach ($rsTComple as $colComple) {
            $json = array(
                'CodZonaVentas' => $colComple['CodZonaVentas'],
                'FechaComparacion' => $colComple['FechaComparacion'],
                'HoraComparacion' => $colComple['HoraComparacion'],
                'estado' => "1",
            );
            array_push($fechaActualizacionInfo, $json);
        }
        return $fechaActualizacionInfo;
    }

    public function getMallaactivacion($db, $usuario) {
//Malla de activacion
        $multiple = new Multiple();
        $datosMallaActivacion = array();
        $sqlTipoComple = "SELECT * FROM `mallaactivacion` WHERE CodZonaVentas = '$usuario'";
        $rsTComple = $multiple->ExcecuteQueryAllInAgency($sqlTipoComple, $db);
        foreach ($rsTComple as $colComple) {
            $json = array(
                'Id' => $colComple['Id'],
                'DiasHabiles' => $colComple['DiasHabiles'],
                'DiasTranscurridos' => $colComple['DiasTranscurridos'],
                'Mes' => $colComple['Mes'],
                'Annio' => $colComple['Año'],
                'CodAgencia' => $colComple['CodAgencia'],
                'NombreAgencia' => $colComple['NombreAgencia'],
                'CodZonaVentas' => $colComple['CodZonaVentas']
            );
            array_push($datosMallaActivacion, $json);
        }
        return $datosMallaActivacion;
    }

    public function getMallaActivacionDetalle($db, $usuario) {
//Malla de activacion detalle
        $multiple = new Multiple();
        $datosMallaActivacionDetalle = array();
        $sqlTipoComple = "SELECT * FROM `mallaactivaciondetalle` WHERE IdMallaActivacion IN(SELECT DISTINCT(Id) FROM `mallaactivacion` WHERE CodZonaVentas = '$usuario')";
        $rsTComple = $multiple->ExcecuteQueryAllInAgency($sqlTipoComple, $db);
        foreach ($rsTComple as $colComple) {
            $json = array(
                'Id' => $colComple['Id'],
                'IdMallaActivacion' => $colComple['IdMallaActivacion'],
                'Tipo' => $colComple['Tipo'],
                'Presupuestado' => $colComple['Presupuestado'],
                'CuentaCliente' => $colComple['CuentaCliente'],
                'NombreCliente' => $colComple['NombreCliente'],
                'Ejecutado' => $colComple['Ejecutado'],
                'Cumplimiento' => $colComple['Cumplimiento']
            );
            array_push($datosMallaActivacionDetalle, $json);
        }
        return getMallaActivacionDetalle;
    }

    public function getProveedoresVentadirecta($db, $usuario) {

        $multiple = new Multiple();
        $datosProveedoresVentaDirecta = array($usuario, $db);
        $infoZonaventasAlmacen = $this->infoZonaVentasAlmacen();
        $codAgenciaProveedores = $infoZonaventasAlmacen['Agencia'];
        $sql = "SELECT confi.*,pro.NombreCuentaProveedor FROM `proveedoresventadirecta` confi INNER JOIN proveedores as pro ON confi.CodProveedor=pro.CodigoCuentaProveedor WHERE confi.CodAgencia = '$codAgenciaProveedores'";
        $rsProveedores = $multiple->ExcecuteQueryAllInAgency($sql, $db);
        foreach ($rsProveedores as $colProveedoresVentaDirecta) {
            $json = array(
                'CodProveedor' => $colProveedoresVentaDirecta['CodProveedor'],
                'NombreProveedor' => $colProveedoresVentaDirecta['NombreCuentaProveedor'],
                'CodAgencia' => $colProveedoresVentaDirecta['CodAgencia']
            );

            array_push($datosProveedoresVentaDirecta, $json);
        }
        return json_encode($datosProveedoresVentaDirecta);
    }

    public function getUnidadesdeConversion($db) {
//Unidades COnversion
        $multiple = new Multiple();
        $datosUni = array();
        $sqlUni = "SELECT * FROM `unidadesdeconversion`;";
// $sqlUni = "SELECT u.* FROM `unidadesdeconversion` AS u INNER JOIN portafolio AS p ON u.CodigoArticulo=p.CodigoArticulo INNER JOIN zonaventas AS z ON p.CodigoGrupoVentas=z.CodigoGrupoVentas WHERE z.CodZonaVentas='" . $usuario . "' GROUP BY u.Id;";
        $rs_cltesUni = $multiple->ExcecuteQueryAllInAgency($sqlUni, $db);
        foreach ($rs_cltesUni as $colUni) {

            $factor = str_replace(",00", "", $colUni['Factor']);
            $json = array(
                'Id' => $colUni['Id'],
                'CodigoArticulo' => $colUni['CodigoArticulo'],
                'CodigoDesdeUnidad' => $colUni['CodigoDesdeUnidad'],
                'CodigoHastaUnidad' => $colUni['CodigoHastaUnidad'],
                'Factor' => $factor
            );
            array_push($datosUni, $json);
        }
        return $datosUni;
    }

    public function countZonaVentasAlmacen($usuario, $db) {
        //Rangos Facturacion
        $multiple = new Multiple();
        $sqlCOn = "SELECT COUNT(*) AS Cuantos FROM `zonaventaalmacen` WHERE CodZonaVentas='" . $usuario . "' AND (Autoventa='Verdadero' OR Autoventa='verdadero');";
        $cuantos = $multiple->consultaAgenciaRow($db, $sqlCOn);
        return $cuantos[''];
    }

    public function infoZonaVentasAlmacen($usuario, $db) {
// Descargo los proveedores de venta directa
        $multiple = new Multiple();
        $sqlAlmacenZona = "SELECT CodZonaVentas, VentaDirecta, `Agencia` FROM `zonaventaalmacen` WHERE CodZonaVentas = '$usuario' LIMIT 1";
        $resultadoAlmacenZona = $multiple->consultaAgenciaRow($db, $sqlAlmacenZona);
        return $resultadoAlmacenZona;
    }

    public function countResolucionZonaventas($zonaVentas) {
// Descargo los proveedores de venta directa
        $sqlCOun = "SELECT COUNT(*) AS cuantos FROM `resolucionesentregadas` WHERE `ZonaVentas`='" . $zonaVentas . "';";
        $count = Yii::app()->db->createCommand($sqlCOun)->queryRow();
        return $count['cuantos'];
    }

    public function getRangoFinal() {
// Descargo los proveedores de venta directa
        $sqlMax = "SELECT MAX(`RangoFinal`) AS max FROM `resolucionesentregadas`;";
        $resultado = Yii::app()->db->createCommand($sqlMax)->queryRow();
        return $resultado['max'];
    }

    public function getRangoHasta() {
// Descargo los proveedores de venta directa
        $rangoFinal = "SELECT `RangoHasta` FROM `resoluciones` WHERE `CodigoResolucion` ='002';";
        $resultado = Yii::app()->db->createCommand($rangoFinal)->queryRow();
        return $resultado['RangoHasta'];
    }

    public function getCantidadRangoFactura() {
// Descargo los proveedores de venta directa
        $cantidadRangoFactura = "SELECT `CantidadRangoFactura` FROM `resoluciones` WHERE `CodigoResolucion` ='002';";
        $resultado = Yii::app()->db->createCommand($cantidadRangoFactura)->queryRow();
        return $resultado['CantidadRangoFactura'];
    }

    public function getResolucion() {
// Descargo los proveedores de venta directa
        $cantidadRangoFactura = "SELECT `CantidadRangoFactura` FROM `resoluciones` WHERE `CodigoResolucion` ='002';";
        $resultado = Yii::app()->db->createCommand($cantidadRangoFactura)->queryRow();
        return $resultado;
    }

    public function insertResolucionesEntregadas($resultDatos, $zonaVentas, $rangoIncial, $rangoActual, $rangoFinal) {
// Descargo los proveedores de venta directa
        $sqlInset = "INSERT INTO `resolucionesentregadas`(`CodigoResolucion`, `NumeroResolucion`, `Prefijo`, `RangoDesde`, `RangoHasta`, `AlarmaNumero`, `FechaInicio`, `FechaFinal`, `AlarmaFecha`, `CodigoSecuencia`, `ZonaVentas`, `FechaEntrega`, `HoraEntrega`, `RangoInicial`, `RangoActual`, `RangoFinal`) VALUES ('" . $resultDatos['CodigoResolucion'] . "','" . $resultDatos['NumeroResolucion'] . "','" . $resultDatos['Prefijo'] . "','" . $resultDatos['RangoDesde'] . "','" . $resultDatos['RangoHasta'] . "','" . $resultDatos['AlarmaNumero'] . "','" . $resultDatos['FechaInicio'] . "','" . $resultDatos['FechaFinal'] . "','" . $resultDatos['AlarmaFecha'] . "','" . $resultDatos['CodigoSecuencia'] . "','" . $zonaVentas . "',CURDATE(),CURTIME(),'" . $rangoIncial . "','" . $rangoActual . "','" . $rangoFinal . "')";
        $resultado = Yii::app()->db->createCommand($sqlInset)->query();
        return 'OK';
    }

    public function getRangosResolucion($zonaVentas) {
        $sqlU = "SELECT `RangoInicial`,`RangoActual`,`RangoFinal`,FechaEntrega FROM `resolucionesentregadas` WHERE `ZonaVentas`='" . $zonaVentas . "' ORDER BY `resolucionesentregadas`.`IdResolucion` DESC  ;";
        $resultado = Yii::app()->db->createCommand($sqlU)->queryRow();
        return $resultado;
    }

}
