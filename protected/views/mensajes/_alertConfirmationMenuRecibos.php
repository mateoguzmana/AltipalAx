<div class="modal fade" id="_alertConfirmationMenuRecibos" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id=""></h5>
            </div>
            <div class="modal-body">
                  <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: orange;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body"></p>
                    </div>
                </div>

            </div>
            <div class="modal-footer">                 
              <a href="index.php?r=Clientes/menuClientes&cliente=<?php echo $cuentaCliente;?>&zonaVentas=<?php echo $zonaVentas;?>" class="btn btn-primary">SI</a> 
                <button data-dismiss="modal" class="btn btn-primary" type="button">NO</button>    
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->