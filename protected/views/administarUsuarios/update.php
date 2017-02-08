<?php 

$donde=TRUE;

?>
<div class="pageheader">
    <h2>        
        <img src="images/home.png" alt="Ir al menu" class="cursorpointer salirEditUser" id=""  style="width: 38px; margin-right: 15px; margin-left: 15px;"/> 
        Actualizar Usuario: <?php echo $model->Nombres; ?><span></span></h2>      
</div>



<div class="contentpanel">

    <div class="panel panel-default">
       


        <div class="panel-body" style="min-height: 450px;">
            <div class="widget widget-blue">
                <div class="widget-content">
                    
                    <div class="mb40"></div>
                    
                    <div class="row">                        
                        <?php $this->renderPartial('_form', array('model'=>$model,'datos'=>$datos,'donde'=>$donde,'datosNotas'=>$datosNotas,'datosPerfilAproba'=>$datosPerfilAproba,'verificacionconfig'=>$verificacionconfig)); ?> 
                   </div>     

                </div>
            </div>
        </div>
    </div>

</div>
<?php $this->renderPartial('//mensajes/_alertConfirmarEditAdminUsuario');?>

