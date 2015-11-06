<?php
/* @var $this ResponsableController */
/* @var $model Responsable */

$this->breadcrumbs=array(
	'Responsables'=>array('index'),
	$model->dependencia->descripcion,
);

$this->menu=array();
$i = 0;
$this->menu[$i++] = array('label'=>'Listar Responsables', 'url'=>array('index'));
$this->menu[$i++] = array('label'=>'Asignar Responsable', 'url'=>array('create'));
$this->menu[$i++] = array('label'=>'Modificar Responsable', 'url'=>array('update', 'id'=>$model->id));
$this->menu[$i++] = array('label'=>'Cambiar Status', 'url'=>'#', 'linkOptions'=>array('submit'=>array('cambiarStatus','id'=>$model->id),'confirm'=>'¿Está seguro de que esta persona ya no es el responsable?'));

if ($acceso) :
	$this->menu[$i++] = array('label'=>'Eliminar Responsable', 'url'=>'#', 'linkOptions'=>
		array('submit'=>array('delete','id'=>$model->id),'confirm'=>'¿Está seguro de que desea eliminar este registro?'));
endif;

if ($model->dependencia->genero_id==1) :
	echo '<h1>Responsable del '.$model->dependencia->descripcion.'</h1>';
else :
	echo '<h1>Responsable de la '.$model->dependencia->descripcion.'</h1>';
endif;

$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'persona.pdata.nombre',
		array('name'=>'Fecha','value'=> Yii::app()->dateFormatter->formatDateTime($model->fecha,"medium","short")),
		array('name'=>'Status','value'=> ($model->status_id==1) ? 'Activo' : 'Inactivo'),
	),
)); 
?>
