<?php
/* @var $this FacturaController */
/* @var $model Factura */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('numero')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->numero), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('proveedor')); ?>:</b>
	<?php echo CHtml::encode($data->proveedor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha')); ?>:</b>
	<?php echo CHtml::encode($data->fecha); ?>
	<br />


</div>
