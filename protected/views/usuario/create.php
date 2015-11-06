<?php
/* @var $this UsuarioController */
/* @var $model Usuario */

$this->breadcrumbs=array(
	'Usuarios'=>array('index'),
	'Crear',
);

$this->menu=array(
	array('label'=>'Listar Usuario', 'url'=>array('index')),
);
?>

<h1>Crear Usuario</h1>

<?php 
	echo $this->renderPartial('_form', 
		array('model'=>$model, 'roles'=>$roles, 'dps'=>$dps)
	); 
?>