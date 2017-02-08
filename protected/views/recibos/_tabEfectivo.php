<?php
$session = new CHttpSession;
$session->open();
if ($session['Cheque']) {
    $datos = $session['Cheque'];
} else {
    $datos = array();
}
?>

<div class="row">

    <div class="col-sm-8">

        <div class="form-group">
            <label class="col-sm-3 control-label text-right" >Factura</label>
            <div class="col-sm-6">
                <input type="text" placeholder="" class="form-control facturaRecibo" readonly="readonly" id="" name=""/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label text-right" >Valor Efectivo</label>
            <div class="col-sm-6">
                <select class="form-control" onchange="InformacionEfectivo()" id="TotalEfectivo">

                </select>
            </div>

        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label text-right" >Saldo Efectivo</label>
            <div class="col-sm-6">
                <input type="text" id="SaldoEfectivo" class="form-control" readonly="true">
                <input type="hidden" id="txtSalEfHid">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label text-right" >Valor</label>
            <div class="col-sm-6">
                <input type="text" placeholder="" value="<?php echo $Efectivo['ValorEfectivo'] ?>" class="form-control" id="txtFacturaEc" name="txtValorEfectivo" onkeyup="format(this)"/>
            </div>
        </div>

        <div class="form-group text-center">
            <a class="btn btn-default" id="btnAgregarEfectivo">Agregar <img src="images/agregar.png" style="width: 30px;"/></a>                          
        </div>   

        <div class="row" id="tblEfectivo"> </div>  

    </div>
</div>

