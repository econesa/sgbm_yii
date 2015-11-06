<?php
/* @var $this Fbm3Controller */
/* @var $model Fbm3 */

$this->breadcrumbs=array(
	'Listar B.M.3'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Modificar',
);

$this->menu=array(
	array('label'=>'Listar B.M.3', 'url'=>array('index')),
	array('label'=>'Crear B.M.3', 'url'=>array('create')),
	array('label'=>'Ver B.M.3', 'url'=>array('view', 'id'=>$model->id)),
);
?>

<h1>Modificar Formulario B.M.3 <?php echo $model->id; ?></h1>

<?php 
echo $this->renderPartial('_form', 
	array('model'=>$model, 'responsables'=>$responsables, 'profesiones'=>$profesiones, 'dps'=>$dps, 'generos'=>'generos')
); 
?>