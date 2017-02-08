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
            $agencia = Yii::app()->user->_Agencia;

            $cont = 1;
            $sql = "SELECT convendedor.CodZonaVentas,zv.NombreZonadeVentas,convendedor.CodAsesor,convendedor.FechaConsignacion,convendedor.NroConsignacion,convendedor.Banco,convendedor.CuentaConsignacion,convendedor.ValorConsignadoEfectivo,convendedor.ValorConsignadoCheque,convendedor.Oficina,convendedor.Ciudad,asesor.Nombre as NombreAsesor,convendedor.Responsable,convendedor.IdentificadorBanco,convendedor.HoraConsignacion,convendedor.FechaConsignacionVendedor,convendedor.ArchivoXml FROM `consignacionesvendedor` as convendedor 
                  join asesorescomerciales as asesor on convendedor.CodAsesor=asesor.CodAsesor 
                  join zonaventas as zv on convendedor.CodZonaVentas=zv.CodZonaVentas 
                  join gruposventas gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas
                  join agencia ag on gr.CodAgencia=ag.CodAgencia
                  WHERE convendedor.CodZonaVentas in(";
            if ($cont == count($zona)) {

                $sql.=" '" . $zona . "') ";
            } else {
                $sql.=" '" . $zona . "', ";
            }
            $cont++;

            $sql.=" AND convendedor.FechaConsignacion BETWEEN  '" . $fechaini . "' AND '" . $fechafin . "' GROUP BY  convendedor.IdConsignacion ORDER BY convendedor.CodZonaVentas";


            $datalleConsigVendedor = ReporteFzNoVentas::model()->getGenrarDetalleConsignacionVeendedor($sql, $agencia);

            $this->renderPartial('_ResumenDiaConsignacionVendedor', array(
                'arraypuhs' => $datalleConsigVendedor,
                'fechaini' => $fechaini,
                'fechafin' => $fechafin,
                'sql' => $sql
            ));
        }
    }

    public function actionAjaxGenerarNotasCreditoZona() {


        if ($_POST) {


            $zona = $_POST['zona'];
            $fechaini = $_POST['fechaini'];
            $fechafin = $_POST['fechafin'];
            $agencia = Yii::app()->user->_Agencia;
            //$arraypuhs= array();


            $cont = 1;
            $sql = "SELECT nota.IdNotaCredito,nota.CodAsesor,nota.CodZonaVentas,nota.CuentaCliente,concep.NombreConceptoNotaCredito,res.Descripcion,zv.NombreZonadeVentas,asesor.Nombre,nota.Responsable,nota.Fecha,nota.Hora,nota.Valor,cli.NombreCliente,nota.Factura,nota.ResponsableNota,nota.Fabricante,nota.Observacion,nota.ArchivoXml FROM `notascredito` as nota 
                  join responsablenota as res on nota.ResponsableNota=res.Interfaz
                  join conceptosnotacredito concep on nota.Concepto=concep.CodigoConceptoNotaCredito 
                  join zonaventas as zv on nota.CodZonaVentas=zv.CodZonaVentas
                  join gruposventas gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas
                  join agencia ag on gr.CodAgencia=ag.CodAgencia
                  join asesorescomerciales as asesor on nota.CodAsesor=asesor.CodAsesor 
                  join cliente as cli on nota.CuentaCliente=cli.CuentaCliente 
                  WHERE nota.CodZonaVentas in(";
            if ($cont == count($zona)) {

                $sql.=" '" . $zona . "') ";
            } else {
                $sql.=" '" . $zona . "', ";
            }
            $cont++;

            $sql.=" AND nota.Fecha BETWEEN  '" . $fechaini . "' AND '" . $fechafin . "' GROUP BY nota.IdNotaCredito ORDER BY nota.CodZonaVentas";


            $datalleNotasCredito = ReporteFzNoVentas::model()->getGenrarDetalleNotasCredito($sql, $agencia);

            $this->renderPartial('_ResumenDiaNotasCretido', array(
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

    public function actionAjaxDetalleFotosZona() {

        $cont = 0;
        if ($_POST) {

            $id = $_POST['id'];
            $agencia = Yii::app()->user->_Agencia;


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
                  <a href="images/photos/media6.png" data-rel="prettyPhoto">
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

    public function actionAjaxGenerarRecibosZona() {

        if ($_POST) {

            $zona = $_POST['zona'];
            $fechaini = $_POST['fechaini'];
            $fechafin = $_POST['fechafin'];
            $agencia = Yii::app()->user->_Agencia;


            $cont = 1;
            $sql = "SELECT caja.Id,caja.CodAsesor,caja.CuentaCliente,caja.Responsable,caja.ZonaVenta,cli.NombreCliente,zv.NombreZonadeVentas,asesor.Nombre as Asesor,reci.NumeroFactura,reci.ValorAbono,reci.DtoProntoPago,caja.Fecha,caja.Hora,caja.Provisional,ag.CodAgencia,caja.ArchivoXml FROM `reciboscaja` as caja
                  join zonaventas as zv on caja.ZonaVenta=zv.CodZonaVentas
                  join gruposventas gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas
                  join agencia ag on gr.CodAgencia=ag.CodAgencia
                  join cliente as cli on caja.CuentaCliente=cli.CuentaCliente 
                  join asesorescomerciales as asesor on caja.CodAsesor=asesor.CodAsesor 
                  join reciboscajafacturas as reci on caja.Id=reci.IdReciboCaja
                  WHERE caja.ZonaVenta  in(";
            if ($cont == count($zona)) {

                $sql.=" '" . $zona . "') ";
            } else {
                $sql.=" '" . $zona . "', ";
            }
            $cont++;

            $sql.="AND caja.Fecha  BETWEEN  '" . $fechaini . "' AND '" . $fechafin . "' GROUP BY caja.`Id` ORDER BY caja.ZonaVenta";


            $datalleRecibos = ReporteFzNoVentas::model()->getGenrarDetalleRecibos($sql, $agencia);

            $this->renderPartial('_ResumenDiaRecibos', array(
                'arraypuhs' => $datalleRecibos
            ));
        }
    }

    public function actionAjaxDetalleEfectivoZona() {

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

    public function actionAjaxDetalleEfectivoConsignacionZona() {

        if ($_POST) {

            $id = $_POST['id'];
            $agencia = $_POST['agencia'];

            $tabladetalle = "";

            $detalle = ReporteFzNoVentas::model()->getGenerarDetalleEfectivoConsignacion($id, $agencia);


            $tabladetalle.='<table border="1" style="width: 100%">
                       
                        <tr style="background-color: #C5D9F1; font-size: 12px;">
                          <td align="center"><b>Nro Factura</b></td>
                          <td align="center"><b>Nro Consignación</b></td>
                           
                          <td align="center"><b>Nombre Banco</b></td>
                           
                           <td align="center"><b>Cuenta</b></td>
                          <td align="center"><b>Fecha Consignación Efectivo</b></td>
                           
                           <td align="center"><b>Valor</b></td>
                          
                           
                        </tr> ';


            foreach ($detalle as $itemefectivoconsig) {

                $tabladetalle.='
                         <tr>
                            <td align="center">' . $itemefectivoconsig['NumeroFactura'] . '</td>
                            <td align="center">' . $itemefectivoconsig['NroConsignacionEfectivo'] . '</td>
                                
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

    public function actionAjaxDetalleChequeZona() {

        if ($_POST) {

            $id = $_POST['id'];
            $agencia = $_POST['agencia'];

            $tabladetalle = "";

            $detalle = ReporteFzNoVentas::model()->getGenerarDetalleCheque($id, $agencia);


            $tabladetalle.='<table border="1" style="width: 100%">
                       
                        <tr style="background-color: #C5D9F1; font-size: 12px;">
                          <td align="center"><b>Nro Factura</b></td>
                          <td align="center"><b>Nro Cheque</b></td>
                           
                          <td align="center"><b>Cód Banco</b></td>
                            
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

    public function actionAjaxDetalleChequeConsignacionZona() {

        if ($_POST) {

            $id = $_POST['id'];
            $agencia = $_POST['agencia'];


            $tabladetalle = "";

            $detalle = ReporteFzNoVentas::model()->getGenerarDetalleChequeConsignacion($id, $agencia);



            $tabladetalle.='<table border="1" style="width: 100%">
                       
                        <tr style="background-color: #8DB4E2; font-size: 12px;">
                          <td align="center"><b>Nro Factura</b></td>
                          <td align="center"><b>Nro Consignación</b></td>
                           
                          <td align="center"><b>Nombre Banco</b></td>
                           
                          <td align="center"><b>Cuenta</b></td>
                          <td align="center"><b>Fecha Cheque</b></td>
                                 
                        </tr> ';


            foreach ($detalle as $itemechequeconsignacion) {

                $tabladetalle.='
                         <tr>
                            <td align="center">' . $itemechequeconsignacion['NumeroFactura'] . '</td>
                            <td align="center">' . $itemechequeconsignacion['NroConsignacionCheque'] . '</td>
                                
                            <td align="center">' . $itemechequeconsignacion['Nombre'] . '</td>
                                
                            <td align="center">' . $itemechequeconsignacion['CodCuentaBancaria'] . '</td>
                            <td align="center">' . $itemechequeconsignacion['Fecha'] . '</td>
                           
                           
                            
                        </tr>    ';
            }
            $tabladetalle.='</table>';

            $tabladetalle.='<table border="1" style="width: 100%">
                       
                        <tr style="background-color: #C5D9F1; font-size: 12px;">
                          <td align="center"><b>Nro Cheque</b></td>
                          <td align="center"><b>Cód Banco</b></td>
                           
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

    public function actionAjaxGenerarDetalleDevolucionesZona() {

        if ($_POST) {

            $zona = $_POST['zona'];
            $fechaini = $_POST['fechaini'];
            $fechafin = $_POST['fechafin'];
            $agencia = Yii::app()->user->_Agencia;

            $cont = 1;
            $sql = "SELECT devo.IdDevolucion,devo.CuentaCliente,motivodevo.NombreMotivoDevolucion,devo.TotalDevolucion,devo.ValorDevolucion,devo.Observacion,prove.NombreCuentaProveedor,devo.FechaDevolucion,jerar.NombreEmpleado,zv.NombreZonadeVentas,cli.NombreCliente,devo.Horafinal,sit.Nombre,devo.CodZonaVentas,devo.Responsable,ag.CodAgencia FROM `devoluciones` as devo
                  join motivosdevolucionproveedor as motivodevo on devo.CodigoMotivoDevolucion=motivodevo.CodigoMotivoDevolucion
                  join proveedores prove on devo.CuentaProveedor=prove.CodigoCuentaProveedor
                  join zonaventas as zv on devo.CodZonaVentas=zv.CodZonaVentas 
                  join gruposventas gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas
                  join agencia ag on gr.CodAgencia=ag.CodAgencia
                  join cliente as cli on devo.CuentaCliente=cli.CuentaCliente
                  left join jerarquiacomercial jerar on devo.Responsable=jerar.NumeroIdentidad 
                  join sitios as sit on devo.CodigoSitio=sit.CodSitio
                  WHERE devo.CodZonaVentas  in(";
            if ($cont == count($zona)) {

                $sql.=" '" . $zona . "') ";
            } else {
                $sql.=" '" . $zona . "', ";
            }
            $cont++;

            $sql.=" AND devo.FechaDevolucion  BETWEEN  '" . $fechaini . "' AND '" . $fechafin . "' GROUP BY devo.IdDevolucion ORDER BY devo.IdDevolucion";


            $datalleDevoluciones = ReporteFzNoVentas::model()->getGenrarDetalleDevoluciones($sql, $agencia);

            $this->renderPartial('_ResumenDiaDevoluciones', array(
                'arraypuhs' => $datalleDevoluciones
            ));
        }
    }

    public function actionAjaxGenerarDetallePedidoZona() {

        if ($_POST) {

            $zona = $_POST['zona'];
            $fechaini = $_POST['fechaini'];
            $fechafin = $_POST['fechafin'];
            $agencia = Yii::app()->user->_Agencia;

            $cont = 1;
            $sql = "SELECT pe.IdPedido,pe.CodZonaVentas,pe.CuentaCliente,pe.FechaPedido,pe.FormaPago,pe.TotalValorImpoconsumo,pe.ValorPedido,pe.TotalPedido,pe.TotalValorIva,pe.TotalSubtotalBaseIva,grupre.NombreGrupodePrecio,grupventas.NombreGrupoVentas,zv.NombreZonadeVentas,cli.NombreCliente,pe.Responsable,jerar.NombreEmpleado,pe.HoraEnviado,alma.Nombre as NombreAlmacen,sit.Nombre as NombreSitio,pe.Plazo,pe.TipoVenta,pe.ActividadEspecial,pe.FechaEntrega,pe.Observacion,ag.CodAgencia FROM `pedidos` as pe 
                  join grupodeprecios as grupre on pe.CodGrupoPrecios=grupre.CodigoGrupoPrecio
                  join zonaventas as zv on pe.CodZonaVentas=zv.CodZonaVentas
                  join gruposventas as grupventas on zv.CodigoGrupoVentas=grupventas.CodigoGrupoVentas 
                  join agencia ag on grupventas.CodAgencia=ag.CodAgencia
                  join cliente as cli on pe.CuentaCliente=cli.CuentaCliente 
                  left join jerarquiacomercial jerar on pe.Responsable=jerar.NumeroIdentidad 
                  join almacenes as alma on pe.CodigoAlmacen=alma.CodigoAlmacen 
                  join sitios as sit on pe.CodigoSitio=sit.CodSitio
                  WHERE pe.CodZonaVentas in(";
            if ($cont == count($zona)) {

                $sql.=" '" . $zona . "') ";
            } else {
                $sql.=" '" . $zona . "', ";
            }
            $cont++;

            $sql.=" AND pe.FechaPedido BETWEEN  '" . $fechaini . "' AND '" . $fechafin . "' GROUP BY pe.IdPedido ORDER BY pe.CodZonaVentas";


            $datallePedido = ReporteFzNoVentas::model()->getGenrarDetallePedido($agencia, $sql);

            $this->renderPartial('_ResumenDiaPedidos', array(
                'arraypuhs' => $datallePedido
            ));
        }
    }

    public function actionAjaxDetalleKitsZona() {

        if ($_POST) {

            $id = $_POST['id'];
            $agencia = Yii::app()->user->_Agencia;


            $tabladetalle = "";

            $detalle = ReporteFzNoVentas::model()->getGenerarDetalleKits($id, $agencia);
            $information = ReporteFzNoVentas::model()->getInformacionDetalleKit($id, $agencia);

            $tabladetalle.='<table border="1" style="background-color: #C5D9F1; font-size: 12px; width: 100%">
                      
                      <tr>
                          <td  align="center"><b>Cód Variante</b></td>
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
                          <td align="center"><b>Cód Lista Material</b></td>
                          <td align="center"><b>Cód Artículo Componente</b></td>
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

    public function actionAjaxGenerarDetalleFacturasZona() {

        if ($_POST) {

            $zona = $_POST['zona'];
            $fechaini = $_POST['fechaini'];
            $fechafin = $_POST['fechafin'];
            $agencia = Yii::app()->user->_Agencia;

            $cont = 1;
            $sql = "SELECT fac.IdPedido,fac.CodZonaVentas,fac.CuentaCliente,fac.FechaPedido,fac.FormaPago,fac.TotalValorImpoconsumo,fac.ValorPedido,fac.TotalPedido,fac.TotalValorIva,fac.TotalSubtotalBaseIva,grupre.NombreGrupodePrecio,grupventas.NombreGrupoVentas,zv.NombreZonadeVentas,cli.NombreCliente,fac.Responsable,jerar.NombreEmpleado,fac.HoraEnviado,alma.Nombre as NombreAlmacen,sit.Nombre as NombreSitio,fac.Plazo,fac.TipoVenta,fac.ActividadEspecial,fac.FechaEntrega,fac.Observacion,fac.NroFactura,ag.CodAgencia FROM `pedidos` as fac 
                  join grupodeprecios as grupre on fac.CodGrupoPrecios=grupre.CodigoGrupoPrecio
                  join zonaventas as zv on fac.CodZonaVentas=zv.CodZonaVentas
                  join gruposventas as grupventas on zv.CodigoGrupoVentas=grupventas.CodigoGrupoVentas 
                  join agencia ag on grupventas.CodAgencia=ag.CodAgencia
                  join cliente as cli on fac.CuentaCliente=cli.CuentaCliente 
                  left join jerarquiacomercial jerar on fac.Responsable=jerar.NumeroIdentidad 
                  join almacenes as alma on fac.CodigoAlmacen=alma.CodigoAlmacen 
                  join sitios as sit on fac.CodigoSitio=sit.CodSitio WHERE fac.CodZonaVentas in(";
            if ($cont == count($zona)) {

                $sql.=" '" . $zona . "') ";
            } else {
                $sql.=" '" . $zona . "', ";
            }
            $cont++;

            $sql.=" AND fac.Fechapedido  BETWEEN  '" . $fechaini . "' AND '" . $fechafin . "' AND fac.TipoVenta='Autoventa' GROUP BY fac.Idpedido";


            $datalleFactura = ReporteFzNoVentas::model()->getGenrarDetalleFactura($sql, $agencia);

            $this->renderPartial('_ResumenDiaFactura', array(
                'arraypuhs' => $datalleFactura
            ));
        }
    }

    public function actionAjaxDetalleKitsFacturasZona() {

        if ($_POST) {

            $id = $_POST['id'];
            $agencia = Yii::app()->user->_Agencia;

            $tabladetalle = "";

            $detalle = ReporteFzNoVentas::model()->getGenerarDetalleKitsFactura($id, $agencia);
            $information = ReporteFzNoVentas::model()->getInformacionDetalleKitFactura($id, $agencia);

            $tabladetalle.='<table border="1" style="width: 100%">
                      
                      <tr style="background-color: #C5D9F1; font-size: 12px;">
                          <td  align="center"><b>Cód Variante</b></td>
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
                          <td align="center"><b>Cód Lista Material</b></td>
                          <td align="center"><b>Cód Artículo Componente</b></td>
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

    public function actionAjaxGenerarDetalleTransConsignacionZona() {


        if ($_POST) {

            $zona = $_POST['zona'];
            $fechaini = $_POST['fechaini'];
            $fechafin = $_POST['fechafin'];
            $agencia = Yii::app()->user->_Agencia;

            $cont = 1;
            $sql = "SELECT transfe.IdTransferencia,transfe.CodZonaVentas,transfe.CuentaCliente,transfe.FechaTransferencia,sit.Nombre as Nombresitio,alam.Nombre as NombreAlma,cli.NombreCliente,zv.NombreZonadeVentas,transfe.Responsable,transfe.HoraEnviado,transfe.ArchivoXml,ag.CodAgencia FROM `transferenciaconsignacion` as transfe 
                  join descripciontransferenciaconsignacion as descri on transfe.IdTransferencia=descri.IdTransferencia
                  join sitios as sit on transfe.CodigoSitio=sit.CodSitio join almacenes as alam on transfe.CodigoAlmacen=alam.CodigoAlmacen 
                  join cliente as cli on transfe.CuentaCliente=cli.CuentaCliente 
                  join zonaventas as zv on transfe.CodZonaVentas=zv.CodZonaVentas
                  join gruposventas gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas
                  join agencia ag on gr.CodAgencia=ag.CodAgencia
                  WHERE transfe.CodZonaVentas in(";

            if ($cont == count($zona)) {

                $sql.=" '" . $zona . "') ";
            } else {
                $sql.=" '" . $zona . "', ";
            }
            $cont++;

            $sql.=" AND transfe.FechaTransferencia BETWEEN  '" . $fechaini . "' AND '" . $fechafin . "' GROUP BY transfe.IdTransferencia ORDER BY transfe.CodZonaVentas";


            $datalleTransConsignacion = ReporteFzNoVentas::model()->getGenrarDetalleTrnasferenciaConsig($sql, $agencia);

            $this->renderPartial('_ResumenDiaTransferenciaConsignacion', array(
                'arraypuhs' => $datalleTransConsignacion
            ));
        }
    }

    public function actionAjaxGenerarDetalleNoVentasZona() {


        if ($_POST) {
            $zona = $_POST['zona'];
            $fechaini = $_POST['fechaini'];
            $fechafin = $_POST['fechafin'];
            $agencia = Yii::app()->user->_Agencia;

            $cont = 1;
            $sql = "SELECT motinov.Nombre as motivonoventa,nov.CodZonaVentas,nov.CuentaCliente,zv.NombreZonadeVentas,cli.NombreCliente,nov.Responsable,nov.FechaNoVenta,nov.HoraNoVenta FROM `noventas` as nov 
                  join motivosnoventa as motinov on nov.CodMotivoNoVenta=motinov.CodMotivoNoVenta 
                  join zonaventas as zv on nov.CodZonaVentas=zv.CodZonaVentas
                  join gruposventas gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas
                  join agencia ag on gr.CodAgencia=ag.CodAgencia
                  join cliente as cli on nov.CuentaCliente=cli.CuentaCliente 
                  WHERE nov.CodZonaVentas in(";
            if ($cont == count($zona)) {

                $sql.=" '" . $zona . "') ";
            } else {
                $sql.=" '" . $zona . "', ";
            }
            $cont++;

            $sql.=" AND nov.FechaNoVenta BETWEEN  '" . $fechaini . "' AND '" . $fechafin . "' ORDER BY nov.CodZonaVentas ASC,nov.FechaNoVenta ASC,nov.HoraNoVenta ASC ";


            $datalle = ReporteFzNoVentas::model()->getGenrarDetalleNoVenta($sql, $agencia);

            $this->renderPartial('_ResumenDiaNoVentas', array(
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

    public function actionAjaxGenerarDetalleClientesNuevosZona() {

        if ($_POST) {

            $zona = $_POST['zona'];
            $fechaini = $_POST['fechaini'];
            $fechafin = $_POST['fechafin'];
            $agencia = Yii::app()->user->_Agencia;

            $cont = 1;
            $sql = "SELECT clinuevo.Posicion,clinuevo.Id,clinuevo.CuentaCliente,clinuevo.CodZonaVentas,clinuevo.Identificacion,clinuevo.Nombre,clinuevo.PrimerNombre,clinuevo.SegundoNombre,clinuevo.PrimerApellido,clinuevo.SegundoApellido,clinuevo.CodigoCiuu,clinuevo.Direccion,clinuevo.Telefono,clinuevo.TelefonoMovil,clinuevo.Email,tipodoc.Nombre as Documento,clinuevo.CodigoPostal,clinuevo.Latitud,clinuevo.Longitud,frevisita.CodFrecuencia as frecuencia,zv.NombreZonadeVentas,clinuevo.RazonSocial,clinuevo.CodTipoDocumento,clinuevo.OtroBarrio,clinuevo.Establecimiento,clinuevo.ArchivoXml,loca.NombreBarrio,loca.NombreLocalidad,loca.NombreCiudad FROM `clientenuevo` as clinuevo 
                 join tipodocumento as tipodoc on clinuevo.CodTipoDocumento=tipodoc.Codigo
	         left join Localizacion as loca on clinuevo.CodBarrio=loca.CodigoBarrio		
                 join frecuenciavisita as frevisita on clinuevo.NumeroVisita=frevisita.NumeroVisita
                 join zonaventas as zv on  clinuevo.CodZonaVentas=zv.CodZonaVentas 
                 join gruposventas gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas
                 join agencia ag on gr.CodAgencia=ag.CodAgencia
                 WHERE clinuevo.CodZonaVentas in(";
            if ($cont == count($zona)) {

                $sql.=" '" . $zona . "') ";
            } else {
                $sql.=" '" . $zona . "', ";
            }
            $cont++;

            $sql.=" AND clinuevo.FechaRegistro   BETWEEN  '" . $fechaini . "' AND '" . $fechafin . "' GROUP BY clinuevo.Id ORDER BY clinuevo.CodZonaVentas";


            $datalleClientesNuevos = ReporteFzNoVentas::model()->getGenrarDetalleClientesNuevos($sql, $agencia);

            $this->renderPartial('_ResumenDiaClientesNuevos', array(
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

    public function actionAjaxGenerarDetalleTransAutoventaZona() {


        if ($_POST) {

            $zona = $_POST['zona'];
            $fechaini = $_POST['fechaini'];
            $fechafin = $_POST['fechafin'];
            $agencia = Yii::app()->user->_Agencia;

            $cont = 1;
            $sql = "SELECT transAuto.`IdTransferenciaAutoventa`,transAuto.`CodZonaVentas`,zv.NombreZonadeVentas,transAuto.`CodZonaVentasTransferencia`,transAuto.`Responsable`,transAuto.`CodigoUbicacionOrigen`,transAuto.`CodigoUbicacionDestino`,transAuto.`FechaTransferenciaAutoventa`,transAuto.`HoraEnviado`,transAuto.ArchivoXml,ag.CodAgencia  FROM `transferenciaautoventa` as transAuto
                  join zonaventas as zv on transAuto.CodZonaVentas=zv.CodZonaVentas
                  join gruposventas gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas
                  join agencia ag on gr.CodAgencia=ag.CodAgencia
                  WHERE transAuto.CodZonaVentas in(";
            if ($cont == count($zona)) {

                $sql.=" '" . $zona . "') ";
            } else {
                $sql.=" '" . $zona . "', ";
            }
            $cont++;

            $sql.=" AND transAuto.FechaTransferenciaAutoventa BETWEEN  '" . $fechaini . "' AND '" . $fechafin . "' ORDER BY transAuto.CodZonaVentas";


            $datalleTransAutoventa = ReporteFzNoVentas::model()->getGenrarDetalleTrnasferenciaAutoventa($sql, $agencia);

            $this->renderPartial('_ResumenDiaTransferenciaAutoventa', array(
                'arraypuhs' => $datalleTransAutoventa
            ));
        }
    }

    public function actionAjaxFormasPagos() {

        if ($_POST) {

            $Zona = $_POST['codzona'];
            $agencia = Yii::app()->user->_Agencia;
            $fechaini = $_POST['fechaini'];
            $fechafin = $_POST['fechafin'];

            $ReciboCaja = ConsignacionVendedor::model()->getRecibosCajas($Zona, $fechaini, $fechafin, $agencia);

            $formaspago.="<div class='table table-bordered' style='width: 530px;'>
           <table class='table' id='table2'>
            ";

            $efectivoAcomulado = 0;
            $chequeAcomulado = 0;
            $consignacionEfectivoAcomulado = 0;
            $consignacionChequeAcomulado = 0;
            $posfechadoAcomulado = 0;
            $total = 0;

            foreach ($ReciboCaja as $itemCaja) {

                $efectivo = 0;
                $cheque = 0;
                $consignacionEfectivo = 0;
                $consignacionCheque = 0;
                $posfechado = 0;

                $ReciboCajaFactura = ConsignacionVendedor::model()->getCajaFactura($itemCaja['Id'], $agencia);
                foreach ($ReciboCajaFactura as $itemCajaFactura) {


                    $Efectivo = ConsignacionVendedor::model()->getEfectivo($itemCajaFactura['Id'], $agencia);
                    $Cheque = ConsignacionVendedor::model()->getCheque($itemCajaFactura['Id'], $agencia);
                    $ConsignacionEfectivo = ConsignacionVendedor::model()->getConsignacionEfectivo($itemCajaFactura['Id'], $agencia);
                    $ConsignacionCheque = ConsignacionVendedor::model()->getConsignacioChequen($itemCajaFactura['Id'], $agencia);
                    $ChequePosfechado = ConsignacionVendedor::model()->getChequePosfechado($itemCajaFactura['Id'], $agencia);

                    if (count($Efectivo) > 0 && ($efectivo != $Efectivo[0]['Valor'])) {
                        $efectivo = $efectivo + $Efectivo[0]['Valor'];
                    }

                    if (count($Cheque) > 0 && ($cheque != $Cheque[0]['Cheque'])) {

                        $cheque = $cheque + $Cheque[0]['Cheque'];
                    }


                    if (count($ConsignacionEfectivo) > 0 && ($consignacionEfectivo != $ConsignacionEfectivo[0]['EfectivoConsignacion'])) {

                        $consignacionEfectivo = $consignacionEfectivo + $ConsignacionEfectivo[0]['EfectivoConsignacion'];
                    }


                    if (count($ConsignacionCheque) > 0 && ($consignacionCheque != $ConsignacionCheque[0]['ConsignacionCheque'])) {

                        $consignacionCheque = $consignacionCheque + $ConsignacionCheque[0]['ConsignacionCheque'];
                    }

                    if (count($ChequePosfechado) > 0 && ($posfechado != $ChequePosfechado[0]['ChequePosfechado'] )) {

                        $posfechado = $posfechado + $ChequePosfechado[0]['ChequePosfechado'];
                    }
                }
                $efectivoAcomulado = $efectivoAcomulado + $efectivo;
                $chequeAcomulado = $chequeAcomulado + $cheque;
                $consignacionEfectivoAcomulado = $consignacionEfectivoAcomulado + $consignacionEfectivo;
                $consignacionChequeAcomulado = $consignacionChequeAcomulado + $consignacionCheque;
                $posfechadoAcomulado = $posfechadoAcomulado + $posfechado;
                            
            }

            $total = $efectivoAcomulado + $chequeAcomulado + $consignacionEfectivoAcomulado + $consignacionChequeAcomulado + $posfechadoAcomulado;

            $formaspago.="
                <tr>
                   <td class='text-center'>Efectivo</td>
                   <td class='text-center'>$ " . number_format($efectivoAcomulado, '2', ',', '.') . "</td>
                </tr> 
                <tr>
                   <td class='text-center'>Cheque</td>
                   <td class='text-center'>$ " . number_format($chequeAcomulado, '2', ',', '.') . "</td>
                </tr> 
                <tr>
                   <td class='text-center'>Cheque Posfechado</td>
                   <td class='text-center'>$ " . number_format($posfechadoAcomulado, '2', ',', '.') . "</td>
                </tr> 
                <tr>
                   <td class='text-center'>Consignacion Efectivo</td>
                   <td class='text-center'>$ " . number_format($consignacionEfectivoAcomulado, '2', ',', '.') . "</td>
                </tr> 
                <tr>
                   <td class='text-center'>Consignacion Cheque</td>
                   <td class='text-center'>$ " . number_format($consignacionChequeAcomulado, '2', ',', '.') . "</td>
                </tr> 
                 <tr>
                   <td class='text-center'>Total</td>
                   <td class='text-center'>$ " . number_format($total, '2', ',', '.') . "</td>
                </tr> 
            ";

            $formaspago.="</table></div>";

            echo $formaspago;
        }
    }

}
