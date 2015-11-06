<?php
/* Desarrollado por Elisa Conesa <econesa@gmail.com> */
/* @var $this TraspasoController */
/* @var $model BmTraspaso */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'bm-traspaso-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php 
		echo $form->labelEx($model,'emisor_id');
		echo $emisores['descripcion'];		
		//	$list = Chtml::listData($emisores, 'id', 'descripcion'); 
		//	echo $form->dropDownList($model,'emisor_id', $list, array('prompt'=>'Selecciona una'));		
        echo $form->error($model,'emisor_id'); 
		?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'receptor_id'); 
		$list2 = Chtml::listData($receptores, 'id', 'descripcion'); 
		echo $form->dropDownList($model,'receptor_id', $list2, array('prompt'=>'Selecciona una'));
		echo $form->error($model,'receptor_id'); ?>
	</div>
	
	<div class="row">
		<?php 
		echo $form->labelEx($model,'fecha');
		$this->widget('application.extensions.timepicker.EJuiDateTimePicker',
				array(
					'model'=> $model,	'attribute' => 'fecha',
					'language' => 'es',
					'value' => $model->fecha,
					'options' => array(//yy-mm-dd 
						'dateFormat' => 'yy-mm-dd',		'timeFormat' => 'hh:mm',
						'constrainInput' => 'false',	'changeYear' => 'true',
						'duration' => 'fast',			'showAnim' => 'slide',
						'timeText' => 'Hora',
						'hourText' => 'Horas',
						'minuteText' => 'Min.',		
					),
				)
			);
			echo $form->error($model,'fecha');
		?>
	</div>
	
	<fieldset>
		<legend>Bienes Adscritos</legend>
		<div class="row">
			<?php 
			echo $form->label($bien,'codigo'); 
			echo $form->textField($bien,'codigo',array('size'=>10,'maxlength'=>6)).' &nbsp;';
			
			$options = array(
	            'update' => '#data', 'type'=>'post',
	            'data'=>array(
	            	'codigo'=>'js:function() { return $("#Bienmueble_codigo").val(); }',
	            ),
			);
			echo CHtml::ajaxButton('Buscar', CController::createUrl('traspaso/SearchAjax'), $options, array('class'=>'button grey'));
			?>
		</div>

		<div id="data" style="min-height:100px">
		   <?php 
		   $this->renderPartial('_ajaxContent');
		   ?>
		</div>
		
		<?php 

		$options2 = array(
		    'update' => '#data2', 'type'=>'post',
		    'data'=>array(
		    	//'ebmid'=>$_GET['id']
		    ),
		);

		echo CHtml::ajaxButton('Agregar', CController::createUrl('traspaso/adscribirAjax'), $options2, array('class'=>'button grey'));
		?>
		<div style="margin:10px 0">
		<div class="table-grey" style="min-height:150px">
			<h2>Bienes Muebles Adscritos</h2>
			<table class="items">
				<thead>
				<tr><th colspan="3" style="text-align:center;">Clasificacion</th>
					<th rowspan="2" style="text-align:center;">Placa</th>
					<th rowspan="2" style="text-align:center;">Descripcion</th>
					<th rowspan="2" style="text-align:center;">Cantidad</th>
					<th rowspan="2" style="text-align:center;">Valor Unitario</th>
					<th rowspan="2"></th>
				</tr>
				<tr><th style="text-align:center;">Grupo</th>
					<th style="text-align:center;">SubGrupo</th>
					<th style="text-align:center;">Seccion</th>
				</tr>
				</thead>
				<tbody id="data2">
					<?php $this->renderPartial('_ajaxContent2'); ?>
				</tbody>
			</table>
			<script>
			function prueba() {
				<?php 
				echo CHtml::ajax(array(
					'type'=>'POST', 
					'url'=>array("traspaso/actualizarAjax"), 
					'update'=>'#data2', 
					'data'=>array()
				));
				?>
			}
			prueba();
			</script>
		</div>
		
	</fieldset>

	<div class="row buttons">
		<?php 
		echo CHtml::link('Cancelar', array('delete', 'id'=>$model->id),  array('class'=>'button red')).'&nbsp;&nbsp;&nbsp;';
		
		echo CHtml::submitButton('Siguiente', array('class'=>'button blue')); 
		?>
	</div>
	
	<p class="note">Campos se&ntilde;alados con <span class="required">*</span> son obligatorios.</p>

<?php $this->endWidget(); ?>

</div><!-- form -->