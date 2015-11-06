<?php
/* @var $this TraspasoController */
/* @var $model BmTraspaso */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sede_id')); ?>:</b>
	<?php echo CHtml::encode($data->sede_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('emisor_id')); ?>:</b>
	<?php echo CHtml::encode($data->emisor_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('receptor_id')); ?>:</b>
	<?php echo CHtml::encode($data->receptor_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status_id')); ?>:</b>
	<?php echo CHtml::encode($data->status_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cantidad_total')); ?>:</b>
	<?php echo CHtml::encode($data->cantidad_total); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total')); ?>:</b>
	<?php echo CHtml::encode($data->total); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha')); ?>:</b>
	<?php echo CHtml::encode($data->fecha); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('observaciones')); ?>:</b>
	<?php echo CHtml::encode($data->observaciones); ?>
	<br />

	*/ ?>

</div>