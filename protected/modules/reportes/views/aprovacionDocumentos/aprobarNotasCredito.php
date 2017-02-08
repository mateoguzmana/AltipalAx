<div class="pageheader">
    <h2>        
        <img src="images/home.png" alt="Ir al menu" class="cursorpointer" id="retornarMenu"  style="width: 38px; margin-right: 15px; margin-left: 15px;"/> 
        Notas Crédito <span></span></h2>      
</div>
<pre>   
<?php
    //print_r($notasCredito);
?>
</pre>
<div class="contentpanel">
    <div class="panel panel-default">
        <div class="panel-body" style="min-height: 450px;">
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
                                                <?php $acum=0; $acumnotas=0;?>
                                                <?php foreach ($notasCredito as $itemNotas){$acum=$acum+$itemNotas['TotalNota'];  $acumnotas=$acumnotas+$itemNotas['CantidadNotas'];} ?>
                                                TOTAL NOTAS (<?php echo $acumnotas;?>)&nbsp;&nbsp; 
                                                VALOR ($  <?php echo number_format($acum); ?>)
                                            </th>                                                                                  
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($notasCredito as $itemGrupo): ?>
                                        <tr>
                                            <td class="text-right" style="width: 45%;">
                                                <img src="images/notas_credito_dasboard.png" style="width: 55px; margin: 0px 30px;" />                                                
                                            </td>
                                            <td>
                                                <span class="text-primary"><b><?php echo number_format($itemGrupo['CantidadNotas']);?></b>&nbsp;&nbsp;&nbsp;&nbsp; <b>$<?php echo number_format($itemGrupo['TotalNota']);?></b> </span><br/>
                                                <span class="text-danger">  Agencia: <?php echo $itemGrupo['Nombre']; ?> </span><br/>
                                                <span class="text-danger">Grupo ventas: <?php echo $itemGrupo['NombreGrupoVentas']; ?> </span>
                                            </td>
                                            <td> 
                                                <a href="index.php?r=reportes/AprovacionDocumentos/AjaxAprovarNotasCredito&agencia=<?php echo $itemGrupo['CodAgencia'];?>&grupoVentas=<?php echo $itemGrupo['CodigoGrupoVentas'];?>">
                                                <span class="fa fa-edit text-danger text-left" style="font-size: 30px;"></span>
                                                </a>
                                            </td>                                          
                                        </tr>                                        
                                        <?php endforeach;  ?> 
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