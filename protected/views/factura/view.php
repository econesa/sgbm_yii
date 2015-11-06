<?php
/* Desarrollado por Elisa Conesa <econesa@gmail.com>*/
/* @var $this FacturaController */
/* @var $model Factura */

$this->breadcrumbs=array(
	'Facturas'=>array('index'),
	$model->numero,
);

$this->menu=array(
	array('label'=>'Listar Facturas', 'url'=>array('index')),
	array('label'=>'Crear Factura', 'url'=>array('create')),
	array('label'=>'Modificar Factura', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Factura', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'¿Esta seguro de que desea eliminar este registro?')),
);
?>

<h1>Detalles de la Factura #<?php echo $model->numero; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'numero',
		'proveedor',
		array( 'name'=>'Fecha', 'value' => Yii::app()->dateFormatter->formatDateTime(
			CDateTimeParser::parse($model->fecha, "yyyy-MM-dd hh:mm:ss"),"medium","short")),
	),
)); 

if(Yii::app()->user->hasFlash('error')):?>
    <div class="flash-error" style="margin-bottom:0.5em;">
        <font style="color:red"><?php echo Yii::app()->user->getFlash('error'); ?></font>
    </div><?php 
endif;
?>
