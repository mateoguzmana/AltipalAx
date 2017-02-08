

<div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
               
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"><b>Código Variante:</b>&nbsp;<label class="text-primary"> <?php echo $arrayDatos['variante'] ?></label><br><label> <?php echo $arrayDatos['nombreProducto'] ?></label></h4>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label class="col-sm-4 control-label">Unidad de Medida:</label>
                    <div class="col-sm-6">
                        <input type="text" name="name" readonly="readonly" class="form-control" id="textUnidadMedida" value="<?php echo $arrayDatos['unidadMedida'] ?>"/> 

                        <input type="hidden" id="textCodigoVariante" />                 
                        <input type="hidden" name="" readonly="readonly" class="form-control" id="txtCodigoArticulo"/>
                        <input type="hidden" name="" readonly="readonly" class="form-control" id="textDetCodigoUnidadMedida"/>      
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Saldo:</label>
                    <div class="col-sm-6">
                        <input type="text" name="name" readonly="readonly" class="form-control" id="textSaldo" value="<?php echo $arrayDatos['saldo'] ?>"/>
                    </div>
                </div>

                <div class="form-group">
                     <div class="col-sm-6">
                          <input type="hidden" name="txtLimiteVentasACDL" id="txtLiVentasACDL" readonly="readonly" class="form-control"/>
                        <input type="hidden" name="txtSaldoACDL" id="txtSalCDL" readonly="readonly" class="form-control"/>
                        <input type="hidden" name="txtSaldoACDL" id="txtSaldoACDLSinConv" readonly="readonly" class="form-control"/>

                        <input type="hidden" name="" id="txtIdAcue" readonly="readonly" class="form-control"/>                  
                        <input type="hidden" name="" id="txtIdSaldoInveno" readonly="readonly" class="form-control"/>
                        <input type="hidden" name="" id="txtCodigoUnidadSaldoInventa" readonly="readonly" class="form-control"/>


                        <input type="hidden" name="txtCodigoUnidadMedidaACDL" id="txtCodigoUnidMediACDL" readonly="readonly" class="form-control"/>                  
                        <input type="hidden" name="txtPorcentajeDescuentoLinea1ACDL" id="txtPorcentajeDescuentoLin1ACDL" readonly="readonly" class="form-control"/>
                        <input type="hidden" name="txtPorcentajeDescuentoLinea2ACDL" id="txtPorcentajeDescuentoLin2ACDL" readonly="readonly" class="form-control"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">IVA:</label>
                    <div class="col-sm-6">
                        <input type="text" name="name" readonly="readonly" id="textIva" class="form-control" value="<?php echo $arrayDatos['iva'] ?>"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Impoconsumo:</label>
                    <div class="col-sm-6">
                        <input type="text" name="name" readonly="readonly" id="textImpoconsumo" class="form-control" value="<?php echo $arrayDatos['impoconsumo'] ?>"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Valor del Producto:</label>
                    <div class="col-sm-6">
                        <input type="text" name="name" readonly="readonly" id="textValorProductoMostrar" class="form-control" value="<?php echo $arrayDatos['valorUnitario'] ?>"/>
                        <input type="hidden" name="name" readonly="readonly" id="textValorProducto" class="form-control"/>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-sm-4 control-label">Cantidad Pedida:</label>
                    <div class="col-sm-6">
                        <input type="number" id="txtCantidadPedidaTransac" name="name" class="form-control" value="<?php echo $arrayDatos['cantidad'] ?>"/>
                    </div>
                </div>

 
                 

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary btn-adicionar-producto-consignacion">Adicionar</button>
            </div>
        </div>
</div>    
 