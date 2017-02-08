<?php 
$sesion  = Yii::app()->user->getState('_cedula'); 
?>
<div class="pageheader">
    <h2>        
        <img src="images/home.png" alt="Ir al menu" class="cursorpointer" id="retornarMenu"  style="width: 38px; margin-right: 15px; margin-left: 15px;"/> 
        Notas Crédito Detalle <span></span></h2>      
</div>

<div class="contentpanel">
    <div class="panel panel-default">
        <div class="panel-body" style="min-height: 450px;">
            <div class="widget widget-blue">
                <div class="widget-content">
                    <div class="row">
                        <div class="text-center"><h3>Después de autorizar o rechazar las notas no podrá deshacerlo</h3></div><br><div align="center"><a href="index.php?r=reportes/AprovacionDocumentos/AjaxAprovarNotasCredito&agencia=<?php echo $InformacionNotaCredito[0]['CodAgencia']; ?>&grupoVentas=<?php echo $InformacionNotaCredito[0]['CodigoGrupoVentas'] ?>&ex=1"><img title="Exporta" src="images/excel.png" style="width: 40px; height: 40px;"></a></div>
                        <label><b>Agencia:</b>&nbsp; <?php echo $InformacionNotaCredito[0]['agencia']; ?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><b>Grupo Venta:</b>&nbsp; <?php echo $InformacionNotaCredito[0]['NombreGrupoVentas']; ?></label>
                        <div class="col-md-12">                           
                             <div style="overflow-y: scroll; min-height: 100%; max-height: 400px; border: solid 2px #eee">
                                <table class="table  table-hover table-bordered mb30" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th style="width: 3%;">No.</th>                                            
                                            <th class="text-center">Vendedor</th>
                                            <th class="text-center">Cliente</th>
                                            <th class="text-center">Concepto</th>
                                            <th class="text-center">No. Factura</th>
                                            <th class="text-center">Valor Factura</th>
                                            <th class="text-center">Valor Notas</th>
                                            <th class="text-center">% Notas</th>
                                            <th class="text-center">Responsable</th>
                                            <th class="text-center">Fecha Nota</th>
                                            <th class="text-center">Autorizar</th>
                                            <th class="text-center">Rechazar</th>
                                            <?php
                                            $conColum=0;
                                            foreach ($InformacionNotaCredito as $ItemNotas):
                                                $conColum++;
                                                if($ItemNotas['Fabricante'] != ""):
                                                    if($conColum == 1):
                                             ?>
                                            <th class="text-center">Dinámicas</th>
                                            <?php endif; endif;  endforeach; ?>
                                            <th class="text-center">Comentario</th>
                                            <th class="text-center">Observaciones</th>    
                                            <th class="text-center">Soportes</th>                                                
                                        </tr>
                                    </thead>
                                    <tbody>                                                                            
                                        <?php $cont=1; foreach ($InformacionNotaCredito as $ItemNotas): ?>
                                        <tr>
                                            <td><?php echo $cont ?></td>
                                            <td nowrap="nowrap"><?php echo $ItemNotas['Nombre']?>--<?php echo $ItemNotas['CodZonaVentas']?></td>
                                            <td nowrap="nowrap"><?php echo $ItemNotas['NombreCliente']?>--<?php echo $ItemNotas['CuentaCliente']?></td>
                                            <td nowrap="nowrap"><?php echo $ItemNotas['NombreConceptoNotaCredito']?>--<?php echo $ItemNotas['CodigoConceptoNotaCredito']?></td>
                                            <td><?php echo $ItemNotas['NumeroFactura']?><br/> <button class="btn btn-warning btn-xs" id="<?php echo $ItemNotas['NumeroFactura']?>" onclick="Detalle(this.id)"> Detalle </button></td>
                                            <td nowrap="nowrap"><b><?php echo number_format($ItemNotas['ValorNetoFactura'],'2',',','.') ?></b></td>
                                            <td nowrap="nowrap"><b><?php echo number_format($ItemNotas['Valor'],'2',',','.') ?></b></td>
                                            <?php $porcetaje = $ItemNotas['Valor'] * 100 / $ItemNotas['ValorNetoFactura']  ?>
                                            <td nowrap="nowrap"><b><?php echo number_format($porcetaje,'2',',','.') ?> % </b></td>
                                            <?php 
                                            if($ItemNotas['NombreCuentaProveedor'] == ""){
                                                $responsable = 'Altipal';
                                            }else{
                                                $responsable = $ItemNotas['NombreCuentaProveedor'];
                                            }
                                            ?>
                                            <td nowrap="nowrap"><?php echo $responsable ?></td>
                                            <td nowrap="nowrap"><?php echo $ItemNotas['Fecha'] ?></td>
                                            <td nowrap="nowrap"> <button class="btn btn-primary btnautorizar" id="" style="width: 70px; height: 25px;" data-nota="<?php echo $ItemNotas['IdNotaCredito'] ?>" data-factura="<?php echo $ItemNotas['NumeroFactura'] ?>"  data-cli="<?php echo $ItemNotas['CuentaCliente'] ?>"  data-valor="<?php echo $ItemNotas['Valor'] ?>" data-zona="<?php echo $ItemNotas['CodZonaVentas'] ?>" data-asesor="<?php echo $ItemNotas['CodAsesor'] ?>">Autorizar</button></td>
                                            <td nowrap="nowrap"> <button class="btn btn-primary btnrechazar" id="" style="width: 70px; height: 25px;" data-notaRechazar="<?php echo $ItemNotas['IdNotaCredito'] ?>" data-factura="<?php echo $ItemNotas['NumeroFactura'] ?>"  data-cli="<?php echo $ItemNotas['CuentaCliente'] ?>"  data-valor="<?php echo $ItemNotas['Valor'] ?>" data-zona="<?php echo $ItemNotas['CodZonaVentas'] ?>" data-asesor="<?php echo $ItemNotas['CodAsesor'] ?>">Rechazar</button></td>
                                            <?php  if($ItemNotas['Fabricante'] != ""){ ?>
                                            <?php $Dinamicas = AprovacionDocumentos::model()->getDinamicas($agencia,$ItemNotas['Fabricante']); ?>
                                            <td nowrap="nowrap">
                                                <select id="DinamicasNotas<?php echo $ItemNotas['IdNotaCredito'] ?>" onchange="CargarDinamica('<?php  echo $ItemNotas['IdNotaCredito']?>')" class="form-control input-sm mb15 sltItem" style="width: 170px;">
                                                     <option value="0">Seleccione una dinamica</option>
                                                    <?php foreach ($Dinamicas as $itemDinamicas):?>
                                                         <option value="<?php echo $itemDinamicas['Codigo'] ?>"><?php echo $itemDinamicas['Codigo'].'-'.$itemDinamicas['Descripcion'] ?></option>
                                                     <?php endforeach; ?>
                                                </select>
                                                <label id="ValorDina<?php echo $ItemNotas['IdNotaCredito']; ?>"></label><br>  
                                                <label id="SaldoDina<?php echo $ItemNotas['IdNotaCredito']; ?>"></label>
                                                <input type="hidden" id="ValorDinamica<?php echo $ItemNotas['IdNotaCredito']; ?>">
                                                <input type="hidden" id="SaldoDinamica<?php echo $ItemNotas['IdNotaCredito']; ?>">
                                                <input type="hidden" id="CodDinamica<?php echo $ItemNotas['IdNotaCredito']; ?>">
                                            </td>
                                            <?php } ?>
                                            <td nowrap="nowrap"><textarea id="comentario<?php echo $ItemNotas['IdNotaCredito'];?>"></textarea></td>
                                            <td nowrap="nowrap"><?php echo $ItemNotas['Observacion'] ?></td>
                                            <td nowrap="nowrap"><input type="button" class="btn btn-info" value="Imagenes" id="<?php echo $ItemNotas['IdNotaCredito'] ?>" onclick="Fotos(this.id,<?php echo "'$agencia'" ?>)"/></td>
                                            <input type="hidden" value="<?php echo $agencia ?>" id="agencia">
                                            <input type="hidden" value="<?php echo $sesion ?>" id="remitente">
                                        </tr>
                                        <?php $cont++; endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="mdlDetallePedido" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 1220px;">
    <div class="modal-content">
      <div class="modal-header info">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Detalle del pedido</h4>
      </div>
        <div class="modal-body" style="height: 500px; overflow-y: scroll;">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnGuardarPedido">Guardar Pedido</button>
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->

 <div class="modal fade" id="_alertaNota" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Mensaje</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color:orange"></span>
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
</div>

 <div class="modal fade" id="_alertaGurdado" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Mensaje</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="glyphicon glyphicon-ok" style="font-size: 40px; color: green;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">                 
                <button onclick="refrehs()" class="btn btn-primary" type="button">Aceptar</button>    
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div>

<div class="modal fade" id="_alertInformacionFacDetail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 930px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Detalle</h4>
            </div>
            <div id="tabladetalle">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                <!--<button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div>
<div class="modal fade" id="DetalleFotos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 930px;">
        <div class="modal-content">
            <div class="modal-header">
                 <h4 class="modal-title" id="myModalLabel">Fotos</h4>
            </div>
              <div id="tabladetallefoto" ></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                <!--<button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div>
 <div class="modal fade" id="_alertaNotamsg" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Mensaje</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color:red"></span>
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
</div>