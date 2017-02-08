 

<div class="modal fade" id="_alertaSelect" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
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
                                <label class="col-sm-12 control-label labelAlertaSelectFactura" style="visibility:hidden"></label>
                                <label class="col-sm-12 control-label labelAlertaSelectAboFactura" style="visibility:hidden"></label>
                                <label class="col-sm-12 control-label labelAlertaSelectSaldoFactura" style="visibility:hidden"></label>
                                <label class="col-sm-12 control-label labelAlertaSelectZonaVentasFactura" style="visibility:hidden"></label>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">    
                                    <label class="col-sm-12 control-label labelAlertaSelect"></label>
                                </div>
                                <div class="col-sm-12">
                                    <select id="inputSelect" class="form-control mb15">
                                        <?php foreach ($datos as $item): ?>
                                            <option value="<?php echo $item['value'] ?>"><?php echo $item['descripcion'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">                 
                    <button class="btn btn-primary" type="button" id="btnAlertaSelectOk">Ok</button>   

                </div>
            </div><!-- modal-content -->
        </div><!-- modal-dialog -->
    </div><!-- modal -->