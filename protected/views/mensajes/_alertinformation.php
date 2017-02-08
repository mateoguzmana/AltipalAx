

<div class="modal fade" id="_alertinformation" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id="msg">Mensaje</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: #EEA236;"></span>
                    </div>
                    <div class="col-sm-10">
                        <?php
                        $numero = Consultas::model()->getUltimaTranfrencia();
                        ?> 
                        <?php 
                        foreach ($numero as $itemnum){ 
                        ?>
                        <p class="text-modal-body">El  numero de transferencia quedo en: <?php echo $itemnum ?> </p>
                        <?php 
                        }
                        ?>
                    </div>
                </div>

            </div>
            <div class="modal-footer">                 
                <button data-dismiss="modal" class="btn btn-primary" type="button">Aceptar</button>    
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->