<style>

td {
    font-size: 10px;
}

@media(max-width:767px){
    img{
        width: 20px;
    }
}
</style>
<div style='width: 100%;'>
  <div class="col-md-4 col-md-offset-2 text-center">
    <table class="table table-bordered" id="tbllogerro2r">
      <thead>
        <tr>
          <th nowrap="nowrap" class="text-center" > </th>
          <th nowrap="nowrap" class="text-center"> Cant </th>
          <th nowrap="nowrap" class="text-center"> valor </th>
          <th nowrap="nowrap" class="text-center"> Detalle </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td nowrap="nowrap" class="text-center" >Pedido</td>
          <td nowrap="nowrap" class="text-center"> <?php echo number_format($detallepedido['conteo'], 0, ',', '.')?> </td>
          <td nowrap="nowrap" class="text-center"> <?php echo "$".number_format($detallepedido['Suma'], 0, ',', '.');?> </td>
          <td nowrap="nowrap" class="text-center"> <a href="javascript:abrirModal('pedido')"><img src="images/Zoom.png"/></a> </td>
        </tr>
        
        <tr>
          <td nowrap="nowrap" class="text-center" >Pedidos por autorizar</td>
          <td nowrap="nowrap" class="text-center"> <?php echo number_format($detallePedidoPendiente['Conteo'], 0, ',', '.')?> </td>
          <td nowrap="nowrap" class="text-center"> <?php echo "$".number_format($detallePedidoPendiente['valor'], 0, ',', '.');?> </td>
          <td nowrap="nowrap" class="text-center"> <a href=""><a href="javascript:pedidosPendientes()"><img src="images/Zoom.png"/></a> </td>
        </tr>
        
        <tr>
          <td nowrap="nowrap" class="text-center" >Recibos de caja</td>
          <td nowrap="nowrap" class="text-center"> <?php echo number_format($detalleReciboCaja['conteo'], 0, ',', '.')?> </td>
          <td nowrap="nowrap" class="text-center"> <?php echo "$".number_format($detalleReciboCaja['valor'], 0, ',', '.');?> </td>
          <td nowrap="nowrap" class="text-center"> <a href="javascript:abrirModalReciboCaja()"><img src="images/Zoom.png"/></a> </td>
        </tr>
        
        <tr>
          <td nowrap="nowrap" class="text-center" >Devoluciones</td>
          <td nowrap="nowrap" class="text-center"> <?php echo number_format($detalleDevoluciones['conteo'], 0, ',', '.')?> </td>
          <td nowrap="nowrap" class="text-center"> <?php echo "$".number_format($detalleDevoluciones['valor'], 0, ',', '.');?> </td>
          <td nowrap="nowrap" class="text-center"> <a href="javascript:abrirModalDevoluciones()"><img src="images/Zoom.png"/></a> </td>
        </tr>
        
        <tr>
          <td nowrap="nowrap" class="text-center" >Notas Credito</td>
          <td nowrap="nowrap" class="text-center"> <?php echo number_format($detallenotas['conteo'], 0, ',', '.')?> </td>
          <td nowrap="nowrap" class="text-center"> <?php echo "$".number_format($detallenotas['valor'], 0, ',', '.');?> </td>
          <td nowrap="nowrap" class="text-center"><a href="javascript:abrirModalNotaCredito()"><img src="images/Zoom.png"/></a> </td>
        </tr>
        
        <tr>
          <td nowrap="nowrap" class="text-center" >Clientes Nuevos</td>
          <td nowrap="nowrap" class="text-center"> <?php echo number_format($detalleClienteNuevo['conteo'], 0, ',', '.')?> </td>
          <td nowrap="nowrap" class="text-center"> <?php echo $detalleClienteNuevo['valor'];?> </td>
          <td nowrap="nowrap" class="text-center"> <a href="javascript:abrirModalClientenuevo()"><img src="images/Zoom.png"/></a> </td>
        </tr>
        
        <tr>
          <td nowrap="nowrap" class="text-center" >No Visitas</td>
          <td nowrap="nowrap" class="text-center"> <?php echo number_format($detalleNoVenta['conteo'], 0, ',', '.')?> </td>
          <td nowrap="nowrap" class="text-center"> <?php echo $detalleNoVenta['valor'];?> </td>
          <td nowrap="nowrap" class="text-center"> <a href="javascript:abrirModalNovisita()"><img src="images/Zoom.png"/></a> </td>
        </tr>
        
        <tr>
          <td nowrap="nowrap" class="text-center" >Consig Vendedor</td>
       	  <td nowrap="nowrap" class="text-center"> <?php echo number_format($detalleConsignacion['conteo'], 0, ',', '.')?> </td>
          <td nowrap="nowrap" class="text-center"> <?php echo "$".number_format($detalleConsignacion['valor'], 0, ',', '.');?>  </td>
          <td nowrap="nowrap" class="text-center"> <a href="javascript:abrirModalConsigvendedor()"><img src="images/Zoom.png"/></a> </td>
        </tr>
        
        <tr>
          <td nowrap="nowrap" class="text-center" >No Recaudos</td>
          <td nowrap="nowrap" class="text-center"> <?php echo number_format($detalleNoRecaudo['conteo'], 0, ',', '.')?> </td>
          <td nowrap="nowrap" class="text-center"> <?php echo $detalleNoRecaudo['valor'];?>  </td>
          <td nowrap="nowrap" class="text-center"><a href="javascript:abrirModalNorecaudado()"><img src="images/Zoom.png"/></a> </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Pedidos</h4>
      </div>
      <div class="modal-body">
          
          <div id="datosConsultaPedido" ></div>
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
     <!--   <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->


<div class="modal fade" id="myModalRc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Recibos de caja</h4>
      </div>
      <div class="modal-body">
          
          <div id="datosConsultaRecibosCaja" ></div>
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
     <!--   <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->

<div class="modal fade" id="myModalDevoluciones" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Devoluciones</h4>
      </div>
      <div class="modal-body">
          
          <div id="datosConsultaDevoluciones" ></div>
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
     <!--   <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->


<div class="modal fade" id="myModalNotacredito" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Notas Credito</h4>
      </div>
      <div class="modal-body">
          
          <div id="datosConsultaNotacredito" ></div>
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
     <!--   <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->


<div class="modal fade" id="myModalClientenuevo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Cliente Nuevo</h4>
      </div>
      <div class="modal-body">
          
          <div id="datosConsultaClientenuevo" ></div>
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
     <!--   <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->


<div class="modal fade" id="myModalConsigvendedor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Consig Vendedor</h4>
      </div>
      <div class="modal-body">
          
          <div id="datosConsultaConsigvendedor" ></div>
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
     <!--   <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->

<div class="modal fade" id="myModalNorecaudado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">No Recaudados</h4>
      </div>
      <div class="modal-body">
          
          <div id="datosConsultaNorecaudado" ></div>
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
     <!--   <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->

<div class="modal fade" id="myModalNovisita" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">No Recaudados</h4>
      </div>
      <div class="modal-body">
          
          <div id="datosConsultaNovisita" ></div>
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
     <!--   <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->
