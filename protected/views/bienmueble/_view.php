<?php
/* Desarrollado por Elisa Conesa <econesa@gmail.com>*/
/* @var $this BienmuebleController */
/* @var $model Bienmueble */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('codigo')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->codigo), array('view', 'id'=>$data->id)); ?>
	<br />
	
	<?php 
	/*
	if (isset($data->dependencia)) : 
		echo '<p>';
		echo '<b>'.CHtml::encode($data->getAttributeLabel('dependencia_id')).'</b>:';
		echo CHtml::encode($data->dependencia->descripcion); 
		echo '</p>';
	endif; 
	*/
	?>
	
	<p><?php echo CHtml::encode($data->getAttributeLabel('descripcion')); ?>:</b>
	<?php echo CHtml::encode($data->descripcion); ?>
	</p>

	<p><?php echo CHtml::encode($data->getAttributeLabel('observaciones')); ?>:</b>
	<?php echo '<font style="color:#993399">'.CHtml::encode($data->observaciones).'</font>'; ?>
	</p>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('status_id')); ?>:</b>
	<?php echo CHtml::encode($data->status_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('observaciones')); ?>:</b>
	<?php echo CHtml::encode($data->observaciones); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('f_incorporacion')); ?>:</b>
	<?php echo CHtml::encode($data->f_incorporacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('f_actualizacion')); ?>:</b>
	<?php echo CHtml::encode($data->f_actualizacion); ?>
	<br />
	*/ ?>

</div>