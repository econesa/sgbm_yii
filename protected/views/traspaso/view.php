<?php
/* @var $this TraspasoController */
/* @var $model BmTraspaso */

$this->breadcrumbs=array(
	'Traspasos de Bienes'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Listar Traspasos', 'url'=>array('index')),
	array('label'=>'Iniciar Traspaso', 'url'=>array('create')),
	array('label'=>'Eliminar Traspaso', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<?php 
if(Yii::app()->user->hasFlash('error')):?>
    <div class="info">
        <font style="color:red"><?php echo Yii::app()->user->getFlash('error'); ?></font>
    </div>
<?php endif;
if(Yii::app()->user->hasFlash('success')):?>
    <div class="info">
        <font style="color:green"><?php echo Yii::app()->user->getFlash('success'); ?></font>
    </div>
<?php endif;
?>
<h1>Detalles de Traspaso de Bienes Muebles</h1>
<p>A continuación, se muestra una vista previa del acta.</p>

<fieldset>
<?php	
echo "<p style=\"text-align:justify;\">Hoy, <b>{$data['fecha']}</b>, siendo las <b>{$data['hora']}</b> reunidos en la Sede de la <b>{$data['sede']}</b>, ubicada en la {$data['direccion']}; yo, <b>{$data['emisor']}</b>, titular de la cédula de identidad Nº <b>{$data['emisor_ci']}</b>, en mi carácter de <b>{$data['emisor_cargo']}</b>, hago constar por medio de la presente la entrega de los Bienes adscritos {$data['dp_emisora_g']} <b>{$data['dp_emisora']}</b>, cuya descripción se pormenoriza a continuación:</p>";

echo $this->renderPartial('_table_bma', array('bienes'=>$bienes)); 

echo "<p style=\"text-align:justify;\">Yo, <b>{$data['receptor']}</b>, titular de la cédula de identidad Nº <b>{$data['receptor_ci']}</b>, en mi carácter de <b>{$data['receptor_cargo']}</b>, recibo los Bienes verificando el Nº de Identificación de la placa, la descripción y el valor que corresponde, quedando conforme con lo entregado; dichos Bienes se incorporan {$data['dp_receptora_g']} <b>{$data['dp_receptora']}</b>. Se levanta la presente acta a un solo tenor y en un mismo efecto.</p>";
?>
</fieldset>
<br/>
<div class="list">
<p>Seleccione una Operación</p>
<ul>
<?php 
if ( $model->status_id==2 ) {
	echo '<li>'.CHtml::link('Modificar Traspaso', array('update','id'=>$model->id)).'</li>';
}
if ( $model->status_id!=3 ) {
	echo '<li>'.CHtml::link('Eliminar Traspaso', array('delete','id'=>$model->id),
			array('confirm'=>'¿Está seguro que desea eliminar esta acta?')).'</li>';
	echo '<li>'.CHtml::link('Ir a Traspasos Pendientes', array('index')).'</li>';
	echo '<li>'.CHtml::link('Ir a Historial de Traspasos', array('list')).'</li>';
} 
else { 
	echo '<li>'.CHtml::link('Imprimir Acta', array('imprimir','id'=>$model->id)).'</li>';
	echo '<li>'.CHtml::link('Anular', array('anular','id'=>$model->id),
		array('confirm'=>'¿Está seguro que desea anular esta acta?, se eliminaran los cambios realizados')).'</li>';
	echo '<li>'.CHtml::link('Eliminar (No Anula Traspaso)', array('delete','id'=>$model->id),
		array('confirm'=>'¿Está seguro que desea eliminar esta acta?, se borrará el acta pero la ubicación de los bienes no seran modificada')).'</li>';
} 
?>
</ul>
</div>
