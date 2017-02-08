<?php
/* @var $this AdministarUsuariosController */
/* @var $model Administrador */

$this->breadcrumbs = array(
    'Administradors' => array('index'),
    $model->Id,
);

$this->menu = array(
    array('label' => 'List Administrador', 'url' => array('index')),
    array('label' => 'Create Administrador', 'url' => array('create')),
    array('label' => 'Update Administrador', 'url' => array('update', 'id' => $model->Id)),
    array('label' => 'Delete Administrador', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->Id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage Administrador', 'url' => array('admin')),
);
?>

<h1>View Administrador #<?php echo $model->Id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'Id',
        'Cedula',
        'Usuario',
        'Clave',
        'Nombres',
        'Apellidos',
        'Email',
        'Telefono',
        'Celular',
        'IdPerfil',
        'Direccion',
        'IdTipoUsuario',
        'Activo',
        'Nit',
    ),
));
?>
