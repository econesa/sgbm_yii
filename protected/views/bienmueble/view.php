<?php
/* Desarrollado por Elisa Conesa <econesa@gmail.com>*/
/* @var $this BienmuebleController */
/* @var $model Bienmueble */

$this->breadcrumbs=array(
	'Inventario de Bienes'=>array('index'),
	$model->codigo,
);

$this->menu = array();
$i = 0;
$this->menu[$i++]	= array('label'=>'Inventario de Bienes', 'url'=>array('index'));
$this->menu[$i++]	= array('label'=>'Incorporar Bien', 'url'=>array('create'));
if ($acceso) :
	$this->menu[$i++]	= array('label'=>'Modificar Bien', 'url'=>array('update', 'id'=>$model->id));
	$this->menu[$i++]	= array('label'=>'Corregir Concepto', 'url'=>array('corregir', 'id'=>$model->id));
	$this->menu[$i++]	= array('label'=>'Otros Movimientos', 'url'=>array('mejorar', 'id'=>$model->id));
	if ($model->status_id == 1)
		$this->menu[$i++]	= array('label'=>'Desincorporar Bien', 'url'=>array('desincorporar', 'id'=>$model->id));
	else
		$this->menu[$i++]	= array('label'=>'Eliminar Bien', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'¿Está seguro seguro de que desea eliminar el bien #'.$model->codigo.' ?'));
endif;
?>

<h1>Detalles del Bien #<?php echo $model->codigo; ?></h1>

<?php 
	$img = $model->clasificacion->grupo.$model->clasificacion->subgrupo;
	$cls = $model->clasificacion->grupo.'-'.$model->clasificacion->subgrupo.'-'.
		$model->clasificacion->seccion.' : '.$model->clasificacion->descripcion;
?>

<table>
<tr><td rowspan="6" style="width:130px; align:center; vertical-align:top">
		<?php 	echo '<p style="margin-bottom:0;"><b>Nro. ID: </b><font style="font-size:12pt">'.$model->codigo.'</font></p>'; 
				echo CHtml::image('images/clases/'.$img.'0.png', 'Clasificacion'); 
				echo '<p style="margin-bottom:0;"><br/><b>Tipo: </b>'.$model->tipo->descripcion.'</p>';
		?>
	</td>
	<td><?php echo '<p style="margin-bottom:0;"><b>Descripci&oacute;n: </b></p>'; ?></td>
	<td><?php echo '<p style="margin-bottom:0;">'.$model->descripcion.'</p>'; ?></td>	
</tr>
<tr><td>
		<?php echo '<p><b>Clasificaci&oacute;n: </b></p>'; ?>
	</td>
	<td><?php echo '<p>'.$cls.'</p>'; ?></td>
</tr>
<tr><td>
		<?php echo '<p><b>Valor Unitario: </b></p>'; ?>
	</td>
	<td><?php echo '<p>'.number_format($model->valor_unitario,2,',',' ').'</p>'; ?></td>
</tr>
<tr><td>
		<?php echo '<p><b>Observaciones: </b></p>'; ?>
	</td>
	<td><?php echo '<p>'.$model->observaciones.'</p>'; ?></td>
</tr>
<?php
if ($model->factura_id > 1) : ?>
<tr><td><?php echo '<p><b>Nro. Factura: </b></p>'; ?></td>
	<td><?php echo '<p>'.$model->factura->numero.'</p>'; ?></td>
</tr>
<tr><td><?php echo '<p><b>Proveedor: </b></p>'; ?></td>
	<td><?php echo '<p>'.$model->factura->proveedor.'</p>'; ?></td>
</tr><?php
endif;
?>
<tr><td>
		<?php echo '<p><b>Fecha de Incorporaci&oacute;n: </b></p>'; ?>
	</td>
	<td><?php echo '<p>'.Yii::app()->dateFormatter->formatDateTime(
		CDateTimeParser::parse($model->f_incorporacion, "yyyy-MM-dd hh:mm:ss"),"medium","short").'</p>'; ?></td>
</tr>
<tr><td>
		<?php echo '<p><b>Status: </b></p>'; ?>
	</td>
	<td><?php 
		echo '<p>'.$model->status->descripcion.'</p>'; ?></td>
</tr>
</table>

<?php
if(Yii::app()->user->hasFlash('error')):?>
    <div class="flash-error" style="margin-bottom:0.5em;">
        <font style="color:red"><?php echo Yii::app()->user->getFlash('error'); ?></font>
    </div><?php 
endif;

echo '<h2>Hist&oacute;rico de Movimientos</h2>';
$this->widget('zii.widgets.grid.CGridView', 
  array(
    'dataProvider'=>$movimientos,
    'columns'=>array(
		array( 'name'=>'Fecha', 'value' => 'Yii::app()->dateFormatter->formatDateTime(
			CDateTimeParser::parse($data->fecha, "yyyy-MM-dd hh:mm:ss"),"medium","short")'),
		array( 'name'=>'Dependencia', 'value' => '$data->dependencia->descripcion'),
		array( 'name'=>'Concepto de Movimiento', 'value' => '$data->concepto->descripcion'),
    ),
  )
);
?>
