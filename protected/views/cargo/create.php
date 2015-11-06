<?php
/* @author Elisa Conesa <econesa@gmail.com> */
/* @var $this CargoController */
/* @var $model Cargo */

$this->breadcrumbs=array(
	'Cargos'=>array('index'),
	'Crear',
);

$this->menu=array(
	array('label'=>'Listar Cargos', 'url'=>array('index')),
);
?>

<h1>Crear Cargo</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>