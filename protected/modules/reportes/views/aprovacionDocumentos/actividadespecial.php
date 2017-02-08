<div class="pageheader">
    <h2>        
        <img src="images/home.png" alt="Ir al menu" class="cursorpointer" id="retornarMenu" style="width: 38px; margin-right: 15px; margin-left: 15px;"/> 
        Actividad Especial <span></span></h2>      
</div>
<div class="contentpanel">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="widget widget-blue">
                <div class="widget-content">
                  <div class="container-fluid">
                    <div class="row">
                        <div class="mb30"></div>                        
                        <div class="col-md-12">
                            <div style="border: 2px solid #eee; overflow-y: scroll; max-height: 470px; min-height: 100%">
                                     <table class="table table-hover table-striped mb30" style="min-width: 400px;">
                                    <thead>
                                        <tr>
                                            <th colspan="3" class="text-center">
                                                <span class="glyphicon glyphicon-import"></span>
                                                <?php $acum=0; $acumpedidosactespecial=0;?>
                                                <?php foreach ($ActividaEspecial as $itemActiEspecial){ $acum=$acum+$itemActiEspecial['TotalPedidos'];  $acumpedidosactespecial=$acumpedidosactespecial+$itemActiEspecial['CantidadPedidos'];} ?>
                                                TOTAL PEDIDOS ACTIVIDAD ESPECIAL (<?php echo $acumpedidosactespecial;?>)&nbsp;&nbsp; 
                                                VALOR ($<?php echo number_format($acum); ?>)
                                            </th>                                                                                  
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($ActividaEspecial as $itemGrupoActividadEspecial): ?>
                                        <tr>
                                            <td class="text-right" style="width: 45%;">
                                                <img src="images/notas_credito_dasboard.png" style="width: 55px; margin: 0px 30px;" />                                                
                                            </td>
                                            <td>
                                                <span class="text-primary"><b><?php echo number_format($itemGrupoActividadEspecial['CantidadPedidos']);?></b>&nbsp;&nbsp;&nbsp;&nbsp;<b>$<?php echo number_format($itemGrupoActividadEspecial['TotalPedidos']);?></b> </span><br/>
                                                <span class="text-danger">  Agencia: <?php echo $itemGrupoActividadEspecial['Nombre']; ?> </span><br/>
                                                <span class="text-danger">Grupo ventas: <?php echo $itemGrupoActividadEspecial['NombreGrupoVentas']; ?> </span>
                                            </td>
                                            <td> 
                                                <a href="index.php?r=reportes/AprovacionDocumentos/AjaxAprovarActividadEspecial&agencia=<?php echo $itemGrupoActividadEspecial['CodAgencia'];?>&grupoVentas=<?php echo $itemGrupoActividadEspecial['CodigoGrupoVentas'];?>">
                                                <span class="fa fa-edit text-danger text-left" style="font-size: 30px;"></span>
                                                </a>
                                            </td>                                          
                                        </tr>                                        
                                        <?php endforeach; ; ?> 
                                    </tbody>
                                </table>
                            </div><!-- table-responsive -->
                        </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>