<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="pageheader">
    <h2><i class="fa fa-truck"></i> Fuerza de Ventas<span></span></h2>      
</div>

<div class="contentpanel">
    <div class="panel panel-default">        
        <div class="panel-body" style="min-height: 450px;">
            <div class="widget widget-blue">
                <div class="widget-content">                    
                    <div class="row">                        
                        <div class="col-sm-8 col-sm-offset-1">
                            <div class="panel-body">                       
                                <form action="" id="frmZonaVentas" method="post">                               
                                    <div class="col-sm-12 text-right">                                  
                                        <span>No se ha identificado una zona de ventas, elija una opción para continuar.</span>
                                        <div class="mb30"></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-5 control-label text-right">Zona Ventas:</label>
                                        <?php
                                        $zonaVentas = Consultas::model()->getAllZonasAsesor();
                                        ?>

                                        <div class="col-sm-7">
                                            <select name="zonaVentas" id="sltZonaVentas" required name="txtZonaVentas" style="width: 100%;" class="form-control">
                                                <option value="">Selecionar zona de ventas</option>
                                                <?php foreach ($zonaVentas as $item): ?>
                                                    <option data-asesor="<?php echo $item['CodAsesor']; ?>" data-agencia="<?php echo $item['CodAgencia']; ?>" value="<?php echo $item['CodZonaVentas']; ?>"><?php echo $item['CodZonaVentas'] . "-" . $item['NombreZonadeVentas']; ?></option>
                                                <?php endforeach; ?>
                                            </select> 

                                            <input type="hidden" name="hdnCodigoAsesor" id="hdnCodigoAsesor"/>
                                            <input type="hidden" name="hdnAgencia" id="hdnAgencia"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-5 control-label text-right">Codigo Asesor:</label>
                                        <div class="col-sm-7">
                                            <select  id="sltCodigoAsesor" required name="txtCodigoAsesor" style="width: 100%;" class="form-control">
                                                <option value="">Selecionar Codigo Asesor</option>
                                                <?php foreach ($zonaVentas as $item): ?>
                                                    <option data-asesor="<?php echo $item['CodAsesor']; ?>" data-agencia="<?php echo $item['CodAgencia']; ?>" value="<?php echo $item['CodZonaVentas']; ?>"><?php echo $item['CodAsesor']; ?></option>
                                                <?php endforeach; ?>
                                            </select> 

                                        </div>
                                    </div>                               
                                    <div class="form-group">
                                        <label class="col-sm-5 control-label text-right">Nombre Asesor:</label>
                                        <div class="col-sm-7">
                                            <select id="sltNombreAsesor" required name="txtNombreAsesor" style="width: 100%;" class="form-control">
                                                <option value="">Selecionar Nombre Asesor</option>

                                                    <?php foreach ($zonaVentas as $item): ?>
                                                    <option data-asesor="<?php echo $item['CodAsesor']; ?>" data-agencia="<?php echo $item['CodAgencia']; ?>" value="<?php echo $item['CodZonaVentas']; ?>"><?php echo $item['Nombre']; ?></option>
                                                <?php endforeach; ?>
                                            </select> 

                                        </div>
                                    </div>
                                    <div class="mb15"></div>
                                    <div class="form-group text-center">
                                        <input type="submit" value="Ingresar" class="btn btn-primary text-center">
                                    </div>     
                                </form>          
                            </div>
                        </div>
                    </div>                   
                </div>
            </div>
        </div>
    </div>      
</div>
