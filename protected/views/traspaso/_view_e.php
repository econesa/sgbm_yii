<div class="view">

	<b><?php echo CHtml::encode('Emisor'); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->emisor->dependencia->descripcion), 
		array('confirmar', 'id'=>$data->id)); 
	?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha')); ?>:</b>
	<?php echo Yii::app()->dateFormatter->formatDateTime(
                 CDateTimeParser::parse(
                     $data->fecha, 'yyyy-MM-dd hh:mm:ss'
                 ),
                 'medium',''
             ); ?>
	<br />

</div>
