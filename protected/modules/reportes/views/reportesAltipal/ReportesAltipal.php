<div class="pageheader">
    <h2>
        <a href="http://altipal.datosmovil.info/altipalAx/index.php?r=reportes/Reportes/Menu">
            <img src="images/home.png" class="cursorpointer " style="width: 38px; margin-right: 15px; margin-left: 15px;"/>
        </a>
        Reportes<span></span>Reportes Altipal</h2>      
</div> 

<div class="contentpanel">
    <div class="panel panel-default">        
        <div class="panel-body" style="margin-bottom: -27px;">
            <div class="panel-heading">
                <?php $this->renderPartial('_IconosMenu');?>
            </div>
        </div>
    </div>
</div>

<div class="contentpanel">

    <div class="panel panel-default">        
        <div class="panel-body" style="min-height: 1000px;">

            <div class="widget widget-blue">

                <div class="widget-content">
                    <h3 style="text-align: center">Reportes/Reportes ALTIPAL</h3>
                        <br>
                            <br>
                    <div class="container-fluid">
                    <div class="row">
                         <div class="col-md-3 text-center">
                            <div class="form-group">
                                <label>Agencias</label>
                                <div>
                                    <select id="selectchosenagencia" name="Agencia" class="form-control chosen-select  onchagegrupos  GenrarRepoteAltipalAgencia" data-placeholder="Seleccione una agencia">
                                         <option value=""></option>
                                        <?php
                                         
                                        foreach ($Agencias as $itemaAgen) {
                                            ?> 
                                            <option value="<?php echo $itemaAgen['CodAgencia'] ?>"><?php echo $itemaAgen['Nombre'] ?></option>

                                        <?php } ?>
                                    </select>

                                </div>
                            </div>
                        </div>
                         <div class="col-md-3 text-center">
                            <div class="form-group">
                                <label>Fecha Inicial</label>
                                <div>
                                    <input style="height: 36px;" type="text"  class="form-control hasdatepicker"  id="fechaini" value = "<?php echo date('Y-m-d') ?>"/>
                                </div>
                            </div>
                        </div>
                         <div class="col-md-3 text-center">
                            <div class="form-group">
                                <label>Fecha Final</label>
                                <div>
                                    <input style="height: 36px;" type="text"  class="form-control hasdatepicker"  id="fechafin" value = "<?php echo date('Y-m-d') ?>"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="form-group">
                                <label>Grupo Ventas</label>
                                <div id="grupoventa" class="onchangegrupoventas">
                                    <select id="selectchosegrupventas" name="GruposVentas" class="form-control chosen-select" data-placeholder="Seleccione un grupo ventas">
                                        <option value=""></option>
                                        
                                        
                                    </select>
                                </div>
                            </div>
                        </div> 
                         <div class="col-md-4 col-md-offset-4 text-center">
                            <div class="form-group">
                                <label>Reportes</label>
                                    <select id="selectchosereportes" name="Reportes" class="form-control chosen-select CargarReportes" data-placeholder="Seleccione un reporte">
                                        <option value=""></option>
                                        <option value="1">Reporte Hora Visita</option>
                                        <option value="2">Pedidos ACTIVITY – AX 2012</option>
                                    </select>
                                
                            </div>
                        </div>
                        <div class="col-md-12  text-center">
                            <input type="button" class="btn btn-primary Exportar btn-lg" style="background-color: #24D29B;border: solid 2px; #24D29B;border-radius: 5px;" value="Exportar"> 
                            <br>
                        </div>
                    </div>
                    <div id="TablaReporte"></div>
                    </div>
                </div>
            </div>



        </div>
    </div>      

<?php $this->renderPartial('//mensajes/_alerta');?>

</div>

 <style>
    .col-md-6{
        margin-bottom: 20px;
    }
    .col-md-4{
        margin-bottom: 20px;
    }
</style>


 

