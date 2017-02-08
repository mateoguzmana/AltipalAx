<?php
$session = new CHttpSession;
$session->open();

$codigositio = $session['codigositio'];
$codigoAlmacen = $session['Almacen'];
$tipoVenta = $session['tipoVenta'];
$nombreSitio = $session['nombreSitio'];
$nombreTipoVenta = $session['nombreTipoVenta'];
$session['pedidoForm'] = "";
$session['componenteKitDinamico'] = "";

/* echo $session['Consignacion'];
  exit(); */

$cedula = Yii::app()->user->_cedula;

if (isset($session['EncabezadoPedidoAlamcenado'])) {

    $encabezadoPedidoAlmacenado = $session['EncabezadoPedidoAlamcenado'];

    $zonaVentas = $encabezadoPedidoAlmacenado['CodZonaVentas'];
    $codagencia = Yii::app()->user->_Agencia;
    $CodSitio = $encabezadoPedidoAlmacenado['CodigoSitio'];

    $sitios = 0;
}
?>

<style>
    #tableDetail{
        width: 100% important;
    }       

    .hide_column{
        display : none;
    }

</style>



<div class="pageheader">
    <h2>
        <img src="images/home.png" alt="Ir al menu" class="cursorpointer" class="cursorpointer" id="retornarMenu"  style="width: 38px; margin-right: 15px; margin-left: 15px;"/> 
        Crear Pedido Preventa
        <span></span>
    </h2>      
</div>

<div class="contentpanel">

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-1">
                    <img src="images/cliente.png" class="img-rounded" style="width: 75px; padding-left: 25px;"/>
                </div>
                <div class="col-md-11">
                    <h5> Cuenta:  <span class="text-primary"><?php echo $datosCliente['CuentaCliente']; ?></span></h5>
                    <h5> Nombre: <span class="text-primary"><?php echo $datosCliente['NombreCliente']; ?></span></h5>

                    <input type="hidden" id="txtZonaVentas" value="<?php echo $zonaVentas; ?>"/>
                    <input type="hidden" id="txtCuentaCliente" value="<?php echo $datosCliente['CuentaCliente']; ?>"/>

                </div>
            </div>
        </div>
        <div class="panel-body" style="min-height: 450px;">
            <div class="widget widget-blue">
                <div class="widget-content">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">                         
                            </div>
                            <div class="panel-body panel-body-nopadding">

                                <div id="tabsCrearPedidoPreventa" style="border: 2px solid #eee" class="basic-wizard">
                                    <ul class="nav nav-pills nav-justified">
                                        <li>                                            
                                            <a href="#vtab1" data-toggle="tab">
                                                <img src="images/pedido.png" style="width: 24px; padding-right: 2px;"/>
                                                ENCABEZADO
                                            </a>
                                        </li>
                                        <li><a href="#vtab2" data-toggle="tab">
                                                <img src="images/detalle.png" style="width: 24px; padding-right: 2px;"/>
                                                DETALLE
                                            </a></li>
                                        <li><a href="#vtab3" data-toggle="tab">
                                                <img src="images/totales.png" style="width: 24px; padding-right: 2px;"/>
                                                TOTAL PEDIDO
                                            </a></li>
                                    </ul>

                                    <form class="form" id="frmPedidoPreventa" method="post" action="" >  
                                        <div class="tab-content">

                                            <div class="tab-pane" id="vtab1">


                                                <input type="hidden" id="TotalPedidoAnterior" value="<?php echo $encabezadoPedidoAlmacenado['TotalPedido'] ?>"/>
                                                <input type="hidden" id="almacen" value="<?php echo $codigoAlmacen; ?>">
                                                <input type="hidden" id="sitioActual" value="<?php echo $codigositio; ?>">
                                                <input type="hidden" id="sitios" value="<?php echo $sitios ?>"/>
                                                <input type="hidden" name="zonaVentas" value="<?php echo $zonaVentas; ?>"  id="zonaVentas"/>  
                                                <input type="hidden" name="horaDigitada" value="<?php echo date('H:i:s'); ?>" id="horaDigitada"/> 
                                                <input type="hidden" name="cuentaCliente" value="<?php echo $datosCliente['CuentaCliente']; ?>" id="cuentaCliente"/>
                                                <input type="hidden" name="codigoGrupodeImpuestos" value="<?php echo $datosCliente['CodigoGrupodeImpuestos']; ?>" id="codGrupoImpuesto" />
                                                <input type="hidden" name="codigoZonaLogistica" value="<?php echo $datosCliente['CodigoZonaLogistica']; ?>" id="codZonaLogistica"/>
                                                <input type="hidden" id="txtCedulAasesor" value="<?php echo $cedula ?>"/>
                                                <input type="hidden" id="latitud" name="latitud"/>
                                                <input type="hidden" id="longitud" name="longitud"/>
                                                <input type="hidden" id="pedidosenvaido" value="<?php echo $PedidoEnviados['pedidoactuales'] ?>">

                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Sitio/Almacen</label>
                                                    <div class="col-sm-8">  
                                                        <input type="text" id="select-sitio" data-codigo="<?php echo $codigositio; ?>" required name="sitio" class="form-control" readonly="readonly" value="<?php echo $nombreSitio; ?>"/>

                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Fecha Entrega</label>
                                                    <div class="col-sm-8">  
                                                        <?php
                                                        $modifica = $condicionPago['AplicaContado'];
                                                        ?>
                                                        <input type="text" name="fechaEntrega" class="form-control" id="fechaentrega" readonly="true"  value="<?php echo date('Y-m-d', strtotime('+1 day')) ?>" <?php
                                                        if ($modifica == 'Falso') {
                                                            echo 'id="dtpFechaEntrega"';
                                                        }
                                                        ?>  />
                                                    </div>
                                                </div>

                                                <div class="form-group"> 

                                                    <?php
                                                    if ($modifica == "falso" && $condicionPago['Dias'] > 0 && $condicionPago['SaldoCupo'] > 0) {
                                                        $diasPlazo = $condicionPago['Dias'];
                                                        $diasMinimo = 0;
                                                    } else {
                                                        $diasPlazo = 0;
                                                        $diasMinimo = 0;
                                                    }
                                                    ?>  

                                                    <label class="col-sm-4 control-label">Forma de Pago</label>
                                                    <div class="col-sm-8">                          
                                                        <select name="formaPago" class="form-control" id="formaPagoPreventa" required onchange="credito('<?php echo $modifica ?>')">                                                           
                                                            <?php if ($modifica == "falso" && $condicionPago['Dias'] > 0 && $datosCliente['SaldoCupo'] > 0) { ?>
                                                                <option value="credito" data-dias-pago="<?php echo $diasPlazo; ?>">Crédito</option>
                                                                <option value="contado">Contado</option>
                                                            <?php } else { ?>
                                                                <option value="contado">Contado</option>
                                                            <?php } ?>    
                                                        </select>

                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <?php ?>    
                                                    <label class="col-sm-4 control-label">Plazo</label>
                                                    <div class="col-sm-8">                            

                                                        <select id="plazo" required name="plazo" class="form-control" <?php
                                                        if ($diasPlazo == 0) {
                                                            echo 'readonly="true"';
                                                        }
                                                        ?>  >   
                                                                    <?php if ($diasPlazo == 0 && $diasMinimo == 0) { ?>                                                            
                                                                <option value="022" >0 Días</option>
                                                            <?php } else { ?>
                                                                <?php foreach ($formasPago as $itemFormaPago): ?>
                                                                    <option value="<?php echo $itemFormaPago['CodigoCondicionPago']; ?>"><?php echo $itemFormaPago['Descripcion']; ?></option>

                                                                <?php endforeach; ?>

                                                            <?php } ?>
                                                        </select>

                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Cupo Disponible</label>
                                                    <div class="col-sm-8">
                                                        <?php if ($diasPlazo == 0 && $diasMinimo == 0) { ?>
                                                            <input type="text" id="cupodisponible"  class="form-control" readonly="readonly" value="0"/>
                                                            <input type="hidden" id="cupodisponiblehiden"  class="form-control" value="0"/>
                                                        <?php } else { ?>
                                                            <input type="text" id="cupodisponible"  class="form-control" readonly="readonly" value="<?php echo number_format($datosCliente['SaldoCupo'], '2', ',', '.'); ?>"/>
                                                            <input type="hidden" id="cupodisponiblehiden"  class="form-control" value="<?php echo number_format($datosCliente['SaldoCupo'], '2', ',', '.'); ?>"/>
                                                        <?php } ?>
                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Tipo de Venta</label>
                                                    <div class="col-sm-8">  
                                                        <select id="select-tipo-venta-preventa" name="tipoVenta" required="required" class="form-control">
                                                            <?php if ($session['desPreventa'] == "verdadero"): ?>                                
                                                                <option value="Preventa">Preventa</option> 
                                                                <?php if ($session['Consignacion'] == "verdadero"): ?> 
                                                                    <option value="Consignacion">Consignación</option>                                
                                                                <?php endif; ?>
                                                                <?php if ($session['VentaDirecta'] == "verdadero"): ?>                                
                                                                    <option value="VentaDirecta" data-grupoVenta="<?php echo $GrupoVentas ?>">Venta Directa</option>                                
                                                                <?php endif; ?>
                                                            <?php endif; ?>

                                                            <?php if ($session['desPreventa'] == "falso" && $session['Consignacion'] == "verdadero"): ?> 
                                                                <option value="Consignacion">Consignación</option>    
                                                            <?php endif; ?>                 

                                                        </select>   
                                                    </div>
                                                    <input type="hidden" id="txtzonaventas" value="<?php echo $zonaVentas; ?>" />
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label" id="proveedor"></label>
                                                    <div class="col-sm-8">
                                                        <div id="SelectProveedores"></div>
                                                        <label id="MsgProveedor"></label>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Actividad Especial</label>
                                                    <div class="col-sm-8">

                                                        <select name="selactividadEspecial" id="selactividadEspecial" class="form-control" required="required">
                                                            <?php if ($modifica == "falso" && $condicionPago['Dias'] > 0) { ?>
                                                                <option value="no">No</option>
                                                                <option value="si">Si</option>
                                                            <?php } else { ?>
                                                                <option value="no">No</option>
                                                            <?php } ?>   
                                                        </select>

                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label" >Observaciones: </label>
                                                    <div class="col-sm-8">   
                                                        <input type="hidden" id="txtNoFocus"/>
                                                        <textarea name="Observaciones" class="col-sm-12" id="txtAreaObservaciones" placeholder="Máximo 50 caracteres"></textarea>
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="tab-pane" id="vtab2">

                                                <div class="row">
                                                    <div class="col-md-2 col-lg-offset-10 text-center">                              
                                                        <img src="images/add_productos.png" style="width: 40px;" class="cursorpointer" id="btnMostrarPortafolio" data-zona="<?php echo $zonaVentas; ?>" data-cliente="<?php echo $datosCliente['CuentaCliente']; ?>"/> 
                                                        <br/>
                                                        <div id="imgCargando">
                                                            <small>Adicionar</small>
                                                        </div>                                                       
                                                    </div>                                                    
                                                </div>

                                                <div class="mb20"></div>

                                                <div class="row">                          
                                                    <div style="width: 100%; overflow-y: scroll;" id="tableDetail">
                                                        <table class="table table-bordered" style="width: 1600px;" id="tableDetail">
                                                            <thead>
                                                                <tr>
                                                                    <th>No.</th>
                                                                    <th>Codigo Variante</th>
                                                                    <th>Descripción</th>                    
                                                                    <th>Saldo</th>                    
                                                                    <th>Valor</th>
                                                                    <th>Cantidad</th>
                                                                    <th>Descuento Promocional</th>
                                                                    <th>Descuento Canal</th>
                                                                    <th>Descuento Especial</th>    
                                                                    <th>Valor</th>    
                                                                    <th>Neto</th>  
                                                                    <th></th>   
                                                                </tr>
                                                            </thead>
                                                            <tbody>


                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="tab-pane" id="vtab3">
                                                <div class="row">
                                                    <input type="hidden" id="txtValorMinimo" value="<?php echo $valorMinimo['ValorMinimo']; ?>" />

                                                    <div class="col-md-8 col-md-offset-2" id="totalesCalculados">
                                                        <div class="form-group">
                                                            <label class="col-sm-6 control-label">Precio Neto</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" placeholder="" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-6 control-label">Descuento Promocional</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" placeholder="" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-6 control-label">Descuento Canal</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" placeholder="" class="form-control">
                                                            </div>
                                                        </div>


                                                        <div class="form-group">
                                                            <label class="col-sm-6 control-label">Valor Total Descuentos</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" placeholder="" class="form-control">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-6 control-label">Base IVA</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" placeholder="" class="form-control">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-6 control-label">IVA</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" placeholder="" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-6 control-label">IMPOCONSUMO</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" placeholder="" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-6 control-label">Total Pedido</label>
                                                            <div class="col-sm-6">
                                                                <input type="hidden" id="txtSaldoCupo" value="<?php echo $condicionPago['SaldoCupo'] ?>"/>  
                                                                <input type="text" placeholder="" class="form-control">
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <ul class="pager wizard">
                                            <li class="previous"><a href="javascript:void(0)">Anterior</a></li>
                                            <li>                                               
                                                <input type="submit" style=" position: absolute; right: 22px; height: 30px; width: 80px; z-index: 1" class="btn btn-primary enviarPedido" value="Enviar"/>

                                            </li>
                                            <li class="next"><a href="javascript:void(0)">Siguiente</a></li>
                                        </ul>
                                    </form>     
                                </div><!-- #validationWizard -->

                            </div><!-- panel-body -->
                        </div><!-- panel -->
                    </div><!-- col-md-6 -->
                </div>
            </div>
        </div>
    </div>      

</div>


<?php
$countsinsaldo = '1';
?>


<!--modales  de los diferentes portafolios-->

<div class="modal fade" id="portafolioPreventa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 680px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">PORTAFOLIO</h4>
            </div>
            <div class="modal-body mdlPortafolio">
                <table class="table table-bordered" id="tblPortafolioPreventa">
                    <thead>
                        <tr>
                            <th class="col-sm-2"></th>
                            <th class="col-sm-8 text-center">Producto</th>
                            <th class="col-sm-2"></th>
                            <th class="col-sm-2"></th>  
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        /* echo '<pre>';
                          print_r($portafolioPreventa);
                          exit(); */
                        $position = array();
                        $newRow = array();
                        $inverse = false;
                        foreach ($portafolioPreventa as $key => $row) {

                            $position[$key] = $row['SPDisponible'];
                            $position[$key] = $row['SaldoDisponibleVenta'];
                            $newRow[$key] = $row;
                            $inverse = true;
                        }

                        if ($inverse) {
                            arsort($position);
                        }

                        $portafolioPre = array();
                        foreach ($position as $key => $pos) {
                            $portafolioPre[] = $newRow[$key];
                        }

                        //echo '<pre>';
                        //print_r($portafolioPre);
                        //die();
                        //exit();*/

                        $cont = 1;
                        foreach ($portafolioPre as $itemPortafolio) {

                            $kitvalidacion = false;
                            if ($itemPortafolio['VarianteInactiva'] == "" && $itemPortafolio['RestriccionProveedor'] == "") {

                                if ($itemPortafolio['ACIdAcuerdoComercial'] != "") {

                                    if ($itemPortafolio['CodigoTipo'] == KV || $itemPortafolio['CodigoTipo'] == KD || $itemPortafolio['CodigoTipo'] == KP) {

                                        $IdListaMateriales = Consultas::model()->getListaMateriales($itemPortafolio['CodigoVariante']);
                                        $ConsultaComponenOB = Consultas::model()->getComponentesOB($IdListaMateriales[0]['CodigoListaMateriales']);

                                        if ($ConsultaComponenOB['componentes'] == 1) {

                                            $ListaMaDatilComp = Consultas::model()->getListaMaterialesDetalle($IdListaMateriales[0]['CodigoListaMateriales']);
                                            if ($ListaMaDatilComp[0]['CodigoTipo'] == 'OB') {
                                                $kitvalidacion = true;
                                            }
                                        }
                                    }

                                    if ($kitvalidacion == false) {

                                        if ($itemPortafolio['ACPrecioVenta'] == "") {
                                            ?>     
                                            <tr class="btnAdicionarSinPrecio cursorpointer active" >  
                                                <td style="width: 15%;" class="text-center icon-table1">                                                                 
                                                    <img class="imagen-producto-<?php echo $itemPortafolio['CodigoVariante']; ?>" src="images/restringido.png" />                       
                                                </td>

                                                <td >
                                                    <b><?php echo $cont; ?>) Código Artículo:</b>
                                                    <?php
                                                    echo $itemPortafolio['CodigoVariante'];
                                                    ?>                     
                                                    <br/>
                                                    <?php
                                                    echo $itemPortafolio['NombreArticulo'] . ' ' . $itemPortafolio['CodigoCaracteristica1'] . ' ' . $itemPortafolio['CodigoCaracteristica2'] . ' (' . $itemPortafolio['CodigoTipo'] . ')';
                                                    ?>
                                                    <br/> 
                                                    <?php
                                                    echo $itemPortafolio['CodigoArticulo']
                                                    ?>
                                                    <br/>
                                                    <b>Valor Sin Impuestos:</b><?php echo number_format(floor($itemPortafolio['ACPrecioVenta'])); ?>
                                                    <br/>
                                                    <b>Valor Con Impuestos:</b><?php
                                                    if ($itemPortafolio['PorcentajedeIVA'] != "") {
                                                        $varIVAConvercion = floor($itemPortafolio['ACPrecioVenta']) * floor($itemPortafolio['PorcentajedeIVA']) / 100;
                                                        echo number_format(floor($itemPortafolio['ACPrecioVenta']) + floor($itemPortafolio['ValorIMPOCONSUMO']) + floor($varIVAConvercion));
                                                    } else {
                                                        echo number_format(floor($itemPortafolio['ACPrecioVenta']) + floor($itemPortafolio['ValorIMPOCONSUMO']));
                                                    };
                                                    ?>
                                                    <br/>
                                                </td>
                                                <td style="width: 10%;" class="text-center">
                                                    <span class="glyphicon glyphicon-plus" style="color: #1CAF9A; font-size: 20px"></span>
                                                    <br/>
                                                    <small>Adicionar</small>                                    
                                                </td>
                                                <td style="width: 10%;" class="text-center">
                                                    <button class="btn btn-primary retornarmenu" type="button" id="btnDescuentos"
                                                            data-CodigoVariante="<?php echo $itemPortafolio['CodigoVariante'] ?>"                               
                                                            data-CodigoArticulo ="<?php echo $itemPortafolio['CodigoArticulo'] ?>"
                                                            data-NombreArticulo ="<?php echo $itemPortafolio['NombreArticulo'] ?>"
                                                            data-CodigoGrupoDescuentoLinea ="<?php echo $itemPortafolio['CodigoGrupoDescuentoLinea'] ?>"
                                                            data-CodigoGrupoDescuentoMultiLinea ="<?php echo $itemPortafolio['CodigoGrupoDescuentoMultiLinea'] ?>">Descuentos</button>
                                                </td>
                                            </tr>
                                            <?php
                                        } else if ($itemPortafolio['SaldoDisponibleVenta'] != "" && $itemPortafolio['CodigoTipo'] == "KV" && $itemPortafolio['kitActivo'] == "1") {
                                            ?>     

                                            <tr class="btnAdicionarKitVirtual cursorpointer"
                                                data-CodigoVariante="<?php echo $itemPortafolio['CodigoVariante'] ?>"                               
                                                data-CodigoArticulo ="<?php echo $itemPortafolio['CodigoArticulo'] ?>"
                                                data-NombreArticulo ="<?php echo $itemPortafolio['NombreArticulo'] ?>"
                                                data-CodigoTipo ="<?php echo $itemPortafolio['CodigoTipo'] ?>"
                                                data-CodigoCaracteristica1 ="<?php echo $itemPortafolio['CodigoCaracteristica1'] ?>"
                                                data-CodigoCaracteristica2 ="<?php echo $itemPortafolio['CodigoCaracteristica2'] ?>"
                                                data-CodigoGrupoVentas ="<?php echo $itemPortafolio['CodigoGrupoVentas'] ?>"
                                                data-IdentificadorProductoNuevo ="<?php echo $itemPortafolio['IdentificadorProductoNuevo'] ?>"
                                                data-ACPrecioVenta ="<?php echo $itemPortafolio['ACPrecioVenta'] ?>"
                                                data-ACIdAcuerdoComercial ="<?php echo $itemPortafolio['ACIdAcuerdoComercial'] ?>"
                                                data-ACCodigoUnidadMedida ="<?php echo $itemPortafolio['ACCodigoUnidadMedida'] ?>"
                                                data-ACNombreUnidadMedida ="<?php echo $itemPortafolio['ACNombreUnidadMedida'] ?>"
                                                data-SPDisponible ="<?php echo $itemPortafolio['SPDisponible'] ?>"                              
                                                data-SPNombreUnidadMedida ="<?php echo $itemPortafolio['SPNombreUnidadMedida'] ?>"
                                                data-SPCodigoUnidadMedida ="<?php echo $itemPortafolio['SPCodigoUnidadMedida'] ?>"
                                                data-SaldoDisponibleVenta ="<?php echo $itemPortafolio['SaldoDisponibleVenta'] ?>"

                                                data-zona-ventas="<?php echo $zonaVentas; ?>"
                                                data-cliente="<?php echo $datosCliente['CuentaCliente']; ?>"

                                                >  
                                                <td style="width: 15%;" class="text-center icon-table1">                                                                  
                                                    <img class="imagen-producto-<?php echo $itemPortafolio['CodigoVariante']; ?>" src="images/pro.png" />                       
                                                </td>

                                                <td >
                                                    <b><?php echo $cont; ?>) Código Artículo:</b>
                                                    <?php
                                                    echo $itemPortafolio['CodigoVariante'];
                                                    ?>                     
                                                    <br/>
                                                    <?php
                                                    echo $itemPortafolio['NombreArticulo'] . ' ' . $itemPortafolio['CodigoCaracteristica1'] . ' ' . $itemPortafolio['CodigoCaracteristica2'] . ' (' . $itemPortafolio['CodigoTipo'] . ')';
                                                    ?>
                                                    <br/> 
                                                    <?php
                                                    echo $itemPortafolio['CodigoArticulo']
                                                    ?>
                                                    <br/>
                                                    <b>Valor Sin Impuestos:</b><?php
                                                    $resultado = PreventaController::actionValorConInpuestoKid($itemPortafolio['CodigoVariante'], $itemPortafolio['PorcentajedeIVA'], $itemPortafolio['CodigoGrupoVentas'], 0);
                                                    echo number_format(floor($resultado));
                                                    ?>
                                                    <br/>
                                                    <b>Valor Con Impuestos:</b><?php
                                                    if ($itemPortafolio['PorcentajedeIVA'] != "") {
                                                        $resultado = PreventaController::actionValorConInpuestoKid($itemPortafolio['CodigoVariante'], $itemPortafolio['PorcentajedeIVA'], $itemPortafolio['CodigoGrupoVentas'], 1);
                                                        echo number_format(floor($resultado));
                                                    } else {
                                                        $resultado = PreventaController::actionValorConInpuestoKid($itemPortafolio['CodigoVariante'], $itemPortafolio['PorcentajedeIVA'], $itemPortafolio['CodigoGrupoVentas'], 1);
                                                        echo number_format(floor($resultado));
                                                    };
                                                    ?><br/>
                                                </td>
                                                <td style="width: 10%;" class="text-center">
                                                    <span class="glyphicon glyphicon-plus" style="color: #1CAF9A; font-size: 20px"></span>
                                                    <br/>
                                                    <small>Adicionar</small>                                    
                                                </td>
                                                <td style="width: 10%;" class="text-center">
                                                    <button class="btn btn-primary retornarmenu" type="button" id="btnDescuentos"
                                                            data-CodigoVariante="<?php echo $itemPortafolio['CodigoVariante'] ?>"                               
                                                            data-CodigoArticulo ="<?php echo $itemPortafolio['CodigoArticulo'] ?>"
                                                            data-NombreArticulo ="<?php echo $itemPortafolio['NombreArticulo'] ?>"
                                                            data-CodigoGrupoDescuentoLinea ="<?php echo $itemPortafolio['CodigoGrupoDescuentoLinea'] ?>"
                                                            data-CodigoGrupoDescuentoMultiLinea ="<?php echo $itemPortafolio['CodigoGrupoDescuentoMultiLinea'] ?>">Descuentos</button>
                                                </td>
                                            </tr>   

                                            <?php
                                        } else if ($itemPortafolio['SaldoDisponibleVenta'] != "" && $itemPortafolio['CodigoTipo'] == "KD" && $itemPortafolio['kitActivo'] == "1") {
                                            ?>

                                            <tr class="btnAdicionarKitDinamico cursorpointer"
                                                data-CodigoVariante="<?php echo $itemPortafolio['CodigoVariante'] ?>"                               
                                                data-CodigoArticulo ="<?php echo $itemPortafolio['CodigoArticulo'] ?>"
                                                data-NombreArticulo ="<?php echo $itemPortafolio['NombreArticulo'] ?>"
                                                data-CodigoTipo ="<?php echo $itemPortafolio['CodigoTipo'] ?>"
                                                data-CodigoCaracteristica1 ="<?php echo $itemPortafolio['CodigoCaracteristica1'] ?>"
                                                data-CodigoCaracteristica2 ="<?php echo $itemPortafolio['CodigoCaracteristica2'] ?>"
                                                data-CodigoGrupoVentas ="<?php echo $itemPortafolio['CodigoGrupoVentas'] ?>"
                                                data-IdentificadorProductoNuevo ="<?php echo $itemPortafolio['IdentificadorProductoNuevo'] ?>"
                                                data-ACPrecioVenta ="<?php echo $itemPortafolio['ACPrecioVenta'] ?>"
                                                data-ACIdAcuerdoComercial ="<?php echo $itemPortafolio['ACIdAcuerdoComercial'] ?>"
                                                data-ACCodigoUnidadMedida ="<?php echo $itemPortafolio['ACCodigoUnidadMedida'] ?>"
                                                data-ACNombreUnidadMedida ="<?php echo $itemPortafolio['ACNombreUnidadMedida'] ?>"
                                                data-SPDisponible ="<?php echo $itemPortafolio['SPDisponible'] ?>"                              
                                                data-SPNombreUnidadMedida ="<?php echo $itemPortafolio['SPNombreUnidadMedida'] ?>"
                                                data-SPCodigoUnidadMedida ="<?php echo $itemPortafolio['SPCodigoUnidadMedida'] ?>"
                                                data-SaldoDisponibleVenta ="<?php echo $itemPortafolio['SaldoDisponibleVenta'] ?>"

                                                data-zona-ventas="<?php echo $zonaVentas; ?>"
                                                data-cliente="<?php echo $datosCliente['CuentaCliente']; ?>"

                                                >  
                                                <td style="width: 15%;" class="text-center icon-table1">                                                                  
                                                    <img class="imagen-producto-<?php echo $itemPortafolio['CodigoVariante']; ?>" src="images/pro.png" />                       
                                                </td>

                                                <td >
                                                    <b><?php echo $cont; ?>) Código Artículo:</b>
                                                    <?php
                                                    echo $itemPortafolio['CodigoVariante'];
                                                    ?>                     
                                                    <br/>
                                                    <?php
                                                    echo $itemPortafolio['NombreArticulo'] . ' ' . $itemPortafolio['CodigoCaracteristica1'] . ' ' . $itemPortafolio['CodigoCaracteristica2'] . ' (' . $itemPortafolio['CodigoTipo'] . ')';
                                                    ?>
                                                    <br/> 
                                                    <?php
                                                    echo $itemPortafolio['CodigoArticulo']
                                                    ?>
                                                    <br/>
                                                    <b>Valor Sin Impuestos:</b><?php
                                                    $resultado = PreventaController::actionValorConInpuestoKid($itemPortafolio['CodigoVariante'], $itemPortafolio['PorcentajedeIVA'], $itemPortafolio['CodigoGrupoVentas'], 0);
                                                    echo number_format(floor($resultado));
                                                    ?>
                                                    <br/>
                                                    <b>Valor Con Impuestos:</b><?php
                                                    if ($itemPortafolio['PorcentajedeIVA'] != "") {
                                                        $resultado = PreventaController::actionValorConInpuestoKid($itemPortafolio['CodigoVariante'], $itemPortafolio['PorcentajedeIVA'], $itemPortafolio['CodigoGrupoVentas'], 1);
                                                        echo number_format(floor($resultado));
                                                    } else {
                                                        $resultado = PreventaController::actionValorConInpuestoKid($itemPortafolio['CodigoVariante'], $itemPortafolio['PorcentajedeIVA'], $itemPortafolio['CodigoGrupoVentas'], 1);
                                                        echo number_format(floor($resultado));
                                                    };
                                                    ?><br/>
                                                </td>
                                                <td style="width: 10%;" class="text-center">
                                                    <span class="glyphicon glyphicon-plus" style="color: #1CAF9A; font-size: 20px"></span>
                                                    <br/>
                                                    <small>Adicionar</small>                                    
                                                </td>
                                                <td style="width: 10%;" class="text-center">
                                                    <button class="btn btn-primary retornarmenu" type="button" id="btnDescuentos"
                                                            data-CodigoVariante="<?php echo $itemPortafolio['CodigoVariante'] ?>"                               
                                                            data-CodigoArticulo ="<?php echo $itemPortafolio['CodigoArticulo'] ?>"
                                                            data-NombreArticulo ="<?php echo $itemPortafolio['NombreArticulo'] ?>"
                                                            data-CodigoGrupoDescuentoLinea ="<?php echo $itemPortafolio['CodigoGrupoDescuentoLinea'] ?>"
                                                            data-CodigoGrupoDescuentoMultiLinea ="<?php echo $itemPortafolio['CodigoGrupoDescuentoMultiLinea'] ?>">Descuentos</button>
                                                </td>
                                            </tr>   
                                            <?php
                                        } else if ($itemPortafolio['ACPrecioVenta'] != "" && $itemPortafolio['SaldoDisponibleVenta'] != "") {
                                            ?>      
                                            <tr class="btnAdicionarProductoDetalleAct cursorpointer"

                                                data-CodigoVariante="<?php echo $itemPortafolio['CodigoVariante'] ?>"                               
                                                data-CodigoArticulo ="<?php echo $itemPortafolio['CodigoArticulo'] ?>"
                                                data-NombreArticulo ="<?php echo $itemPortafolio['NombreArticulo'] ?>"
                                                data-CodigoTipo ="<?php echo $itemPortafolio['CodigoTipo'] ?>"
                                                data-CodigoCaracteristica1 ="<?php echo $itemPortafolio['CodigoCaracteristica1'] ?>"
                                                data-CodigoCaracteristica2 ="<?php echo $itemPortafolio['CodigoCaracteristica2'] ?>"
                                                data-CodigoGrupoVentas ="<?php echo $itemPortafolio['CodigoGrupoVentas'] ?>"
                                                data-IdentificadorProductoNuevo ="<?php echo $itemPortafolio['IdentificadorProductoNuevo'] ?>"
                                                data-ACPrecioVenta ="<?php echo $itemPortafolio['ACPrecioVenta'] ?>"
                                                data-ACIdAcuerdoComercial ="<?php echo $itemPortafolio['ACIdAcuerdoComercial'] ?>"
                                                data-ACCodigoUnidadMedida ="<?php echo $itemPortafolio['ACCodigoUnidadMedida'] ?>"
                                                data-ACNombreUnidadMedida ="<?php echo $itemPortafolio['ACNombreUnidadMedida'] ?>"
                                                data-SPDisponible ="<?php echo $itemPortafolio['SPDisponible'] ?>"                              
                                                data-SPNombreUnidadMedida ="<?php echo $itemPortafolio['SPNombreUnidadMedida'] ?>"
                                                data-SPCodigoUnidadMedida ="<?php echo $itemPortafolio['SPCodigoUnidadMedida'] ?>"
                                                data-SaldoDisponibleVenta ="<?php echo $itemPortafolio['SaldoDisponibleVenta'] ?>"

                                                data-zona-ventas="<?php echo $zonaVentas; ?>"
                                                data-cliente="<?php echo $datosCliente['CuentaCliente']; ?>"

                                                > 

                                                <td style="width: 15%;" class="text-center datos-item">                                                                  
                                                    <img class="imagen-producto-<?php echo $itemPortafolio['CodigoVariante']; ?>" src="images/pro.png" />                       
                                                </td>

                                                <td >
                                                    <b><?php echo $cont; ?>) Código Artículo:</b>
                                                    <?php
                                                    echo $itemPortafolio['CodigoVariante'];
                                                    ?>                     
                                                    <br/>
                                                    <?php
                                                    echo $itemPortafolio['NombreArticulo'] . ' ' . $itemPortafolio['CodigoCaracteristica1'] . ' ' . $itemPortafolio['CodigoCaracteristica2'] . ' (' . $itemPortafolio['CodigoTipo'] . ')';
                                                    ?>
                                                    <br/> 
                                                    <?php
                                                    echo $itemPortafolio['CodigoArticulo']
                                                    ?>
                                                    <br/>
                                                    <b>Valor Sin Impuestos:</b><?php echo number_format(floor($itemPortafolio['ACPrecioVenta'])); ?>
                                                    <br/>
                                                    <b>Valor Con Impuestos:</b><?php
                                                    if ($itemPortafolio['PorcentajedeIVA'] != "") {
                                                        $varIVAConvercion = floor($itemPortafolio['ACPrecioVenta']) * floor($itemPortafolio['PorcentajedeIVA']) / 100;
                                                        echo number_format(floor($itemPortafolio['ACPrecioVenta']) + floor($itemPortafolio['ValorIMPOCONSUMO']) + floor($varIVAConvercion));
                                                    } else {
                                                        echo number_format(floor($itemPortafolio['ACPrecioVenta']) + floor($itemPortafolio['ValorIMPOCONSUMO']));
                                                    };
                                                    ?><br/>
                                                </td>
                                                <td style="width: 10%;" class="text-center">
                                                    <span class="glyphicon glyphicon-plus" style="color: #1CAF9A; font-size: 20px"></span>
                                                    <br/>
                                                    <small>Adicionar</small>                                    
                                                </td>
                                                <td style="width: 10%;" class="text-center">
                                                    <button class="btn btn-primary retornarmenu" type="button" id="btnDescuentos"
                                                            data-CodigoVariante="<?php echo $itemPortafolio['CodigoVariante'] ?>"                               
                                                            data-CodigoArticulo ="<?php echo $itemPortafolio['CodigoArticulo'] ?>"
                                                            data-NombreArticulo ="<?php echo $itemPortafolio['NombreArticulo'] ?>"
                                                            data-CodigoGrupoDescuentoLinea ="<?php echo $itemPortafolio['CodigoGrupoDescuentoLinea'] ?>"
                                                            data-CodigoGrupoDescuentoMultiLinea ="<?php echo $itemPortafolio['CodigoGrupoDescuentoMultiLinea'] ?>">Descuentos</button>
                                                </td>
                                            </tr>

                                            <?php
                                        } else if ($itemPortafolio['ACPrecioVenta'] == "" && $itemPortafolio['SaldoDisponibleVenta'] == "") {
                                            ?>  

                                            <tr class="btnAdicionarSinPrecio cursorpointer active">  
                                                <td style="width: 15%;" class="text-center icon-table1">

                                                    <img class="imagen-producto-<?php echo $itemPortafolio['CodigoVariante']; ?>" src="images/restringido.png" />                       
                                                </td>

                                                <td >
                                                    <b><?php echo $cont; ?>) Código Artículo:</b>
                                                    <?php
                                                    echo $itemPortafolio['CodigoVariante'];
                                                    ?>                     
                                                    <br/>
                                                    <?php
                                                    echo $itemPortafolio['NombreArticulo'] . ' ' . $itemPortafolio['CodigoCaracteristica1'] . ' ' . $itemPortafolio['CodigoCaracteristica2'] . ' (' . $itemPortafolio['CodigoTipo'] . ')';
                                                    ?>
                                                    <br/> 
                                                    <?php
                                                    echo $itemPortafolio['CodigoArticulo']
                                                    ?>
                                                    <br/>
                                                    <b>Valor Sin Impuestos:</b><?php echo number_format(floor($itemPortafolio['ACPrecioVenta'])); ?>
                                                    <br/>
                                                    <b>Valor Con Impuestos:</b><?php
                                                    if ($itemPortafolio['PorcentajedeIVA'] != "") {
                                                        $varIVAConvercion = floor($itemPortafolio['ACPrecioVenta']) * floor($itemPortafolio['PorcentajedeIVA']) / 100;
                                                        echo number_format(floor($itemPortafolio['ACPrecioVenta']) + floor($itemPortafolio['ValorIMPOCONSUMO']) + floor($varIVAConvercion));
                                                    } else {
                                                        echo number_format(floor($itemPortafolio['ACPrecioVenta']) + floor($itemPortafolio['ValorIMPOCONSUMO']));
                                                    };
                                                    ?><br/>
                                                </td>
                                                <td style="width: 10%;" class="text-center">
                                                    <span class="glyphicon glyphicon-plus" style="color: #1CAF9A; font-size: 20px"></span>
                                                    <br/>
                                                    <small>Adicionar</small>                                    
                                                </td>
                                                <td style="width: 10%;" class="text-center">
                                                    <button class="btn btn-primary retornarmenu" type="button" id="btnDescuentos"
                                                            data-CodigoVariante="<?php echo $itemPortafolio['CodigoVariante'] ?>"                               
                                                            data-CodigoArticulo ="<?php echo $itemPortafolio['CodigoArticulo'] ?>"
                                                            data-NombreArticulo ="<?php echo $itemPortafolio['NombreArticulo'] ?>"
                                                            data-CodigoGrupoDescuentoLinea ="<?php echo $itemPortafolio['CodigoGrupoDescuentoLinea'] ?>"
                                                            data-CodigoGrupoDescuentoMultiLinea ="<?php echo $itemPortafolio['CodigoGrupoDescuentoMultiLinea'] ?>">Descuentos</button>
                                                </td>
                                            </tr>

                                            <?php
                                        } else if ($itemPortafolio['SaldoDisponibleVenta'] == "" || $itemPortafolio['SPDisponible'] == 0 || $itemPortafolio['SPDisponible'] == "") {
                                            ?>     
                                            <tr class="btnAdicionarSinSaldo cursorpointer warning"
                                                data-icon="<?php echo '1'; ?>"
                                                data-CodigoVariante="<?php echo $itemPortafolio['CodigoVariante'] ?>"                               
                                                data-CodigoArticulo ="<?php echo $itemPortafolio['CodigoArticulo'] ?>"
                                                data-NombreArticulo ="<?php echo $itemPortafolio['NombreArticulo'] ?>"
                                                data-CodigoTipo ="<?php echo $itemPortafolio['CodigoTipo'] ?>"
                                                data-CodigoCaracteristica1 ="<?php echo $itemPortafolio['CodigoCaracteristica1'] ?>"
                                                data-CodigoCaracteristica2 ="<?php echo $itemPortafolio['CodigoCaracteristica2'] ?>"
                                                data-CodigoGrupoVentas ="<?php echo $itemPortafolio['CodigoGrupoVentas'] ?>"
                                                data-IdentificadorProductoNuevo ="<?php echo $itemPortafolio['IdentificadorProductoNuevo'] ?>"
                                                data-ACPrecioVenta ="<?php echo $itemPortafolio['ACPrecioVenta'] ?>"
                                                data-ACIdAcuerdoComercial ="<?php echo $itemPortafolio['ACIdAcuerdoComercial'] ?>"
                                                data-ACCodigoUnidadMedida ="<?php echo $itemPortafolio['ACCodigoUnidadMedida'] ?>"
                                                data-ACNombreUnidadMedida ="<?php echo $itemPortafolio['ACNombreUnidadMedida'] ?>"
                                                data-SPDisponible ="<?php echo $itemPortafolio['SPDisponible'] ?>"                              
                                                data-SPNombreUnidadMedida ="<?php echo $itemPortafolio['SPNombreUnidadMedida'] ?>"
                                                data-SPCodigoUnidadMedida ="<?php echo $itemPortafolio['SPCodigoUnidadMedida'] ?>"
                                                data-SaldoDisponibleVenta ="<?php echo $itemPortafolio['SaldoDisponibleVenta'] ?>"

                                                data-zona-ventas="<?php echo $zonaVentas; ?>"
                                                data-cliente="<?php echo $datosCliente['CuentaCliente']; ?>"


                                                >  
                                                <td style="width: 15%;" class="text-center icon-table1">                                                                  
                                                    <img class="imagen-producto-<?php echo $itemPortafolio['CodigoVariante']; ?>,<?php echo $countsinsaldo ?>" src="images/sinsaldo.png"/>                       
                                                </td>

                                                <td >
                                                    <b><?php echo $cont; ?>) Código Artículo:</b>
                                                    <?php
                                                    echo $itemPortafolio['CodigoVariante'];
                                                    ?>                     
                                                    <br/>
                                                    <?php
                                                    echo $itemPortafolio['NombreArticulo'] . ' ' . $itemPortafolio['CodigoCaracteristica1'] . ' ' . $itemPortafolio['CodigoCaracteristica2'] . ' (' . $itemPortafolio['CodigoTipo'] . ')';
                                                    ?>
                                                    <br/>
                                                    <?php
                                                    echo $itemPortafolio['CodigoArticulo']
                                                    ?>
                                                    <br/>
                                                    <b>Valor Sin Impuestos:</b><?php echo number_format(floor($itemPortafolio['ACPrecioVenta'])); ?>
                                                    <br/>
                                                    <b>Valor Con Impuestos:</b><?php
                                                    if ($itemPortafolio['PorcentajedeIVA'] != "") {
                                                        $varIVAConvercion = floor($itemPortafolio['ACPrecioVenta']) * floor($itemPortafolio['PorcentajedeIVA']) / 100;
                                                        echo number_format(floor($itemPortafolio['ACPrecioVenta']) + floor($itemPortafolio['ValorIMPOCONSUMO']) + floor($varIVAConvercion));
                                                    } else {
                                                        echo number_format(floor($itemPortafolio['ACPrecioVenta']) + floor($itemPortafolio['ValorIMPOCONSUMO']));
                                                    };
                                                    ?><br/>
                                                </td>
                                                <td style="width: 10%;" class="text-center">
                                                    <span class="glyphicon glyphicon-plus" style="color: #1CAF9A; font-size: 20px"></span>
                                                    <br/>
                                                    <small>Adicionar</small>                                    
                                                </td>
                                                <td style="width: 10%;" class="text-center">
                                                    <button class="btn btn-primary retornarmenu" type="button" id="btnDescuentos"
                                                            data-CodigoVariante="<?php echo $itemPortafolio['CodigoVariante'] ?>"                               
                                                            data-CodigoArticulo ="<?php echo $itemPortafolio['CodigoArticulo'] ?>"
                                                            data-NombreArticulo ="<?php echo $itemPortafolio['NombreArticulo'] ?>"
                                                            data-CodigoGrupoDescuentoLinea ="<?php echo $itemPortafolio['CodigoGrupoDescuentoLinea'] ?>"
                                                            data-CodigoGrupoDescuentoMultiLinea ="<?php echo $itemPortafolio['CodigoGrupoDescuentoMultiLinea'] ?>">Descuentos</button>
                                                </td>
                                            </tr>


                                            <?php
                                        }
                                        ?>    

                                        <?php
                                        $cont++;
                                    }
                                }
                            }
                        }
                        ?>
                    </tbody>
                </table>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>       
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="portafolioVentaDirecta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 680px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">PORTAFOLIO</h4>
            </div>
            <div class="modal-body mdlPortafolio" id = "portafolioDirecta">


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>       
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="portafolioConsignacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 680px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">PORTAFOLIO</h4>
            </div>
            <div class="modal-body mdlPortafolio">



                <table class="table table-bordered" id="tblPortafolioConsignacion">
                    <thead>
                        <tr>
                            <th class="col-sm-2"></th>
                            <th class="col-sm-8 text-center">Producto</th>
                            <th class="col-sm-2"></th>
                            <th class="col-sm-2"></th>  
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $position = array();
                        $newRow = array();
                        $inverse = false;
                        foreach ($portafolioPreventa as $key => $row) {

                            $position[$key] = $row['SPDisponible'];
                            $position[$key] = $row['SaldoDisponibleVenta'];
                            $newRow[$key] = $row;
                            $inverse = true;
                        }

                        if ($inverse) {
                            arsort($position);
                        }

                        $portafolioPre = array();
                        foreach ($position as $key => $pos) {
                            $portafolioPre[] = $newRow[$key];
                        }


                        $cont = 1;
                        foreach ($portafolioPre as $itemPortafolio) {

                            $kitvalidacion = false;
                            if ($itemPortafolio['ACIdAcuerdoComercial'] != "") {

                                if ($itemPortafolio['CodigoTipo'] == KV || $itemPortafolio['CodigoTipo'] == KD || $itemPortafolio['CodigoTipo'] == KP) {

                                    $IdListaMateriales = Consultas::model()->getListaMateriales($itemPortafolio['CodigoArticulo']);
                                    $ConsultaComponenOB = Consultas::model()->getComponentesOB($IdListaMateriales[0]['CodigoListaMateriales']);

                                    if ($ConsultaComponenOB['componentes'] == 1) {

                                        $ListaMaDatilComp = Consultas::model()->getListaMaterialesDetalle($IdListaMateriales[0]['CodigoListaMateriales']);
                                        if ($ListaMaDatilComp[0]['CodigoTipo'] == 'OB') {
                                            $kitvalidacion = true;
                                        }
                                    }
                                }
                                if ($kitvalidacion == false) {

                                    if ($itemPortafolio['ACPrecioVenta'] == "") {
                                        ?>     
                                        <tr class="btnAdicionarSinPrecio cursorpointer active">  
                                            <td style="width: 15%;" class="text-center icon-table1">                                                                 
                                                <img class="imagen-producto-<?php echo $itemPortafolio['CodigoVariante']; ?>" src="images/restringido.png" />                       
                                            </td>

                                            <td >
                                                <b><?php echo $cont; ?>) Código Artículo:</b>
                                                <?php
                                                echo $itemPortafolio['CodigoVariante'];
                                                ?>                     
                                                <br/>
                                                <?php
                                                echo $itemPortafolio['NombreArticulo'] . ' ' . $itemPortafolio['CodigoCaracteristica1'] . ' ' . $itemPortafolio['CodigoCaracteristica2'] . ' (' . $itemPortafolio['CodigoTipo'] . ')';
                                                ?>
                                                <br/>
                                                <?php
                                                echo $itemPortafolio['CodigoArticulo']
                                                ?>
                                                <br/>
                                                <b>Valor Sin Impuestos:</b><?php echo number_format(floor($itemPortafolio['ACPrecioVenta'])); ?>
                                                <br/>
                                                <b>Valor Con Impuestos:</b><?php
                                                if ($itemPortafolio['PorcentajedeIVA'] != "") {
                                                    $varIVAConvercion = floor($itemPortafolio['ACPrecioVenta']) * floor($itemPortafolio['PorcentajedeIVA']) / 100;
                                                    echo number_format(floor($itemPortafolio['ACPrecioVenta']) + floor($itemPortafolio['ValorIMPOCONSUMO']) + floor($varIVAConvercion));
                                                } else {
                                                    echo number_format(floor($itemPortafolio['ACPrecioVenta']) + floor($itemPortafolio['ValorIMPOCONSUMO']));
                                                };
                                                ?><br/>
                                            </td>
                                            <td style="width: 10%;" class="text-center">
                                                <span class="glyphicon glyphicon-plus" style="color: #1CAF9A; font-size: 20px"></span>
                                                <br/>
                                                <small>Adicionar</small>                                    
                                            </td>
                                            <td style="width: 10%;" class="text-center">
                                                <button class="btn btn-primary retornarmenu" type="button" id="btnDescuentos"
                                                        data-CodigoVariante="<?php echo $itemPortafolio['CodigoVariante'] ?>"                               
                                                        data-CodigoArticulo ="<?php echo $itemPortafolio['CodigoArticulo'] ?>"
                                                        data-NombreArticulo ="<?php echo $itemPortafolio['NombreArticulo'] ?>"
                                                        data-CodigoGrupoDescuentoLinea ="<?php echo $itemPortafolio['CodigoGrupoDescuentoLinea'] ?>"
                                                        data-CodigoGrupoDescuentoMultiLinea ="<?php echo $itemPortafolio['CodigoGrupoDescuentoMultiLinea'] ?>">Descuentos</button>
                                            </td>
                                        </tr>
                                        <?php
                                    } else if ($itemPortafolio['SaldoDisponibleVentaAutoventa'] != "" && $itemPortafolio['CodigoTipo'] == "KV" && $itemPortafolio['kitActivo'] == "1") {
                                        ?>     

                                        <tr class="btnAdicionarKitVirtual cursorpointer"
                                            data-CodigoVariante="<?php echo $itemPortafolio['CodigoVariante'] ?>"                               
                                            data-CodigoArticulo ="<?php echo $itemPortafolio['CodigoArticulo'] ?>"
                                            data-NombreArticulo ="<?php echo $itemPortafolio['NombreArticulo'] ?>"
                                            data-CodigoTipo ="<?php echo $itemPortafolio['CodigoTipo'] ?>"
                                            data-CodigoCaracteristica1 ="<?php echo $itemPortafolio['CodigoCaracteristica1'] ?>"
                                            data-CodigoCaracteristica2 ="<?php echo $itemPortafolio['CodigoCaracteristica2'] ?>"
                                            data-CodigoGrupoVentas ="<?php echo $itemPortafolio['CodigoGrupoVentas'] ?>"
                                            data-IdentificadorProductoNuevo ="<?php echo $itemPortafolio['IdentificadorProductoNuevo'] ?>"
                                            data-ACPrecioVenta ="<?php echo $itemPortafolio['ACPrecioVenta'] ?>"
                                            data-ACIdAcuerdoComercial ="<?php echo $itemPortafolio['ACIdAcuerdoComercial'] ?>"
                                            data-ACCodigoUnidadMedida ="<?php echo $itemPortafolio['ACCodigoUnidadMedida'] ?>"
                                            data-ACNombreUnidadMedida ="<?php echo $itemPortafolio['ACNombreUnidadMedida'] ?>"
                                            data-SPDisponible ="<?php echo $itemPortafolio['SADisponible'] ?>"                              
                                            data-SPNombreUnidadMedida ="<?php echo $itemPortafolio['SANombreUnidadMedida'] ?>"
                                            data-SPCodigoUnidadMedida ="<?php echo $itemPortafolio['SACodigoUnidadMedida'] ?>"
                                            data-SaldoDisponibleVenta ="<?php echo $itemPortafolio['SaldoDisponibleVentaAutoventa'] ?>"

                                            data-zona-ventas="<?php echo $zonaVentas; ?>"
                                            data-cliente="<?php echo $datosCliente['CuentaCliente']; ?>"

                                            >  
                                            <td style="width: 15%;" class="text-center icon-table1">                                                                  
                                                <img class="imagen-producto-<?php echo $itemPortafolio['CodigoVariante']; ?>" src="images/pro.png" />                       
                                            </td>

                                            <td >
                                                <b><?php echo $cont; ?>) Código Artículo:</b>
                                                <?php
                                                echo $itemPortafolio['CodigoVariante'];
                                                ?>                     
                                                <br/>
                                                <?php
                                                echo $itemPortafolio['NombreArticulo'] . ' ' . $itemPortafolio['CodigoCaracteristica1'] . ' ' . $itemPortafolio['CodigoCaracteristica2'] . ' (' . $itemPortafolio['CodigoTipo'] . ')';
                                                ?>
                                                <br/>
                                                <?php
                                                echo $itemPortafolio['CodigoArticulo']
                                                ?>
                                                <br/>
                                                <b>Valor Sin Impuestos:</b><?php
                                                $resultado = PreventaController::actionValorConInpuestoKid($itemPortafolio['CodigoVariante'], $itemPortafolio['PorcentajedeIVA'], $itemPortafolio['CodigoGrupoVentas'], 0);
                                                echo number_format(floor($resultado));
                                                ?>
                                                <br/>
                                                <b>Valor Con Impuestos:</b><?php
                                                if ($itemPortafolio['PorcentajedeIVA'] != "") {
                                                    $resultado = PreventaController::actionValorConInpuestoKid($itemPortafolio['CodigoVariante'], $itemPortafolio['PorcentajedeIVA'], $itemPortafolio['CodigoGrupoVentas'], 1);
                                                    echo number_format(floor($resultado));
                                                } else {
                                                    $resultado = PreventaController::actionValorConInpuestoKid($itemPortafolio['CodigoVariante'], $itemPortafolio['PorcentajedeIVA'], $itemPortafolio['CodigoGrupoVentas'], 1);
                                                    echo number_format(floor($resultado));
                                                };
                                                ?><br/>
                                            </td>
                                            <td style="width: 10%;" class="text-center">
                                                <span class="glyphicon glyphicon-plus" style="color: #1CAF9A; font-size: 20px"></span>
                                                <br/>
                                                <small>Adicionar</small>                                    
                                            </td>
                                            <td style="width: 10%;" class="text-center">
                                                <button class="btn btn-primary retornarmenu" type="button" id="btnDescuentos"
                                                        data-CodigoVariante="<?php echo $itemPortafolio['CodigoVariante'] ?>"                               
                                                        data-CodigoArticulo ="<?php echo $itemPortafolio['CodigoArticulo'] ?>"
                                                        data-NombreArticulo ="<?php echo $itemPortafolio['NombreArticulo'] ?>"
                                                        data-CodigoGrupoDescuentoLinea ="<?php echo $itemPortafolio['CodigoGrupoDescuentoLinea'] ?>"
                                                        data-CodigoGrupoDescuentoMultiLinea ="<?php echo $itemPortafolio['CodigoGrupoDescuentoMultiLinea'] ?>">Descuentos</button>
                                            </td>
                                        </tr>   

                                        <?php
                                    } else if ($itemPortafolio['SaldoDisponibleVentaAutoventa'] != "" && $itemPortafolio['CodigoTipo'] == "KD" && $itemPortafolio['kitActivo'] == "1") {
                                        ?>

                                        <tr class="btnAdicionarKitDinamico cursorpointer"
                                            data-CodigoVariante="<?php echo $itemPortafolio['CodigoVariante'] ?>"                               
                                            data-CodigoArticulo ="<?php echo $itemPortafolio['CodigoArticulo'] ?>"
                                            data-NombreArticulo ="<?php echo $itemPortafolio['NombreArticulo'] ?>"
                                            data-CodigoTipo ="<?php echo $itemPortafolio['CodigoTipo'] ?>"
                                            data-CodigoCaracteristica1 ="<?php echo $itemPortafolio['CodigoCaracteristica1'] ?>"
                                            data-CodigoCaracteristica2 ="<?php echo $itemPortafolio['CodigoCaracteristica2'] ?>"
                                            data-CodigoGrupoVentas ="<?php echo $itemPortafolio['CodigoGrupoVentas'] ?>"
                                            data-IdentificadorProductoNuevo ="<?php echo $itemPortafolio['IdentificadorProductoNuevo'] ?>"
                                            data-ACPrecioVenta ="<?php echo $itemPortafolio['ACPrecioVenta'] ?>"
                                            data-ACIdAcuerdoComercial ="<?php echo $itemPortafolio['ACIdAcuerdoComercial'] ?>"
                                            data-ACCodigoUnidadMedida ="<?php echo $itemPortafolio['ACCodigoUnidadMedida'] ?>"
                                            data-ACNombreUnidadMedida ="<?php echo $itemPortafolio['ACNombreUnidadMedida'] ?>"
                                            data-SPDisponible ="<?php echo $itemPortafolio['SADisponible'] ?>"                              
                                            data-SPNombreUnidadMedida ="<?php echo $itemPortafolio['SANombreUnidadMedida'] ?>"
                                            data-SPCodigoUnidadMedida ="<?php echo $itemPortafolio['SACodigoUnidadMedida'] ?>"
                                            data-SaldoDisponibleVenta ="<?php echo $itemPortafolio['SaldoDisponibleVentaAutoventa'] ?>"

                                            data-zona-ventas="<?php echo $zonaVentas; ?>"
                                            data-cliente="<?php echo $datosCliente['CuentaCliente']; ?>"

                                            >  
                                            <td style="width: 15%;" class="text-center icon-table1">                                                                  
                                                <img class="imagen-producto-<?php echo $itemPortafolio['CodigoVariante']; ?>" src="images/pro.png" />                       
                                            </td>

                                            <td >
                                                <b><?php echo $cont; ?>) Código Artículo:</b>
                                                <?php
                                                echo $itemPortafolio['CodigoVariante'];
                                                ?>                     
                                                <br/>
                                                <?php
                                                echo $itemPortafolio['NombreArticulo'] . ' ' . $itemPortafolio['CodigoCaracteristica1'] . ' ' . $itemPortafolio['CodigoCaracteristica2'] . ' (' . $itemPortafolio['CodigoTipo'] . ')';
                                                ?>
                                                <br/>
                                                <?php
                                                echo $itemPortafolio['CodigoArticulo']
                                                ?>
                                                <br/>
                                                <b>Valor Sin Impuestos:</b><?php
                                                $resultado = PreventaController::actionValorConInpuestoKid($itemPortafolio['CodigoVariante'], $itemPortafolio['PorcentajedeIVA'], $itemPortafolio['CodigoGrupoVentas'], 0);
                                                echo number_format(floor($resultado));
                                                ?>
                                                <br/>
                                                <b>Valor Con Impuestos:</b><?php
                                                if ($itemPortafolio['PorcentajedeIVA'] != "") {
                                                    $resultado = PreventaController::actionValorConInpuestoKid($itemPortafolio['CodigoVariante'], $itemPortafolio['PorcentajedeIVA'], $itemPortafolio['CodigoGrupoVentas'], 1);
                                                    echo number_format(floor($resultado));
                                                } else {
                                                    $resultado = PreventaController::actionValorConInpuestoKid($itemPortafolio['CodigoVariante'], $itemPortafolio['PorcentajedeIVA'], $itemPortafolio['CodigoGrupoVentas'], 1);
                                                    echo number_format(floor($resultado));
                                                };
                                                ?><br/>
                                            </td>
                                            <td style="width: 10%;" class="text-center">
                                                <span class="glyphicon glyphicon-plus" style="color: #1CAF9A; font-size: 20px"></span>
                                                <br/>
                                                <small>Adicionar</small>                                    
                                            </td>
                                            <td style="width: 10%;" class="text-center">
                                                <button class="btn btn-primary retornarmenu" type="button" id="btnDescuentos"
                                                        data-CodigoVariante="<?php echo $itemPortafolio['CodigoVariante'] ?>"                               
                                                        data-CodigoArticulo ="<?php echo $itemPortafolio['CodigoArticulo'] ?>"
                                                        data-NombreArticulo ="<?php echo $itemPortafolio['NombreArticulo'] ?>"
                                                        data-CodigoGrupoDescuentoLinea ="<?php echo $itemPortafolio['CodigoGrupoDescuentoLinea'] ?>"
                                                        data-CodigoGrupoDescuentoMultiLinea ="<?php echo $itemPortafolio['CodigoGrupoDescuentoMultiLinea'] ?>">Descuentos</button>
                                            </td>
                                        </tr>   
                                        <?php
                                    } else if ($itemPortafolio['SaldoDisponibleVentaAutoventa'] == "") {
                                        ?>      
                                        <tr class="btnAdicionarSinSaldo cursorpointer warning"
                                            data-CodigoVariante="<?php echo $itemPortafolio['CodigoVariante'] ?>"                               
                                            data-CodigoArticulo ="<?php echo $itemPortafolio['CodigoArticulo'] ?>"
                                            data-NombreArticulo ="<?php echo $itemPortafolio['NombreArticulo'] ?>"
                                            data-CodigoTipo ="<?php echo $itemPortafolio['CodigoTipo'] ?>"
                                            data-CodigoCaracteristica1 ="<?php echo $itemPortafolio['CodigoCaracteristica1'] ?>"
                                            data-CodigoCaracteristica2 ="<?php echo $itemPortafolio['CodigoCaracteristica2'] ?>"
                                            data-CodigoGrupoVentas ="<?php echo $itemPortafolio['CodigoGrupoVentas'] ?>"
                                            data-IdentificadorProductoNuevo ="<?php echo $itemPortafolio['IdentificadorProductoNuevo'] ?>"
                                            data-ACPrecioVenta ="<?php echo $itemPortafolio['ACPrecioVenta'] ?>"
                                            data-ACIdAcuerdoComercial ="<?php echo $itemPortafolio['ACIdAcuerdoComercial'] ?>"
                                            data-ACCodigoUnidadMedida ="<?php echo $itemPortafolio['ACCodigoUnidadMedida'] ?>"
                                            data-ACNombreUnidadMedida ="<?php echo $itemPortafolio['ACNombreUnidadMedida'] ?>"
                                            data-SPDisponible ="<?php echo $itemPortafolio['SADisponible'] ?>"                              
                                            data-SPNombreUnidadMedida ="<?php echo $itemPortafolio['SANombreUnidadMedida'] ?>"
                                            data-SPCodigoUnidadMedida ="<?php echo $itemPortafolio['SACodigoUnidadMedida'] ?>"
                                            data-SaldoDisponibleVenta ="<?php echo $itemPortafolio['SaldoDisponibleVentaAutoventa'] ?>"

                                            data-zona-ventas="<?php echo $zonaVentas; ?>"
                                            data-cliente="<?php echo $datosCliente['CuentaCliente']; ?>"                              
                                            >  
                                            <td style="width: 15%;" class="text-center icon-table1">                                                                  
                                                <img class="imagen-producto-<?php echo $itemPortafolio['CodigoVariante']; ?>" src="images/sinsaldo.png" />                       
                                            </td>

                                            <td >
                                                <b><?php echo $cont; ?>) Código Artículo:</b>
                                                <?php
                                                echo $itemPortafolio['CodigoVariante'];
                                                ?>                     
                                                <br/>
                                                <?php
                                                echo $itemPortafolio['NombreArticulo'] . ' ' . $itemPortafolio['CodigoCaracteristica1'] . ' ' . $itemPortafolio['CodigoCaracteristica2'] . ' (' . $itemPortafolio['CodigoTipo'] . ')';
                                                ?>
                                                <br/>
                                                <?php
                                                echo $itemPortafolio['CodigoArticulo']
                                                ?>
                                                <br/>
                                                <b>Valor Sin Impuestos:</b><?php echo number_format(floor($itemPortafolio['ACPrecioVenta'])); ?>
                                                <br/>
                                                <b>Valor Con Impuestos:</b><?php
                                                if ($itemPortafolio['PorcentajedeIVA'] != "") {
                                                    $varIVAConvercion = floor($itemPortafolio['ACPrecioVenta']) * floor($itemPortafolio['PorcentajedeIVA']) / 100;
                                                    echo number_format(floor($itemPortafolio['ACPrecioVenta']) + floor($itemPortafolio['ValorIMPOCONSUMO']) + floor($varIVAConvercion));
                                                } else {
                                                    echo number_format(floor($itemPortafolio['ACPrecioVenta']) + floor($itemPortafolio['ValorIMPOCONSUMO']));
                                                };
                                                ?><br/>
                                            </td>
                                            <td style="width: 10%;" class="text-center">
                                                <span class="glyphicon glyphicon-plus" style="color: #1CAF9A; font-size: 20px"></span>
                                                <br/>
                                                <small>Adicionar</small>                                    
                                            </td>
                                            <td style="width: 10%;" class="text-center">
                                                <button class="btn btn-primary retornarmenu" type="button" id="btnDescuentos"
                                                        data-CodigoVariante="<?php echo $itemPortafolio['CodigoVariante'] ?>"                               
                                                        data-CodigoArticulo ="<?php echo $itemPortafolio['CodigoArticulo'] ?>"
                                                        data-NombreArticulo ="<?php echo $itemPortafolio['NombreArticulo'] ?>"
                                                        data-CodigoGrupoDescuentoLinea ="<?php echo $itemPortafolio['CodigoGrupoDescuentoLinea'] ?>"
                                                        data-CodigoGrupoDescuentoMultiLinea ="<?php echo $itemPortafolio['CodigoGrupoDescuentoMultiLinea'] ?>">Descuentos</button>
                                            </td>
                                        </tr>

                                        <?php
                                    } else if ($itemPortafolio['ACPrecioVenta'] == "" && $itemPortafolio['SaldoDisponibleVentaAutoventa'] == "") {
                                        ?>  

                                        <tr class="btnAdicionarSinPrecio cursorpointer active">  
                                            <td style="width: 15%;" class="text-center icon-table1">

                                                <img class="imagen-producto-<?php echo $itemPortafolio['CodigoVariante']; ?>" src="images/restringido.png" />                       
                                            </td>

                                            <td >
                                                <b><?php echo $cont; ?>) Código Artículo:</b>
                                                <?php
                                                echo $itemPortafolio['CodigoVariante'];
                                                ?>                     
                                                <br/>
                                                <?php
                                                echo $itemPortafolio['NombreArticulo'] . ' ' . $itemPortafolio['CodigoCaracteristica1'] . ' ' . $itemPortafolio['CodigoCaracteristica2'] . ' (' . $itemPortafolio['CodigoTipo'] . ')';
                                                ?>
                                                <br/>
                                                <?php
                                                echo $itemPortafolio['CodigoArticulo']
                                                ?>
                                                <br/>
                                                <b>Valor Sin Impuestos:</b><?php echo number_format(floor($itemPortafolio['ACPrecioVenta'])); ?>
                                                <br/>
                                                <b>Valor Con Impuestos:</b><?php
                                                if ($itemPortafolio['PorcentajedeIVA'] != "") {
                                                    $varIVAConvercion = floor($itemPortafolio['ACPrecioVenta']) * floor($itemPortafolio['PorcentajedeIVA']) / 100;
                                                    echo number_format(floor($itemPortafolio['ACPrecioVenta']) + floor($itemPortafolio['ValorIMPOCONSUMO']) + floor($varIVAConvercion));
                                                } else {
                                                    echo number_format(floor($itemPortafolio['ACPrecioVenta']) + floor($itemPortafolio['ValorIMPOCONSUMO']));
                                                };
                                                ?><br/>
                                            </td>
                                            <td style="width: 10%;" class="text-center">
                                                <span class="glyphicon glyphicon-plus" style="color: #1CAF9A; font-size: 20px"></span>
                                                <br/>
                                                <small>Adicionar</small>                                    
                                            </td>
                                            <td style="width: 10%;" class="text-center">
                                                <button class="btn btn-primary retornarmenu" type="button" id="btnDescuentos"
                                                        data-CodigoVariante="<?php echo $itemPortafolio['CodigoVariante'] ?>"                               
                                                        data-CodigoArticulo ="<?php echo $itemPortafolio['CodigoArticulo'] ?>"
                                                        data-NombreArticulo ="<?php echo $itemPortafolio['NombreArticulo'] ?>"
                                                        data-CodigoGrupoDescuentoLinea ="<?php echo $itemPortafolio['CodigoGrupoDescuentoLinea'] ?>"
                                                        data-CodigoGrupoDescuentoMultiLinea ="<?php echo $itemPortafolio['CodigoGrupoDescuentoMultiLinea'] ?>">Descuentos</button>
                                            </td>
                                        </tr>

                                        <?php
                                    } else if ($itemPortafolio['ACPrecioVenta'] != "" && $itemPortafolio['SaldoDisponibleVentaAutoventa'] != "") {
                                        ?>     

                                        <tr class="btnAdicionarProductoDetalleAct cursorpointer"

                                            data-CodigoVariante="<?php echo $itemPortafolio['CodigoVariante'] ?>"                               
                                            data-CodigoArticulo ="<?php echo $itemPortafolio['CodigoArticulo'] ?>"
                                            data-NombreArticulo ="<?php echo $itemPortafolio['NombreArticulo'] ?>"
                                            data-CodigoTipo ="<?php echo $itemPortafolio['CodigoTipo'] ?>"
                                            data-CodigoCaracteristica1 ="<?php echo $itemPortafolio['CodigoCaracteristica1'] ?>"
                                            data-CodigoCaracteristica2 ="<?php echo $itemPortafolio['CodigoCaracteristica2'] ?>"
                                            data-CodigoGrupoVentas ="<?php echo $itemPortafolio['CodigoGrupoVentas'] ?>"
                                            data-IdentificadorProductoNuevo ="<?php echo $itemPortafolio['IdentificadorProductoNuevo'] ?>"
                                            data-ACPrecioVenta ="<?php echo $itemPortafolio['ACPrecioVenta'] ?>"
                                            data-ACIdAcuerdoComercial ="<?php echo $itemPortafolio['ACIdAcuerdoComercial'] ?>"
                                            data-ACCodigoUnidadMedida ="<?php echo $itemPortafolio['ACCodigoUnidadMedida'] ?>"
                                            data-ACNombreUnidadMedida ="<?php echo $itemPortafolio['ACNombreUnidadMedida'] ?>"
                                            data-SPDisponible ="<?php echo $itemPortafolio['SADisponible'] ?>"                              
                                            data-SPNombreUnidadMedida ="<?php echo $itemPortafolio['SANombreUnidadMedida'] ?>"
                                            data-SPCodigoUnidadMedida ="<?php echo $itemPortafolio['SACodigoUnidadMedida'] ?>"
                                            data-SaldoDisponibleVenta ="<?php echo $itemPortafolio['SaldoDisponibleVentaAutoventa'] ?>"

                                            data-zona-ventas="<?php echo $zonaVentas; ?>"
                                            data-cliente="<?php echo $datosCliente['CuentaCliente']; ?>"

                                            > 

                                            <td style="width: 15%;" class="text-center datos-item">                                                                  
                                                <img class="imagen-producto-<?php echo $itemPortafolio['CodigoVariante']; ?>" src="images/pro.png" />                       
                                            </td>

                                            <td >
                                                <b><?php echo $cont; ?>) Código Artículo:</b>
                                                <?php
                                                echo $itemPortafolio['CodigoVariante'];
                                                ?>                     
                                                <br/>
                                                <?php
                                                echo $itemPortafolio['NombreArticulo'] . ' ' . $itemPortafolio['CodigoCaracteristica1'] . ' ' . $itemPortafolio['CodigoCaracteristica2'] . ' (' . $itemPortafolio['CodigoTipo'] . ')';
                                                ?>
                                                <br/>
                                                <?php
                                                echo $itemPortafolio['CodigoArticulo']
                                                ?>
                                                <br/>
                                                <b>Valor Sin Impuestos:</b><?php echo number_format(floor($itemPortafolio['ACPrecioVenta'])); ?>
                                                <br/>
                                                <b>Valor Con Impuestos:</b><?php
                                                if ($itemPortafolio['PorcentajedeIVA'] != "") {
                                                    $varIVAConvercion = floor($itemPortafolio['ACPrecioVenta']) * floor($itemPortafolio['PorcentajedeIVA']) / 100;
                                                    echo number_format(floor($itemPortafolio['ACPrecioVenta']) + floor($itemPortafolio['ValorIMPOCONSUMO']) + floor($varIVAConvercion));
                                                } else {
                                                    echo number_format(floor($itemPortafolio['ACPrecioVenta']) + floor($itemPortafolio['ValorIMPOCONSUMO']));
                                                };
                                                ?><br/>
                                            </td>
                                            <td style="width: 10%;" class="text-center">
                                                <span class="glyphicon glyphicon-plus" style="color: #1CAF9A; font-size: 20px"></span>
                                                <br/>
                                                <small>Adicionar</small>                                    
                                            </td>
                                            <td style="width: 10%;" class="text-center">
                                                <button class="btn btn-primary retornarmenu" type="button" id="btnDescuentos"
                                                        data-CodigoVariante="<?php echo $itemPortafolio['CodigoVariante'] ?>"                               
                                                        data-CodigoArticulo ="<?php echo $itemPortafolio['CodigoArticulo'] ?>"
                                                        data-NombreArticulo ="<?php echo $itemPortafolio['NombreArticulo'] ?>"
                                                        data-CodigoGrupoDescuentoLinea ="<?php echo $itemPortafolio['CodigoGrupoDescuentoLinea'] ?>"
                                                        data-CodigoGrupoDescuentoMultiLinea ="<?php echo $itemPortafolio['CodigoGrupoDescuentoMultiLinea'] ?>">Descuentos</button>
                                            </td>
                                        </tr>

                                        <?php
                                    }
                                    ?>    

                                    <?php
                                    $cont++;
                                }
                            }
                        }
                        ?>
                    </tbody>
                </table>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>       
            </div>
        </div>
    </div>
</div>

<!--modales  de los diferentes portafolios-->




<div class="modal fade" id="_alertaKitinamico" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id="">Altipal</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: #D9534F;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body"></p>
                    </div>
                </div>

            </div>
            <div class="modal-footer">                 
                <button data-dismiss="modal" class="btn btn-primary" type="button">Aceptar</button>    
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->


<div class="modal fade" id="portafolioAutoventa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 680px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">PORTAFOLIO</h4>
            </div>
            <div class="modal-body mdlPortafolio">

                <table class="table table-bordered" id="tblPortafolioAutoventa">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Producto</th>
                            <th></th> 
                            <th></th>  
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $cont = 1;
                        foreach ($portafolioAutoventa as $itemPortafolio) {
                            ?>
                            <tr data-id-inventario="<?php echo $itemPortafolio['IdSaldoInventario']; ?>" data-nuevo="<?php
                            if ($itemPortafolio['IdentificadorProductoNuevo'] == 1) {
                                echo '1';
                            } else {
                                echo '0';
                            }
                            ?>" data-agregado="1"  <?php
                                if (($itemPortafolio['IdSaldoInventario'] == "" || $itemPortafolio['IdSaldoInventario'] == 0 || $itemPortafolio['AcuerdoComercial'] == 0)) {
                                    echo 'style="background-color:#EAECEE; border-bottom: 2px solid #fff;"';
                                    echo 'data-block="1"';
                                }
                                ?> class="btnAdicionarProductoDetalle cursorpointer"  data-unidad-medida="<?php echo $itemPortafolio['UnidadMedidaProducto']; ?>" data-zona="<?php echo $zonaVentas; ?>" data-codigo-variante="<?php echo $itemPortafolio['CodigoVariante']; ?>" data-cliente="<?php echo $datosCliente['CuentaCliente']; ?>" data-articulo="<?php echo $itemPortafolio['CodigoArticulo']; ?>" data-grupo-ventas="<?php echo $itemPortafolio['CodigoGrupoVentas']; ?>" data-CodigoUnidadMedida-saldo="<?php echo $itemPortafolio['CodigoUnidadMedida']; ?>" data-codigo-tipo="<?php echo $itemPortafolio['CodigoTipo'] ?>">
                                <td style="width: 15%;" class="text-center">

                                    <?php
                                    if ($itemPortafolio['IdentificadorProductoNuevo'] == 1) {
                                        ?>
                                        <img data-producto-nuevo="1" class="imagen-producto-<?php echo $itemPortafolio['CodigoVariante']; ?>" src="images/pronuevo.png" />
                                        <br/>
                                        <small>Nuevo</small>
                                        <?php
                                    } else {
                                        if ($itemPortafolio['SaldoInventario'] == 0 || $itemPortafolio['AcuerdoComercial'] == 0) {
                                            ?>
                                            <img data-producto-nuevo="0" class="imagen-producto-<?php echo $itemPortafolio['CodigoVariante']; ?>" src="images/pro_inactive.png" />
                                            <br/>
                                            <small>Restringido</small>
                                            <?php
                                        } else {
                                            ?>                                        
                                            <img data-producto-nuevo="0" class="imagen-producto-<?php echo $itemPortafolio['CodigoVariante']; ?>" src="images/pro.png" />
                                            <br/>
                                            <small>Producto</small>
                                            <?php
                                        }
                                    }
                                    ?>                        
                                </td>

                                <td >
                                    <b><?php echo $cont; ?>) Código Artículo:</b>                                   
                                    <?php
                                    echo $itemPortafolio['CodigoVariante'];
                                    ?>                         
                                    <br/>
                                    <?php
                                    echo $itemPortafolio['NombreArticulo'] . ' ' . $itemPortafolio['CodigoCaracteristica1'] . ' ' . $itemPortafolio['CodigoCaracteristica2'] . ' (' . $itemPortafolio['CodigoTipo'] . ')';
                                    ?>
                                    <br/>
                                    <b>Valor Sin Impuestos:</b><?php echo number_format(floor($itemPortafolio['ACPrecioVenta'])); ?>
                                    <br/>
                                    <b>Valor Con Impuestos:</b><?php
                                    if ($itemPortafolio['PorcentajedeIVA'] != "") {
                                        $varIVAConvercion = floor($itemPortafolio['ACPrecioVenta']) * floor($itemPortafolio['PorcentajedeIVA']) / 100;
                                        echo number_format(floor($itemPortafolio['ACPrecioVenta']) + floor($itemPortafolio['ValorIMPOCONSUMO']) + floor($varIVAConvercion));
                                    } else {
                                        echo number_format(floor($itemPortafolio['ACPrecioVenta']) + floor($itemPortafolio['ValorIMPOCONSUMO']));
                                    };
                                    ?><br/>
                                    <!--
                                    <span>Acuerdo<?php //echo $itemPortafolio['AcuerdoComercial'];        ?></span>
                                    <span>Saldo:<?php //echo $itemPortafolio['SaldoInventario'];         ?></span>
                                    -->

                                </td>
                                <td style="width: 10%;" class="text-center">

                                    <span class="glyphicon glyphicon-plus" style="color: #1CAF9A; font-size: 20px"></span>
                                    <br/>
                                    <small>Adicionar</small>                                    
                                </td>

                                <td style="width: 10%;" class="text-center">
                                    <button class="btn btn-primary retornarmenu" type="button" id="btnDescuentos"
                                            data-CodigoVariante="<?php echo $itemPortafolio['CodigoVariante'] ?>"                               
                                            data-CodigoArticulo ="<?php echo $itemPortafolio['CodigoArticulo'] ?>"
                                            data-NombreArticulo ="<?php echo $itemPortafolio['NombreArticulo'] ?>"
                                            data-CodigoGrupoDescuentoLinea ="<?php echo $itemPortafolio['CodigoGrupoDescuentoLinea'] ?>"
                                            data-CodigoGrupoDescuentoMultiLinea ="<?php echo $itemPortafolio['CodigoGrupoDescuentoMultiLinea'] ?>">Descuentos</button>
                                </td>
                            </tr>
                            <?php
                            $cont++;
                        }
                        ?>
                    </tbody>
                </table>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>       
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="alertaArticuloSinAcuerdo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Mensaje Articulo Portafolio</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: #D9534F;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body" id="mensaje-error">El articulo no cuenta con un acuerdo comercial!</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-small-template" data-dismiss="modal">Aceptar</button>        
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="alertaArticuloSinSaldo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Mensaje Artículo Portafolio</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: #D9534F;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body" id="mensaje-error">El artículo no cuenta con saldo disponible!</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-small-template" data-dismiss="modal">Aceptar</button>        
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="alertaArticuloRestriccion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Mensaje Articulo Portafolio</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: #D9534F;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body" id="mensaje-error">El articulo se encuentra con una restrcción por el proveedor</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-small-template" data-dismiss="modal">Aceptar</button>        
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="articuloPedido" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"><b>Código Artículo: </b><span id="textDetCodigoProducto" class="text-primary"></span></br> <span id="textDetNombreProducto"></span></h4>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label class="col-sm-4 control-label">Unidad de Medida:</label>
                    <div class="col-sm-6">
                        <input type="text" name="name" readonly="readonly" class="form-control" id="textDetUnidadMedida"/> 

                        <input type="hidden" id="textCodigoVariante" />                 
                        <input type="hidden" name="" readonly="readonly" class="form-control" id="txtCodigoArticulo"/>
                        <input type="hidden" name="" readonly="readonly" class="form-control" id="textDetCodigoUnidadMedida"/>      
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Saldo:</label>
                    <div class="col-sm-4">
                        <input type="text" name="name" readonly="readonly" class="form-control" id="textDetSaldo"/>
                    </div>
                    <div class="col-sm-2">
                        <label id="lblUnidadMedidaSaldo"></label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Saldo Limite:</label>
                    <div class="col-sm-4">
                        <input type="number" name="txtSaldoLimite" id="txtSaldoLimite" readonly="readonly" class="form-control"/>

                        <input type="hidden" name="txtCodigoTipo" id="txtCodigoTipo" readonly="readonly" class="form-control"/>

                        <input type="hidden" name="txtLimiteVentasACDL" id="txtLimiteVentasACDL" readonly="readonly" class="form-control"/>
                        <input type="hidden" name="txtSaldoACDL" id="txtSaldoACDL" readonly="readonly" class="form-control"/>
                        <input type="hidden" name="txtSaldoACDL" id="txtSaldoACDLSinConversion" readonly="readonly" class="form-control"/>

                        <input type="hidden" name="" id="txtIdAcuerdo" readonly="readonly" class="form-control"/>                  
                        <input type="hidden" name="" id="txtIdSaldoInventario" readonly="readonly" class="form-control"/>
                        <input type="hidden" name="" id="txtCodigoUnidadSaldoInventario" readonly="readonly" class="form-control"/>
                        <input type="hidden" name="" id="txtCuentaProveedor" readonly="readonly" class="form-control"/>


                        <input type="hidden" name="txtCodigoUnidadMedidaACDL" id="txtCodigoUnidadMedidaACDL" readonly="readonly" class="form-control"/>                  
                        <input type="hidden" name="txtPorcentajeDescuentoLinea1ACDL" id="txtPorcentajeDescuentoLinea1ACDL" readonly="readonly" class="form-control"/>
                        <input type="hidden" name="txtPorcentajeDescuentoLinea2ACDL" id="txtPorcentajeDescuentoLinea2ACDL" readonly="readonly" class="form-control"/>
                    </div>
                    <div class="col-sm-2">
                        <label id="lblUnidadMedidaSaldoLimite"></label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">IVA:</label>
                    <div class="col-sm-6">
                        <input type="text" name="name" readonly="readonly" id="textDetIva" class="form-control"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Impoconsumo:</label>
                    <div class="col-sm-6">
                        <input type="text" name="name" readonly="readonly" id="textDetImpoconsumo" class="form-control"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Valor con Impuestos:</label>
                    <div class="col-sm-6">
                        <input type="text" name="name" readonly="readonly" id="textDetValorImpuesto" class="form-control"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Valor del Producto:</label>
                    <div class="col-sm-6">
                        <input type="text" name="name" readonly="readonly" id="textDetValorProductoMostrar2" class="form-control"/>
                        <input type="hidden" name="name" readonly="readonly" id="textDetValorProducto" class="form-control"/>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-sm-4 control-label">Cantidad Pedida:</label>
                    <div class="col-sm-6">
                        <input type="number" id="txtCantidadPedida" name="name" class="form-control"/>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-sm-4 control-label">Descuento Promocional:</label>
                    <div class="col-sm-6">
                        <!--<input type="text" name="name" id="txtDescuentoProveedor"class="form-control" />-->
                        <input type="text" name="name" id="txtDescuentoProveedorPreventa" class="form-control" readonly="readonly"/>

                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Descuento Canal:</label>
                    <div class="col-sm-6">
                        <input type="text" name="name" id="txtDescuentoAltipal" class="form-control"  readonly="readonly" />
                    </div>
                </div>

                <div class="form-group">

                    <label class="col-sm-4 control-label">Descuento Especial:</label>
                    <div class="col-sm-6">
                        <input type="text" name="name" id="txtDescuentoEspecialPreventa" min="0" max="100"  class="form-control" <?php
                        if (!$permisosDescuentoEspecial) {
                            echo 'readonly="readonly"';
                        }
                        ?>/><br/>

                        <?php if ($permisosDescuentoEspecial): ?>  

                            <select name="" class="form-control select-especial" id="select-especial">
                                <option value="Ninguno">Responsable del Descuento</option>
                                <?php if ($permisosDescuentoEspecial['PermitirModificarDescuentoEspecialProveedor'] == "Verdadero"): ?>
                                    <option value="Proveedor" data-cantidad="1" >Proveedor</option>
                                <?php endif; ?>

                                <?php if ($permisosDescuentoEspecial['PermitirModificarDescuentoEspecialAltipal'] == "Verdadero"): ?>
                                    <option value="Altipal" data-cantidad="1">Altipal</option>
                                <?php endif; ?>  

                                <?php if ($permisosDescuentoEspecial['PermitirModificarDescuentoEspecialAltipal'] == "Verdadero" && $permisosDescuentoEspecial['PermitirModificarDescuentoEspecialProveedor'] == "Verdadero"): ?>
                                    <option value="Compartidos" data-cantidad="2">Compartidos</option>
                                <?php endif; ?>   

                            </select><br/>
                        <?php endif; ?> 

                        <div id="div-descuento-especial">

                        </div>

                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnAdicionarProducto">Adicionar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="alertaErrorValidarSitio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Mensaje Adicionar Pedido</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: #D9534F;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body" id="mensaje-error"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="form-group">
                    <div class="col-sm-5">
                        <div class="">
                            <label>Si</label>

                            <input type="radio" name="radio" id="RdOtropedido">

                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="">

                            <label>No</label>
                            <input type="radio" name="radio" data-dismiss="modal">

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="alertaErrorValidar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Mensaje Adicionar Pedido</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: #D9534F;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body" id="mensaje-error"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="alertaACDLCantidad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Mensaje Acuerdo Comercial Descuento Linea</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: #D9534F;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body" id="mensaje-error"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-small-template" id="btnAceptarSaldoLimite">Aceptar</button>     
                <button type="button" class="btn btn-default btn-small-template" id="btn-cancelar-ACDL">Cancelar</button>        
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="mdlKitVirtual" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index: 10050;">

    <div id="contMdlKitVirtual">

    </div>

</div>

<div class="modal fade" id="mdlKitDinamico" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index: 10050;">

    <div id="contMdlKitDinamico">

    </div>

</div>


<div class="modal fade" id="mdlArticuloDetalle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <div id="contMdlArticuloDetalle">

    </div>

</div>




<div class="modal fade" id="_alertCambiarTipoVenta" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id=""></h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: orange;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body">Si cambia el tipo de venta se eliminaran los productos que se han adicionado al pedido; <b>Desea cambiar el tipo de venta?</b></p>
                    </div>
                </div>

            </div>
            <div class="modal-footer">                 
                <button type="button" id="btnCambiarTipoVentaSi" class="btn btn-primary" type="button">Si</button>   
                <button type="button" id="btnCambiarTipoVentaNo" class="btn btn-primary" type="button">No</button>    
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->

<div class="modal fade draggable-modal" id="detalleEscalaDescuentos" tabindex="-2" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Escala de descuentos</h4>
            </div>
            <div class="modal-body" id="tableEscalaDescuentos"></div>
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



<?php if (Yii::app()->user->hasFlash('success')): ?>
    <script>
        $(document).ready(function () {
            $('#_alertaSucessPedido #msg').html('Mensaje Pedido Preventa');
            $('#_alertaSucessPedido #sucess').html('<?php echo Yii::app()->user->getFlash('success'); ?>');
            $('#_alertaSucessPedido').modal('show');

        });
    </script>   
<?php endif; ?>

<?php
$totalAcuerdos = Consultas::model()->getTotalAcuerdos($datosCliente['CuentaCliente'], $datosCliente['CodigoGrupoPrecio']);
if ($totalAcuerdos[0]['TotalAcuerdos'] == '0'):
    ?>
    <script>
        $(document).ready(function () {
            $('#_alertSinAcuerdoPrecio #msg').html('Mensaje');
            $('#_alertSinAcuerdoPrecio #sucess').html('El Cliente <?php echo $datosCliente['CuentaCliente'] ?> no cuenta con acuerdos precioventa por lo tanto no se le puede realizar el pedido');
            $('#_alertSinAcuerdoPrecio').modal('show');

        });
    </script>      
<?php endif; ?>
<?php $this->renderPartial('//mensajes/_alertaSucessPedido', array('zonaVentas' => $zonaVentas, 'cuentaCliente' => $datosCliente['CuentaCliente'])); ?> 
<?php $this->renderPartial('//mensajes/_alerta'); ?> 
<?php $this->renderPartial('//mensajes/_alertaRecargarPagina'); ?>
<?php $this->renderPartial('//mensajes/_alertConfirmationMenu', array('zonaVentas' => $zonaVentas, 'cuentaCliente' => $datosCliente['CuentaCliente'])); ?>
<?php $this->renderPartial('//mensajes/_alertSinAcuerdoPrecio', array('zonaVentas' => $zonaVentas, 'cuentaCliente' => $datosCliente['CuentaCliente'])); ?>