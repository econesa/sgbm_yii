<?php
/* @var $this Fbm3Controller */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Reportes'=>array('index'),
	'Formulario B.M.3',
);

$this->menu=array(
	array('label'=>'Crear B.M.3', 'url'=>array('create')),
);
?>

<h1>Relación de Bienes Faltantes (Formulario B.M.3)</h1>

<p>Este formulario se presenta para informar las diferencias entre existencias f&iacute;sicas y los registros contables.</p>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
