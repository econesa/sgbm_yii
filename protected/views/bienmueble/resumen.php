<?php
/* Desarrollado por Elisa Conesa <econesa@gmail.com>*/
/* @var $this BienmuebleController */
/* @var $model Bienmueble */

$this->breadcrumbs = array(
	'Inventario de Bienes' => array('index'),
	//$model->codigo=>array('view','id' => $model->id),
	'Resumen de Cuentas',
);

$this->menu = array(
	array('label'=>'Inventario de Bienes', 'url'=>array('index')),
	array('label'=>'Incorporar Bienmueble', 'url'=>array('create')),
);
?>

<h1>Resumen de Cuentas</h1>

<div class="">
<table>
	<tr>
		<th>Dependencia</th><th>Cantidad Total</th><th>Valor Total</th>
	</tr>
<?php 
$ct=0; $vt=0;
foreach ($data as $dato) :
	echo '<tr>';
	echo '<td>'.$dato['dependencia'].'</td>';
	echo '<td style="text-align:right;">'.$dato['cantidad_total'].'</td>';
	echo '<td style="text-align:right;">'.number_format($dato['valor_total'],2,',',' ').'</td>';
	echo '</tr>';
	$ct += $dato['cantidad_total'];
	$vt += $dato['valor_total'];
endforeach;
echo '<tr>';
echo '<td style="border-top:2px solid black; text-align:right;"><b>Total</b></td>';
echo '<td style="border-top:2px solid black; text-align:right;">'.$ct.'</td>';
echo '<td style="border-top:2px solid black; text-align:right;">'.number_format($vt,2,',',' ').'</td>';
echo '</tr>';
?>
</table>

</div>