<h1>Crear Relaci&oacute;n de Bienes Faltantes</h1>
<h2>Paso 2: Especificar Bienes Muebles Faltantes</h2>
<?php 
	echo $this->renderPartial('_search_bm', 
		array('bien'=>$bien, 'fbmid'=>$_GET['id'] )); 
?>

<div style="background-color:#CDE; padding: 5px; text-align:right;">
	<div id="data" style="min-height:100px;">
	   <?php 
	   $this->renderPartial('_content'); 
	   ?>
	</div>
 
	<?php 
	$options = array(
		'update' => '#data2', 'type'=>'post',
		'data'=>array( 'fbmid'=>$_GET['id'] ),
		// 'beforeSend' => 'function(){$("#data").addClass("loading");}',
		// 'complete' => 'function(){$("#data").removeClass("loading");}',
	);
			
	echo CHtml::ajaxButton('Agregar', CController::createUrl('fbm3/AgregarAjax'),
		$options,
		array('class'=>'button blue') // 'confirm'=>"p?"	
	);
	?>
</div>
<div style="margin:10px 0">
	<div class="table-grey" style="min-height:150px">
		<h2>Bienes Muebles Adscritos</h2>
			<div id="data2">
				<?php $this->renderPartial('_content2'); ?>
			</div>
	</div>
	<script>
	function prueba() {
		<?php 
		echo CHtml::ajax(array(
			'type'=>'POST', 'url'=>array("fbm3/ActualizarAjax"), 
			'update'=>'#data2', 
			'data'=>array('fbmid'=>$_GET['id']))
		);
		?>
	}
	prueba();
	</script>
</div>
<div class="right">
<?php
//echo CHtml::button('Cancelar', array('submit' => array('delete', 'id'=>$_GET['id']))).' '; 
$imghtml=CHtml::image('images/no_med.png','Cancelar', array('title'=>'Cancelar'));
echo CHtml::link($imghtml, array('delete', 'id'=>$_GET['id'])).'&nbsp;&nbsp;&nbsp;&nbsp;';
	
//echo CHtml::button('Siguiente', array('submit' => array('formBm3/generar','id'=>$_GET['id'] ))); 
$imghtml2=CHtml::image('images/Forward.png','Siguiente', array('title'=>'Siguiente'));
echo CHtml::link($imghtml2, array('fbm3/generar','id'=>$_GET['id']));
?>
</div>
<br/>