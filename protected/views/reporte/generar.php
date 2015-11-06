<?php
$this->breadcrumbs=array(
	'Reportes'=>array('index'),
	$model->descripcion,
);
?>

<h1><?php echo $model->descripcion; ?></h1>

<p>Seleccione mes y a&ntilde;o del inventario que desea generar:</p>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'fbm-index-form', 'enableAjaxValidation'=>false, 'enableClientValidation'=>true,
	'htmlOptions'=>array('enctype'=>'multipart/form-data','name'=>'fbm','target'=>'_blank'),
)); 
 
	//echo $form->errorSummary($model); 
	/*
	if ( Yii::app()->user->isAdminBm ) { 
		echo $form->labelEx($model,'dependencia_id'); 
		$list = Chtml::listData($dps, 'id', 'descripcion'); 
		echo CHtml::dropDownList('FormBm1[dependencia_id]', $model->dependencia_id, $list,
              array('empty' => '(Selecciona una)'));
		echo $form->error($model,'dependencia_id'); 
	}
	*/
?>
	<div class="row">
		<?php 
		echo $form->labelEx($model,'mes_id'); 
		$list2 = Chtml::listData($meses, 'id', 'descripcion'); 
		echo $form->dropDownList($model, 'mes_id', $list2, array('empty' => '(Selecciona una)'));
		echo $form->error($model,'mes_id'); 
		?>
	</div>
	
	<div class="row">
		<?php 
		echo $form->labelEx($model,'anho');
		echo $form->dropDownList($model, 'anho', $anhos, array('empty' => '(Selecciona una)'));
		echo $form->error($model,'anho'); 
		?>
	</div>
	
	<?php if ($model->cod==1) :?>
	<div class="row">
	<?php 
	echo $form->checkBox($model,'informativo').' '.$model->getAttributeLabel('informativo') ;
	?>
	</div>
	<?php endif; ?>
		
	<div class="row buttons">
		<?php echo CHtml::submitButton('Generar', array('class'=>'button blue')); ?>
	</div>
	
	<p class="note">Campos se&ntilde;alados con <span class="required">*</span> son obligatorios.</p>

<?php $this->endWidget(); ?>

</div><!-- form -->
