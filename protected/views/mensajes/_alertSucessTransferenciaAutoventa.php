<div class="modal fade" id="_alertSucessTransferenciaAutoventa" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id="msg">Mensaje</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="glyphicon glyphicon-ok" style="font-size: 40px; color: green;"></span>
                    </div>
                    <div class="col-sm-10">
                        <?php
                        $numero = Consultas::model()->getUltimaTranfrencia();
                        ?> 
                        <?php
                        foreach ($numero as $itemnum) {
                            ?>
                            <p class="text-modal-body" id="sucess" data-num="<?php echo $itemnum ?>"  ></p>
                            <?php
                        }
                        ?>
                           
                    </div>
                </div>
            </div>
            <div class="modal-footer">   
                <a class="btn btn-primary" target="_blank" href="index.php?r=TransferenciaAutoventa/GenerarPdf&id=<?php echo $itemnum ?>">Ver pdf</a> 
                <button data-dismiss="modal" class="btn btn-primary retornarmenu" type="button">Aceptar</button>    
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->