<div class="pageheader">
    <h2>        
        <img src="images/home.png" alt="Ir al menu" class="cursorpointer" id="retornarMenu"  style="width: 38px; margin-right: 15px; margin-left: 15px;"/> 
        Devoluciones <span></span></h2>      
</div>

<div class="contentpanel">
    <div class="panel panel-default">
        <div class="panel-body" style="min-height: 100%">
            <div class="form-actions" style="padding: 4px; margin-top: -14px; margin-right: -3px">
                <div class="pull-right">
                    <button class="btn btn-primary btn-lg" onclick="window.open('/altipalAx/pdf/PoliticasAltipalvsCliente.pdf', '_blank')" style="padding: 4px;">Politicas de recogida cliente y proveedor</button>
                </div>
            </div>
            <div class="widget widget-blue">
                <div class="widget-content">
                    <div class="row">
                        <div class="mb30"></div>                        
                        <div class="col-md-12">
                            <div style="overflow-y: scroll; min-height: 100%; max-height: 400px; border: solid 2px #eee">
                                <table class="table table-hover table-striped mb30" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th colspan="3" class="text-center">
                                                <span class="glyphicon glyphicon-import"></span>
                                                <?php $acum=0; $acumutotalDevol=0;?>
                                                <?php foreach ($totaldevolucion as $itemtotaldevolucion){$acum=$acum+$itemtotaldevolucion['devoluciones']; $acumutotalDevol=$acumutotalDevol+$itemtotaldevolucion['totaldevoluciones'];} ?>
                                                TOTAL DEVOLUCIONES (<?php echo $acum;?>)&nbsp;&nbsp;
                                                VALOR ($ <?php echo number_format($acumutotalDevol,'2',',','.');?>) 
                                            </th>                                                                                  
                                        </tr>
                                    </thead>
                                    <tbody>                                      
                                    <?php foreach ($devoluciones as $itemdevoluciones): ?>  
                                        <tr>
                                            <td class="text-right" style="width: 40%;">
                                                <img src="images/devolucionesdhasboar.png" style="width: 60px; margin: 0px 30px; height: 60px;" />                                                
                                            </td>
                                            <td>
                                                <span class="text-primary"><b><?php echo $itemdevoluciones['devoluciones'];?>&nbsp;&nbsp; $ <?php echo number_format($itemdevoluciones['totaldevoluciones'], '2',',','.') ?></b> </span><br/>
                                                <span class="text-danger">  Agencia: <?php echo $itemdevoluciones['NombreAgencia'];  ?> </span><br/>
                                                <span class="text-danger">Grupo ventas: <?php echo $itemdevoluciones['NombreGrupoVentas'];  ?> </span>
                                            </td>
                                            <td> 
                                               <a href="index.php?r=reportes/AprovacionDocumentos/AjaxDetalleDevoluciones&agencia=<?php echo $itemdevoluciones['CodAgencia'];?>&grupoVentas=<?php echo $itemdevoluciones['CodigoGrupoVentas'];?>">
                                                <span class="fa fa-edit text-danger text-left" style="font-size: 35px;"></span>
                                                </a>
                                            </td>                                          
                                        </tr>                                        
                                      <?php endforeach;?>     
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