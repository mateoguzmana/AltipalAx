<?php   

 Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#administrador-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

?>
<div class="pageheader">
    <h2>        
        <img src="images/home.png" alt="Ir al menu" class="cursorpointer saliradminUser" id=""  style="width: 38px; margin-right: 15px; margin-left: 15px;"/> 
        Administrar Usuarios <span></span></h2>      
</div>



<div class="contentpanel">

    <div class="panel panel-default">
       


        <div class="panel-body" style="min-height: 450px;">
            <div class="widget widget-blue">
                <div class="widget-content">
                    
                    <div class="mb40"></div>
                    
                    <div class="row">
                        
                        
                        <div class="col-sm-10 col-sm-offset-1">
                            
                            <?php echo CHtml::link('Buscar','#',array('class'=>'search-button btn btn-primary')); ?>
                                <div class="search-form" style="display:none">
                                <?php $this->renderPartial('_search',array(
                                        'model'=>$model,
                                )); ?>
                                </div><!-- search-form -->
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <a href="index.php?r=administarUsuarios/create" class="btn btn-primary">Crear Usuario</a>
                                
                        </div> 
                            
                        <?php 
//                          echo '<pre>';              
//                          print_r($model);
//                        exit();
                        ?>
                        
                        <div class="col-sm-10 col-sm-offset-1">    
                       
                        <?php $this->widget('zii.widgets.grid.CGridView', array(
                                'id'=>'administrador-grid',
                                'dataProvider'=>$model->search(),
                                'filter'=>$model,
                                'itemsCssClass' => 'table table-hover table-striped table-bordered',
                                'columns'=>array(
                                        'Id',
                                        'Cedula',
                                        'Usuario',
                                        'Clave',
                                        'Nombres',
                                        'Apellidos',
                                        /*
                                        'Email',
                                        'Telefono',
                                        'Celular',
                                        'IdPerfil',
                                        'Direccion',
                                        'IdTipoUsuario',
                                        'Activo',
                                        'Nit',
                                        */
                                        array(
                                                'class'=>'CButtonColumn',
                                               'template'=>'{delete}{update}',
                                        ),
                                ),
                        )); ?>
                        
                    </div>
                   </div>     

                </div>
            </div>
        </div>
    </div>

</div>
<?php $this->renderPartial('//mensajes/_alertConfirmarAdminUsuario');?>

