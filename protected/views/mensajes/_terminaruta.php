 
<div class="modal fade" id="_alertaValidacionRuta" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content" style="width: 600px;">
            <div class="modal-header">
                <h5 class="modal-title text-center"><b> ¿ Está seguro de terminar la ruta en este momento ?</b></h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: orange; height: 40px;"></span>
                    </div>
                    <div class="col-sm-10" >
                       Terminando ruta está información pasará automaticamente a Altipal
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-5">
                        <?php foreach($numpedidos as $numpedi){}?>
                        <label><b># Pedidos:</b> <?php echo $numpedi['Numpedidos']; ?></label>    
                    </div>
                    <div class="col-sm-5">
                        <div>
                            <?php foreach($totalpedidos as $totalpedi) ?>
                            <b>Valor Pedidos: $</b>  <?php echo number_format($totalpedi['Totalpedidos'], '2', ',', '.') ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-5">
                        <?php foreach ($numrecibos as $numreci){} ?>
                        <label><b># Recibos:</b>  <?php echo $numreci['Reciboscaja']; ?> </label>    
                    </div>
                    <div class="col-sm-5">
                        <div>
                            <?php foreach ($totalrecibos as $totalreci){} ?>
                            <b>Valor Recibos: $</b> <?php echo number_format($totalreci['Totalrccaja'],'2', ',', '.')?>
                        </div>
                    </div>
                </div>
                <?php foreach ($asesor as $codasesor){} ?>
                <input type="hidden" name="asesor" id="asesor" value="<?php echo $codasesor['CodAsesor']; ?>">
            </div>
            <div class="modal-footer">                 
                <a href="javascript:guardarterminarruta(<?php echo $zona ?>)" class="btn btn-primary">Terminar</a>    
                <button data-dismiss="modal" class="btn btn-primary" type="button">Cancelar</button>    
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->