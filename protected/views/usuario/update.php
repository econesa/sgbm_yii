<?php
/* @var $this UsuarioController */
/* @var $model Usuario */

$this->breadcrumbs=array(
	'Usuarios'=>array('index'),
	$model->username=>array('view','id'=>$model->id),
	'Modificar',
);

$this->menu=array(
	array('label'=>'Listar Usuarios', 'url'=>array('index')),
	array('label'=>'Crear Usuario', 'url'=>array('create')),
	array('label'=>'Mostrar Usuario', 'url'=>array('view', 'id'=>$model->id)),
);
?>

<h1>Modificar Usuario <?php echo $model->username; ?></h1>

<?php 
echo $this->renderPartial('_form', 
	array('model'=>$model, 'roles'=>$roles, 'dps'=>$dps)
);
?>