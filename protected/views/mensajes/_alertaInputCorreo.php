 <?php $agencia = Yii::app()->user->_Agencia; ?>
<div class="modal fade" id="_alertaInputCorreo" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
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
                            <p>Por favor ingrese el correo electronico al cual desea enviar copia del recaudo:</p>
                            </div>
                        <div class="col-sm-12">
                            <input type="text" placeholder="" class="form-control" id="inputAlertaInput"/>
                        </div>
                      </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">                 
                <button 
                    data-zona-ventas=""
                    data-cuenta-cliente=""
                    data-provisional=""
                    data-agencia="<?php echo $agencia ?>"
                    class="btn btn-primary" 
                    class="btn btn-primary" 
                    type="button" 
                    id="btnConfirmarEnviarEmail">
                    Enviar
                </button>    
                <button data-dismiss="modal" id="btnCerrarInputCorreo" class="btn btn-primary" type="button">Cancelar</button>    
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->