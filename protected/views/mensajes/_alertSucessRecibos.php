<div class="modal fade" id="_alertaSucessRecibos" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id="msg">Mensaje</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <b><span class="glyphicon glyphicon-ok" style="font-size: 40px; color: green;"></span></b>
                    </div>
                    <div class="col-sm-10">                       
                            <p class="text-modal-body" id="sucess"></p>  
                            <p>Desea transmitir la información de la factura mediante:</p>
                    </div>
                </div>

            </div>
            <div class="modal-footer"> 
                <button  
                    class="btn btn-primary"
                    id="btnEnviarCopiaRecibo" 
                    type="button">
                    E-mail
                </button>  
                <button 
                    class="btn btn-primary" 
                    id="btnImprimirPdf"
                    data-zona-ventas=""
                    data-cuenta-cliente=""
                    data-provisional=""
                    type="button">
                    Impresión
                </button>
                <button class="btn btn-default retornarmenu" id="btnCerrarSucessCorreo" type="button">Cancelar</button>  
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->