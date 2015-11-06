<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'post',
)); ?>

	<div class="row">
		<?php 
		echo $form->label($bien,'codigo'); 
		echo $form->textField($bien,'codigo',array('size'=>6,'maxlength'=>7));
		?>
	</div>

	<div class="row buttons">
		<?php
		echo CHtml::ajaxButton('Buscar', CController::createUrl('updateAjax'),
			array(
				'update' => '#data', 'type'=>'post',
				'data'=>array(
					'codigo'=>'js:function() { return $("#Bienmueble_codigo").val(); }',
					'fbmid'=>$fbmid
				),
			   // 'beforeSend' => 'function(){$("#data").addClass("loading");}',
			   // 'complete' => 'function(){$("#data").removeClass("loading");}',
			),
			array('class'=>'button blue')
			//,array('confirm'=>"p?")	
		);
		?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->