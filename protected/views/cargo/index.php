<?php
/* @var $this CargoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Cargos',
);

$this->menu=array(
	array('label'=>'Crear Cargo', 'url'=>array('create')),
);
?>

<h1>Cargos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
