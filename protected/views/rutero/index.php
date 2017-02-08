<?php if(Yii::app()->user->hasFlash('Error')):?>
<script>    
    $(document).ready(function() {
    $('#_alerta .text-modal-body').html('<?php echo Yii::app()->user->getFlash('Error'); ?>');
    $('#_alerta').modal('show');
     });
</script>   
<?php endif; ?>


<div class="contentpanel">

    <div class="panel panel-default">



        <div class="panel-body">

            <div class="row">
                <div class="col-md-2 col-md-offset-4"> 
                        <span class="cursorpointer">
                            <img src="images/ruta.png" style="width: 55px"/><br/>
                            <lable class="text-primary cursorpointer text-center">Rutero</lable>
                        </span> 
                </div>
                
                <div class="col-md-2">
                    <a href="index.php?r=Rutero/Menu">
                        <span class="cursorpointer">
                            <img src="images/pnedientefacturar.png" style="width: 55px"/><br/>
                            <lable class="text-primary cursorpointer text-center">Pendientes Por Facturar</lable>
                        </span> 
                    </a>    
                </div>

            </div> 
            <br>
            <div class="row">
                <div class="col-md-2 col-md-offset-4"> 
                    <a href="index.php?r=Rutero/DimensionesCumplimiento">
                        <span class="cursorpointer">
                            <img src="images/dimensiones.png" style="width: 55px"/><br/>
                            <lable class="text-primary cursorpointer">Dimensiones Cumplimiento</lable>
                        </span>
                    </a>
                </div>
            </div>    
            

        </div>
    </div> 

</div>
<?php $this->renderPartial('//mensajes/_alerta'); ?>