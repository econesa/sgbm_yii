<?php
/* @var $this Fbm3Controller */
/* @var $model Fbm3 */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'fbm3-form',
	'enableClientValidation'=>true,
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Campos se&ntilde;alados con <span class="required">*</span> son obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'comprobante'); ?>
		<?php echo $form->textField($model,'comprobante',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'comprobante'); ?>
	</div>

	<fieldset>
	<legend>Persona que determin&oacute; los faltantes</legend>
	<div class="row buttons">
		<?php
		echo $form->labelEx($model->observador->pdata,'cedula');
		echo $form->textField($model->observador->pdata,'cedula',array('size'=>20,'maxlength'=>20));
		echo ' '.CHtml::button('Buscar', array( 'onclick'=>"{cargarPersona();}", 'class'=>'button green' ) );
		echo $form->error($model->observador->pdata,'cedula');
	    ?>
		<script type="text/javascript">
		function cargarPersona() {
		    <?php 
		    echo CHtml::ajax(array(
		        'url'=>CController::createUrl('fbm3/buscarAjax'), 
		        // Data to be passed to the ajax function
		        // The field id should be prefixed with: ModelName_fieldName
		        'data'=>array('cedula'=>'js:$(\'#PersonaData_cedula\').val()', 
			),
		    'type'=>'post',
		    'dataType'=>'json',
		    'success'=>"function(data) {
		       // data will contain the json data passed by the action in the controller
				$('#PersonaData_nombre').val(data.value2);
			   	$('#PersonaData_profesion_id').val(data.value3).attr('selected',true);
				$('#PersonaData_sexo_id').val(data.value4).attr('selected',true);
			   	$('#Persona_dependencia_id').val(data.value5).attr('selected',true);
				$('#Persona_cargo_id').val(data.value6);
		    } ",
		    ))?>;
		    return false;  
		} 
		</script>
	</div>
	<div class="row">
		<?php
		echo $form->labelEx($model->observador->pdata,'nombre');
		//echo $form->hiddenField($model,'observador_id', NULL);
		echo $form->textField($model->observador->pdata,'nombre',array('size'=>60,'maxlength'=>60));
		echo $form->error($model->observador->pdata,'nombre');
	    ?>
	</div>
	<div class="row">
		<?php
		$list = Chtml::listData($generos, 'id', 'descripcion'); 
		echo $form->labelEx($model->observador->pdata,'sexo_id');
		echo $form->dropDownList($model->observador->pdata,'sexo_id', $list, array('prompt'=>'Selecciona una'));
		echo $form->error($model->observador->pdata,'sexo_id');
	    ?>
	</div>
	<div class="row">
	    <?php
		$list = Chtml::listData($profesiones, 'id', 'descripcion'); 
		echo $form->labelEx($model->observador->pdata,'profesion_id');
		echo $form->dropDownList($model->observador->pdata,'profesion_id', $list, array('prompt'=>'Selecciona una'));
		echo $form->error($model->observador->pdata,'profesion_id'); 
	    ?>
	</div>
	<div class="row">
		<?php
		/*
		echo $form->labelEx($model->observador->cargo, 'descripcion');
		echo $form->textField($model->observador->cargo,'descripcion',array('size'=>60,'maxlength'=>80));
		echo $form->error($model->observador->cargo,'descripcion');
		*/
		$list2 = Chtml::listData($cargos, 'id', 'descripcion'); 
		echo $form->labelEx($model->observador,'cargo_id');
		echo $form->dropDownList($model->observador,'cargo_id', $list2, array('prompt'=>'Selecciona una'));
		echo $form->error($model->observador,'cargo_id');
	    ?>
	</div>
	<div class="row">
		<?php
		$list3 = Chtml::listData($dps, 'id', 'descripcion'); 
		echo $form->labelEx($model->observador,'dependencia_id');
		echo $form->dropDownList($model->observador,'dependencia_id', $list3, array('prompt'=>'Selecciona una'));
		echo $form->error($model->observador,'dependencia_id');
	    ?>
	</div>
	</fieldset>
	
	<div class="row">
		<?php
		echo $form->labelEx($model,'responsable_id');
		$list3 = Chtml::listData($responsables, 'id', 'persona.pdata.nombre'); 
		echo $form->dropDownList($model,'responsable_id', $list3, array('prompt'=>'Selecciona una'));
		?>	
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'observaciones'); ?>
		<?php echo $form->textArea($model,'observaciones',array('maxlength'=>100, 'rows'=>10,'cols'=>80,)); ?>
		<?php echo $form->error($model,'observaciones'); ?>
	</div>

	<div class="row">
		<?php 
		echo $form->labelEx($model,'fecha');
		$this->widget('application.extensions.timepicker.EJuiDateTimePicker',
				array(
					'model'=> $model,	'attribute' => 'fecha',			
					'language' => 'es',	'value' => $model->fecha,
					'options' => array(
						'dateFormat' => 'yy-mm-dd',		'timeFormat' => 'hh:mm',
						'constrainInput' => 'false',	'changeYear' => 'true',
						'duration' => 'fast',			'showAnim' => 'slide',
						'timeText' => 'Hora',			'hourText' => 'Horas',
						'minuteText' => 'Min.',		
					),
				)
			);
			echo $form->error($model,'fecha');
		?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar', array('class'=>'button green')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->