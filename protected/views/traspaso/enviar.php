
<h1>Traspaso de Bienes Muebles</h1>
<h2 style="margin-bottom:0px;">Paso 2: Verificar Datos del Traspaso</h2>
<div class="header2">
	Antes de completar la solicitud del traspaso, verifique si la información mostrada es correcta. En caso positivo, presione <i>Guardar</i>. Tambi&eacute;n, puede presionar <i>Atr&aacute;s</i> para adscribir m&aacute;s bienes o puede presionar <i>Modificar</i> para cambiar la fecha del acta.
</div>
<br/>
<fieldset>
<?php	
echo "<p style=\"text-align:justify;\">Hoy, <b>{$data['fecha']}</b>, siendo las <b>{$data['hora']}</b> reunidos en la Sede de la <b>{$data['sede']}</b>, ubicada en la {$data['direccion']}; yo, <b>{$data['emisor']}</b>, titular de la cédula de identidad Nº <b>{$data['emisor_ci']}</b>, en mi carácter de <b>{$data['emisor_cargo']}</b>, hago constar por medio de la presente la entrega de los Bienes adscritos {$data['dp_emisora_g']} <b>{$data['dp_emisora']}</b>, cuya descripción se pormenoriza a continuación:</p>";

echo $this->renderPartial('_table_bma', array('bienes'=>$bienes)); 

echo "<p style=\"text-align:justify;\">Yo, <b>{$data['receptor']}</b>, titular de la cédula de identidad Nº <b>{$data['receptor_ci']}</b>, en mi carácter de <b>{$data['receptor_cargo']}</b>, recibo los Bienes verificando el Nº de Identificación de la placa, la descripción y el valor que corresponde, quedando conforme con lo entregado; dichos Bienes se incorporan {$data['dp_receptora_g']} <b>{$data['dp_receptora']}</b>. Se levanta la presente acta a un solo tenor y en un mismo efecto. Es todo, se leyó y conforme firman:</p>";
?>
</fieldset>

<div class="operaciones">
	<div class="left">
		<?php 
		//echo CHtml::button('Atras', array('submit' => array('agregar', 'id'=>$id))).' ';
		$imghtml=CHtml::image('images/Back.png','Atras', array('title'=>'Atras'));
		echo CHtml::link($imghtml, array('create')).'&nbsp;&nbsp;&nbsp;';
		//echo CHtml::button('Modificar Destinatario y Fecha', array('submit' => array('update','id'=>$id, 'generando'=>1))).'<br/>';
		//$imghtml2=CHtml::image('images/Modify.png','Modificar', array('title'=>'Modificar Destinatario y Fecha'));
		//echo CHtml::link($imghtml2, array('update','id'=>$model->id, 'generando'=>1)).'&nbsp;';
		?>
	</div>
	<div class="right">
	<?php 
		//echo CHtml::button('Cancelar', array('submit' => array('delete', 'id'=>$id))).' '; 
		$imghtml2=CHtml::image('images/no_mini.png','Cancelar', array('title'=>'Cancelar'));
		echo CHtml::link($imghtml2, array('delete', 'id'=>$model->id)).'&nbsp;&nbsp;&nbsp;';
		//echo CHtml::button('Guardar', array('submit' => array('enviar', 'id'=>$id),
		//	'confirm'=>'¿Está seguro que desea crear y enviar el acta?')); 
	
		$form=$this->beginWidget('CActiveForm', array(
			'id'=>'bm-traspaso-form',
			'enableAjaxValidation'=>false,
		));
	
		echo $form->hiddenField($model,'id',array('tid'=>$model->id));
	
		echo CHtml::imageButton('images/Apply.png', array('title'=>'Guardar'), array('confirm'=>'¿Está seguro que desea crear y enviar el acta?' )); 
		$this->endWidget();
	?>
	</div>
</div>





