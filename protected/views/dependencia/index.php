<?php
/* @var $this DependenciaController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Dependencias',
);

$this->menu=array(
	array('label'=>'Crear Dependencia', 'url'=>array('create')),
);
?>

<h1>Dependencias</h1>

<?php 
$this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'id'=>'grid-view',
    'columns'=>array(
        array(	'name'=>'Dependencia',
           		'htmlOptions'=>array('style'=>'text-align: left'),
           		'value'=>'$data->descripcion',
        )
    ),
    'summaryText' => 'Mostrando {start}-{end} de {count} registro(s).',
));
?>
