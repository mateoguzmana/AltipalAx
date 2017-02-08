  
<div class="modal fade" id="_alertCorreoAutoventa" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id=""></h5>
            </div>
            <div class="modal-body">
                <div class="row">                    
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="col-sm-12">    
                            <p>Por favor ingrese el correo electronico al cual desea enviar copia de la factura:</p>
                            </div>
                        <div class="col-sm-12">
                            <input type="text" placeholder="" class="form-control" id="inputCorreoAutoventa"/>
                        </div>
                      </div>
                    </div>
                </div>

            </div>
            <div id="enviandoAutoventa" style="display:none;" class="col-md-offset-5">
                  <img src="images/loaders/loader9.gif" style="height: 35px; width: 35px;">
                  Enviando...
                </div> 
            <div class="modal-footer">                 
                <button 
                    data-zona-ventas="<?php echo $zonaVentas ?>"
                    data-cuenta-cliente="<?php  echo  $cuentaCliente?>"
                    data-agencia="<?php echo $agencia ?>"
                    data-factura="<?php echo $NroFactura ?>"
                    class="btn btn-primary" 
                    id="btnConfirmarEnviarEmailAutoventa">
                    Enviar
                </button> 
                <a href="index.php?r=Clientes/ClientesRutas" class="btn btn-primary">Cancelar</a>    
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->