<?php
/* @var $this CargoController */
/* @var $model Cargo */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('cod')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descripcion')); ?>:</b>
	<?php echo CHtml::encode($data->descripcion); ?>
	<br />

</div>