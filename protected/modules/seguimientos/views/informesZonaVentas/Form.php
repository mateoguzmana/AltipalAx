<?php

$session = new CHttpSession;
$session->open();
$session['FormZonaVentas'] = "";

?>

<div class="contentpanel">

    <div class="panel panel-default">        
        <div class="panel-body" style="min-height: 450px;">

            <div class="panel-body panel-body-nopadding">


                <form class="form-horizontal" id="formZonaventas" method="post" action="" >  

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Zona ventas:</label>
                        <div class="col-sm-6">
                            <select id="selectchosen" name="CodZonaVentas" class="form-control chosen-select" data-placeholder="Seleccione una zona de ventas">
                                <option value=""></option>
                                <?php
                                $zonasvetas = Zonaventas::model()->findAll();

                                foreach ($zonasvetas as $itemzona) {
                                    ?>
                                    <option value=""></option>       
                                    <option value="<?php echo $itemzona['CodZonaVentas'] ?>"><?php echo $itemzona['NombreZonadeVentas'] ?> ----- <?php echo $itemzona['CodZonaVentas'] ?></option>
                                    <?php
                                }
                                ?>

                            </select>
                        </div>
                    </div>

                    <div  class="row">
                        <div class="col-sm-6 col-sm-offset-5">
                            <button class="btn btn-primary">Siguiente</button>  
                        </div>
                    </div>

                </form>

            </div><!-- panel-body -->  






        </div>
    </div>      



</div>

<?php $this->renderPartial('/mensajes/_alertZonaVentas');?>

