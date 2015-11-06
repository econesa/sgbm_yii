<?php
/* @var $this Fbm3Controller */
/* @var $model Fbm3 */

$this->breadcrumbs=array(
	'Listar B.M.3'=>array('index'),
	'Crear',
);

$this->menu=array(
	array('label'=>'Listar B.M.3', 'url'=>array('index')),
);
?>

<h1>Crear Formulario B.M.3</h1>

<?php echo $this->renderPartial('_form', 
	array('model'=>$model, 'responsables'=>$responsables, 'profesiones'=>$profesiones, 'dps'=>$dps, 'generos'=>$generos, 'cargos'=>$cargos)); 
?>