<?php
/* @var $this UsuarioController */
/* @var $model Usuario */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('username')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->username), array('view', 'id'=>$data->id)); ?>
	<br />

	<?php 
	echo '<b>'.CHtml::encode($data->getAttributeLabel('rol_id')).':</b> ';
	echo CHtml::encode($data->rol->descripcion); ?>
	<br />
	
</div>
