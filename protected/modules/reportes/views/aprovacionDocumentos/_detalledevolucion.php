  
<div class="table-responsive" style="font-size: 13px;">
    <table class="table mb30">

        <?php foreach ($InformacionDetalladaDevoluciones as $itemDevoluciones): ?>  
            <thead style="background-color: #E4E7EA">
                <tr class="active">
                    <th colspan="3">
                        Devolución No. <?php echo $itemDevoluciones['IdDevolucion']; ?>
                        <input type="hidden" id="devolucion" value="<?php echo $itemDevoluciones['IdDevolucion']; ?>">
                        <input type="hidden" id="Agencia" value="<?php echo $agencia ?>">
                        <input type="hidden" id="Gupo" value="<?php echo $itemDevoluciones['CodigoGrupoVentas']; ?>">
                        <input type="hidden" id="valordevolucion" value="<?php echo $itemDevoluciones['ValorDevolucion'] ?>">
                        <input type="hidden" id="Zona" value="<?php echo $itemDevoluciones['CodZonaVentas'] ?>">
                        <input type="hidden" id="cliente" value="<?php echo $itemDevoluciones['CuentaCliente'] ?>">
                        <input type="hidden" id="asesor" value="<?php echo $itemDevoluciones['CodAsesor'] ?>">
                    </th>                  
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="width: 25%;"> Zona Ventas: <span><?php echo $itemDevoluciones['CodZonaVentas']; ?></span></td>
                    <td>Vendedor:	<span><?php echo $itemDevoluciones['NombreAsesor']; ?></span></td>
                    <td>Grupo Ventas:	<span><?php echo $itemDevoluciones['NombreGrupoVentas']; ?></span></td>

                </tr>
                <tr>
                    <td>Código Cliente: <span><?php echo $itemDevoluciones['CuentaCliente']; ?></span></td>
                    <td>Cliente:	<span><?php echo $itemDevoluciones['NombreCliente']; ?></span></td>
                    <td>Tipo Negocio: <span><?php echo $itemDevoluciones['TipoNegocio']; ?></span></td>

                </tr>
                <tr>
                    <td>Fecha Devolución: <span><?php echo $itemDevoluciones['FechaDevolucion']; ?></span></td>
                    <td>Observación: <span><?php echo $itemDevoluciones['Observacion']?> </span> </td>
    <!--                    <td> <div align="left">Aprobar<input type="checkbox" class="Checkbox Primary chckAprovacion" value="1" id="aceptar"></div></td>
                    <td> <div align="left">Rechazar<input type="checkbox" class="Checkbox Primary chckAprovacion" value="0" id="rechazar"></div></td>-->
                </tr>

            </tbody>

            <?php break;
        endforeach;
        ?> 
    </table>
</div><!-- table-responsive -->


<div class="table-responsive">
    <table class="table mb30" id="detalle">
        <thead>
            <tr class="active">
                <th colspan="13">Detallado Devoluciones </th>               
            </tr>
            <tr>
                <th>No</th>
                <th class="text-center">Código variante</th>
                <th class="text-center">Nombre Artículo</th>
                <th class="text-center">Unidad Medida</th>
                <th class="text-center">Cantidad</th>
                <th class="text-center">Valor</th>
                <th class="text-center">Proveedor</th>
                <th class="text-center">Motivos</th>
                <th class="text-center">Autorizar <br>Todos<input type="checkbox"  id="checkAll"></th>
                <th class="text-center">Rechazar <br>Todos<input type="checkbox"  id="checkAll-rechazo"></th>
            </tr>

        </thead>
        <tbody>
<?php $cont = 1;
foreach ($InformacionDetalladaDevoluciones as $itemDevolu): ?>  

                <tr>
                    <th><?php echo $cont; ?></th>
                    <th class="text-center"><?php echo $itemDevolu['CodigoVariante']; ?></th>
                    <th class="text-center"><?php echo $itemDevolu['NombreArticulo']; ?></th>
                    <th class="text-center"><?php echo $itemDevolu['NombreUnidadMedida']; ?></th>
                    <th class="text-center"><?php echo $itemDevolu['Cantidad']; ?></th>
                    <th class="text-center" nowrap="nowrap">$ <?php echo number_format($itemDevolu['ValorTotalProducto'], '2', ',', '.') ?></th>
                        <?php $Proveedores = AprovacionDocumentos::model()->getProveedoresDevolcuiones($itemDevolu['CodigoVariante'], $itemDevolu['CodigoGrupoVentas']); ?>
                    <th class="text-center"><?php echo $Proveedores[0]['NombreCuentaProveedor'] ?> <?php echo $Proveedores[0]['CodigoCuentaProveedor'] ?> </th>
                    <th class="text-center">
    <?php $Motivios = AprovacionDocumentos::model()->getMotivoProveedoresDevolucion($itemDevolu['CodigoMotivoDevolucion']); ?>
    <?php echo $Motivios[0]['NombreMotivoDevolucion']; ?>  
                    </th>
                    <th class="text-center"><input type="checkbox" class="CheckSeleccionados  check-autorizar-devolucion check-on" id="on-<?php echo $itemDevolu['CodigoVariante']; ?>" rel="<?php echo $itemDevolu['CodigoVariante']; ?>"  data-prueba="<?php echo $itemDevolu['CodigoVariante']; ?>" value="1"></th>
                    <th class="text-center"><input type="checkbox" class="CheckSeleccionados  checkbox-rechazo check-off" id="off-<?php echo $itemDevolu['CodigoVariante']; ?>" rel="<?php echo $itemDevolu['CodigoVariante']; ?>" data-prueba="<?php echo $itemDevolu['CodigoVariante']; ?>" value="2"></th>
                </tr>

    <?php $cont++;
endforeach; ?>            
        </tbody>
      </table>
       <div class="form-group">
            <label class="col-sm-offset-5 control-label"><b>Comentario</b></label>
            <div align="center">
                <textarea rows="5" class="form-control" id="observacion" name="observacion"></textarea>
            </div>
        </div>
</div><!-- table-responsive -->