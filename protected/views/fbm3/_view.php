<?php
/* @var $this Fbm3Controller */
/* @var $model Fbm3 */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('comprobante')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->comprobante), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dependencia_id')); ?>:</b>
	<?php echo CHtml::encode($data->dependencia->descripcion); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha')); ?>:</b>
	<?php echo Yii::app()->dateFormatter->formatDateTime( CDateTimeParser::parse($data->fecha, "yyyy-MM-dd hh:mm:ss" ),'medium','short'); ?>
	<br />

</div>