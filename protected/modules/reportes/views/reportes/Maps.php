<div class="pageheader">
    <h2>
        <a href="http://altipal.datosmovil.info/altipalAx/index.php?r=reportes/Reportes/Menu">
            <img src="images/home.png" class="cursorpointer " style="width: 38px; margin-right: 15px; margin-left: 15px;"/>
        </a>
        Reportes<span></span>Maps</h2>      
</div> 

<div class="contentpanel" style="margin-bottom: -27px;">
    <div class="panel panel-default">        
        <div class="panel-body">
            <div class="panel-heading">
                <?php $this->renderPartial('_IconosMenu'); ?>
                <br>
            </div>
        </div>
    </div>  
</div>

<div class="contentpanel">

    <div class="panel panel-default">        
        <div class="panel-body" style="min-height: 1000px;">
            <div class="widget widget-blue">
                <div class="widget-content">  
                    <h3 style="text-align: center">Reportes/Maps</h3>
                        <br>
                            <br>
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <div class="form-group">
                                <label>Agencias</label>
                                <div>
                                    <select id="selectchosenagencia" name="Agencia" class="form-control chosen-select  onchagegrupos" data-placeholder="Seleccione una agencia">
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
                                    <input style="height: 36px;" type="text"  class="form-control"  id="fechaini" value = "<?php echo date('Y-m-d') ?>"/>
                                </div>
                            </div>
                        </div>
                        
                         <div class="col-md-3 text-center">
                            <div class="form-group">
                                <label>Fecha Final</label>
                                <div>
                                    <input style="height: 36px;" type="text"  class="form-control"  id="fechafin" value = "<?php echo date('Y-m-d') ?>"/>
                                </div>
                            </div>
                        </div>
                       
                        <div class="col-md-3 text-center">
                            <div class="form-group">
                                <label>Grupo Ventas</label>
                                <div id="grupoventa" class="onchangezonaventas">
                                    <select id="selectchosegrupventas" name="GruposVentas" class="form-control chosen-select" data-placeholder="Seleccione un grupo ventas">
                                        <option value=""></option>
                                        
                                        
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 text-center">
                            <div class="form-group">
                                <label>Zona Ventas</label>
                                <div id="zonasventas" class="onchangereportzonaventas">
                                    <select id="selectchosezonaventas" name="ZonaVentas" class="form-control chosen-select" data-placeholder="Seleccione una zona venta">
                                        <option value=""></option>


                                    </select>
                                </div>
                            </div>   
                        </div>
                        
                        
                     <div class="col-md-3 text-center">
                            <label></label>
                            <div class="form-group">
                                <input value="Cargar Mapa" type="button" class="btn btn-primary CargarMapa">
                                </div>
                            </div>   
                        </div>

                    </div>
                    
                   
                
                    <div id="Mapa"></div>
                    
                </div>
            </div>



        </div>
    </div>      

<?php $this->renderPartial('//mensajes/_alerta');?> 

 <style>
    .col-md-6{
        margin-bottom: 20px;
    }
    .col-md-4{
        margin-bottom: 20px;
    }
</style>


 

