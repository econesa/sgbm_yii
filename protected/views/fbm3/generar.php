<h1>Crear Relaci&oacute;n de Bienes Faltantes</h1>
<h2>Paso 3: Verificar Datos del Formulario</h2>

<p>
Ha completado el reporte de bienes muebles faltantes. <br/>
Por favor, verifique si los datos son correctos y, en caso afirmativo, confirme.
</p>

<?php 
echo '<p>Responsable: '.$model->responsable->persona->pdata->nombre.'</p>';
//echo '<p>'.$model->observador->pdata->nombre.'</p>';


echo $this->renderPartial('_table_bma', array('bienes'=>$bienes)); 
?>
<br/>

<div class="operaciones">
	<div class="left">
	<?php 
	$imghtml=CHtml::image('images/Back.png','Atras', array('title'=>'Atras'));
	echo CHtml::link($imghtml, array('adscribir', 'id'=>$id)).'&nbsp;&nbsp;&nbsp;';
	?>
	</div>
	<div class="right">
	<?php 
	$imghtml2=CHtml::image('images/no_mini.png','Cancelar', array('title'=>'Cancelar'));
	echo CHtml::link($imghtml2, array('delete', 'id'=>$model->id)).'&nbsp;&nbsp;&nbsp;';
	//$imghtml3=CHtml::image('images/Apply.png','Guardar', array('title'=>'Guardar'));
	//echo CHtml::link($imghtml3, array('confirmar', 'id'=>$model->id), array('confirm'=>'¿Está seguro que desea crear este formulario B.M.3?' )).'&nbsp;';
	
	$form = $this->beginWidget('CActiveForm', array(
		'id'=>'fbm3-form',
		'enableAjaxValidation'=>false,
	));

	echo $form->hiddenField($model,'id',array('fmbid'=>$model->id));

	echo CHtml::imageButton('images/Apply.png', array('title'=>'Guardar'), 
		array('confirm'=>'¿Está seguro que desea crear este formulario B.M.3?', 'class'=>'button green' )); 
	$this->endWidget();
	
	?>
	</div>
</div>

