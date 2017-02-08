<?php
/* @var $this AdministarUsuariosController */
/* @var $model Administrador */

$this->breadcrumbs = array(
    'Administradors' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List Administrador', 'url' => array('index')),
    array('label' => 'Create Administrador', 'url' => array('create')),
);

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

<h1>Manage Administradors</h1>

<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Burcar', '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'administrador-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
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
            'class' => 'CButtonColumn',
        ),
    ),
));
?>