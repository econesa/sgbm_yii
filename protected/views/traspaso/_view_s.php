<div class="view">

	<b><?php echo CHtml::encode('Receptor'); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->receptor->dependencia->descripcion), 
		array('view', 'id'=>$data->id)); 
	?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status_id')); ?>:</b>
	<?php 
		switch($data->status->id) 
		{
			case 1:
				echo '<font style="color:red">Esperando confirmación</font>';
				break;
			case 2:
				echo '<font style="color:green">'.CHtml::encode($data->status->descripcion).'</font>';
				break;
			case 3:
				echo '<font style="color:gray">'.CHtml::encode($data->status->descripcion).'</font>';
				break;
		}
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
