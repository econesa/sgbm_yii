<?php
/* @var $this PersonaController */
/* @var $model Persona */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

<div class="searchbox">
<h4>B&uacute;squeda</h4>
	<div class="row">
		<?php
			echo $form->labelEx($model,'sexo_id');
			$list = Chtml::listData($genero, 'id', 'descripcion'); 
			echo $form->dropDownList($model,'sexo_id', $list, array('prompt'=>'CUALQUIERA'));
		?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Buscar', array('class'=>'button blue')); ?>
	</div>
</div>

<?php $this->endWidget(); ?>


</div><!-- search-form -->