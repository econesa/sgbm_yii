<div class="table-grey">
<table class="items">
<thead>
<tr>
<th colspan="3" style="text-align:center;">Clasificacion</th>
<th rowspan="2" style="text-align:center;">Placa</th>
<th rowspan="2" style="text-align:center;">Descripcion</th>
<th rowspan="2" style="text-align:center;">Cantidad</th>
<th rowspan="2" style="text-align:center;">Valor Unitario</th>
</tr>
<tr>
<th style="text-align:center;">Grupo</th>
<th style="text-align:center;">SubGrupo</th>
<th style="text-align:center;">Seccion</th>
</tr>
</thead>
<tbody>
<?php 
$cantidad_total = 0;
$valor_total = 0;
		
foreach( $bienes as $bien) { 
	$cantidad_total += $bien->bienmueble->cantidad;
	$valor_total += $bien->bienmueble->valor_unitario;
?>
<tr>
<td style="text-align:center;"><p><?php echo $bien->bienmueble->clasificacion->grupo; ?></p></td>
<td style="text-align:center;"><p><?php echo $bien->bienmueble->clasificacion->subgrupo; ?></p></td>
<td style="text-align:center;"><p><?php echo $bien->bienmueble->clasificacion->seccion; ?></p></td>
<td style="text-align:center; width:40px;"><p><?php echo $bien->bienmueble->codigo; ?></p></td>
<td><p><?php echo CHtml::encode($bien->bienmueble->descripcion); ?></p></td>
<td style="text-align:center;"><p><?php echo $bien->bienmueble->cantidad; ?></p></td>
<td style="text-align:right;"><p><?php echo sprintf("%.2F", $bien->bienmueble->valor_unitario); ?></p></td>
</tr>
<?php } ?>
<tr>
	<td colspan="5" style="text-align:right;">Total:</td>
	<td style="text-align:center;"><p><?php echo $cantidad_total; ?></p></td>
	<td style="text-align:right;">
		<p><?php echo sprintf("%.2F", $valor_total);?></p>
	</td>
</tr>
</tbody>
</table>
</div>